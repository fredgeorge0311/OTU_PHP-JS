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

namespace Shopware\Bundle\SearchBundle\Facet;

use Shopware\Bundle\SearchBundle\FacetInterface;

/**
 * @category  Shopware
 *
 * @copyright Copyright (c) shopware AG (http://www.shopware.de)
 */
class VariantFacet implements FacetInterface
{
    /**
     * @var array
     */
    protected $groupIds;

    /**
     * @var array
     */
    protected $expandGroupsIds;

    /**
     * @param string|array      $groupIds
     * @param string|array|null $expandGroupIds
     */
    public function __construct($groupIds, $expandGroupIds = null)
    {
        if (is_string($groupIds)) {
            $groupIds = array_filter(explode('|', $groupIds));
        }
        $this->groupIds = $groupIds;

        if ($expandGroupIds === null) {
            $expandGroupIds = [];
        }

        if (is_string($expandGroupIds)) {
            $expandGroupIds = array_filter(explode('|', $expandGroupIds));
        }
        $this->expandGroupsIds = $expandGroupIds;
    }

    /**
     * @return array
     */
    public function getGroupIds()
    {
        return $this->groupIds;
    }

    /**
     * @return array
     */
    public function getExpandGroupIds()
    {
        return $this->expandGroupsIds;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'option';
    }
}
