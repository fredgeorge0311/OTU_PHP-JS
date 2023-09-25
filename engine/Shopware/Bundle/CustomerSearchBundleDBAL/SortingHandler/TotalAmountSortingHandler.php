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

namespace Shopware\Bundle\CustomerSearchBundleDBAL\SortingHandler;

use Shopware\Bundle\CustomerSearchBundle\Sorting\TotalAmountSorting;
use Shopware\Bundle\CustomerSearchBundleDBAL\SortingHandlerInterface;
use Shopware\Bundle\SearchBundle\SortingInterface;
use Shopware\Bundle\SearchBundleDBAL\QueryBuilder;

class TotalAmountSortingHandler implements SortingHandlerInterface
{
    public function supports(SortingInterface $sorting)
    {
        return $sorting instanceof TotalAmountSorting;
    }

    public function handle(SortingInterface $sorting, QueryBuilder $query)
    {
        $this->addSorting($sorting, $query);
    }

    private function addSorting(TotalAmountSorting $sorting, QueryBuilder $query): void
    {
        $query->addOrderBy('customer.invoice_amount_sum', $sorting->getDirection());
    }
}
