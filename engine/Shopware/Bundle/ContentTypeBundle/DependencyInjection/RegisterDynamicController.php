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

namespace Shopware\Bundle\ContentTypeBundle\DependencyInjection;

use Shopware\Bundle\ContentTypeBundle\Controller\Backend\ContentType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\ExpressionLanguage\Expression;

class RegisterDynamicController implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $types = $container->getParameter('shopware.bundle.content_type.types');

        foreach ($types as $name => $type) {
            $backendController = new Definition(ContentType::class);
            $backendController->setArguments([
                new Reference('shopware_bundle_content_type.services.extjs_builder'),
                new Expression('service("shopware.bundle.content_type.type_provider").getType("' . $name . '")'),
                new Reference('shopware.bundle.content_type.' . $name),
            ]);

            $backendController->addTag(
                'shopware.controller',
                [
                    'controller' => 'Custom' . ucfirst($name),
                    'module' => 'backend',
                ]
            );

            $container->setDefinition('shopware_bundle.content_type.controllers.backend.' . $name, $backendController);

            $apiController = new Definition(\Shopware\Bundle\ContentTypeBundle\Controller\Api\ContentType::class);
            $apiController->setArguments([
                new Reference('shopware.bundle.content_type.' . $name),
                new Reference('models'),
            ]);

            $apiController->addTag(
                'shopware.controller',
                [
                    'controller' => 'Custom' . ucfirst($name),
                    'module' => 'api',
                ]
            );

            $container->setDefinition('shopware_bundle.content_type.controllers.api.' . $name, $apiController);

            if (isset($type['showInFrontend'])) {
                $apiController = new Definition(\Shopware\Bundle\ContentTypeBundle\Controller\Frontend\ContentType::class);
                $apiController->setArguments([
                    new Reference('shopware.bundle.content_type.' . $name),
                    new Expression('service("shopware.bundle.content_type.type_provider").getType("' . $name . '")'),
                ]);

                $apiController->addTag(
                    'shopware.controller',
                    [
                        'controller' => 'Custom' . ucfirst($name),
                        'module' => 'frontend',
                    ]
                );

                $container->setDefinition('shopware_bundle.content_type.controllers.api.' . $name, $apiController);
            }
        }
    }
}
