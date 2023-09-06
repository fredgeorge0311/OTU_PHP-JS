<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our licensing model, this program can be used
 * under the terms of the GNU Affero General Public License, version 3.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission can be found at and in the LICENSE file you have received
 * along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore, any rights, title and interest in
 * our trademarks remain entirely with the shopware AG.
 */

namespace Shopware\Bundle\StoreFrontBundle\Gateway;

use Shopware\Bundle\StoreFrontBundle\Struct\Customer\Group;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceGroup;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

interface PriceGroupDiscountGatewayInterface
{
    /**
     * The \Shopware\Bundle\StoreFrontBundle\Struct\Product\PriceGroup requires the following data:
     * - Price group base data
     * - Price group discounts for the provided customer group
     *
     * @return array<int, PriceGroup> Indexed by the price group id
     */
    public function getPriceGroups(Group $customerGroup, ShopContextInterface $context);
}
