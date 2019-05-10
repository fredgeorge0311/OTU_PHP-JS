<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace Shopware\Bundle\ContentTypeBundle\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Bundle\ContentTypeBundle\Services\RepositoryInterface;
use Shopware\Bundle\ContentTypeBundle\Services\TypeProvider;
use Shopware\Bundle\ContentTypeBundle\Structs\Criteria;
use Shopware\Bundle\ContentTypeBundle\Structs\Field;
use Shopware\Bundle\ContentTypeBundle\Structs\Type;

class EntitySearchSubscriber implements SubscriberInterface
{
    /**
     * @var TypeProvider
     */
    private $provider;

    public function __construct(TypeProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_Backend_EntitySearch_search' => 'onSearch',
        ];
    }

    public function onSearch(\Enlight_Event_EventArgs $args)
    {
        /** @var \Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $model = $controller->Request()->getParam('model');

        try {
            $type = $this->provider->getType($model);
        } catch (\RuntimeException $e) {
            return;
        }

        $label = $this->getLabelField($type);

        /** @var RepositoryInterface $repository */
        $repository = $controller->get('shopware.bundle.content_type.' . $type->getInternalName());

        $request = $controller->Request();

        $criteria = new Criteria();
        $criteria->offset = $request->getParam('start', 0);
        $criteria->limit = $request->getParam('limit', 0);
        $criteria->sort = $request->getParam('sorts', []);
        $criteria->filter = $request->getParam('filter', []);
        $criteria->loadTranslations = false;
        $criteria->loadAssociations = false;

        $result = $repository->findAll($criteria);
        $data = $result->items;

        foreach ($data as &$item) {
            $item['name'] = $item[$label->getName()];
        }

        unset($item);

        $controller->View()->assign('total', $result->total);
        $controller->View()->assign('data', $data);
        $controller->View()->assign('success', true);

        return true;
    }

    private function getLabelField(Type $type): Field
    {
        foreach ($type->getFields() as $item) {
            if ($item->isShowListing()) {
                return $item;
            }
        }

        throw new \RuntimeException(sprintf('Type %s needs a label', $type->getName()));
    }
}
