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

namespace Shopware\Bundle\CustomerSearchBundle\ConditionHandler;

use Shopware\Bundle\CustomerSearchBundle\Condition\HasTotalOrderAmountCondition;
use Shopware\Bundle\CustomerSearchBundle\ConditionHandler\Common\AggregatedOrderTable;
use Shopware\Bundle\CustomerSearchBundle\ConditionHandlerInterface;
use Shopware\Bundle\SearchBundle\ConditionInterface;
use Shopware\Bundle\SearchBundleDBAL\QueryBuilder;

class HasTotalOrderAmountConditionHandler implements ConditionHandlerInterface
{
    /**
     * @var AggregatedOrderTable
     */
    private $aggregatedOrderTable;

    /**
     * @param AggregatedOrderTable $aggregatedOrderTable
     */
    public function __construct(AggregatedOrderTable $aggregatedOrderTable)
    {
        $this->aggregatedOrderTable = $aggregatedOrderTable;
    }

    /**
     * @param ConditionInterface $condition
     * @param QueryBuilder       $query
     */
    public function handle(ConditionInterface $condition, QueryBuilder $query)
    {
        /* @var HasTotalOrderAmountCondition $condition */
        $query->andWhere('customer.invoice_amount_sum >= :HasTotalOrderAmountCondition');
        $query->setParameter(':HasTotalOrderAmountCondition', $condition->getMinimumOrderAmount());
    }

    public function supports(ConditionInterface $condition)
    {
        return $condition instanceof HasTotalOrderAmountCondition;
    }
}
