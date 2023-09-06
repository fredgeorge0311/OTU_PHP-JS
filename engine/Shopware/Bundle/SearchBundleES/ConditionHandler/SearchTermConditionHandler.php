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

namespace Shopware\Bundle\SearchBundleES\ConditionHandler;

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;
use Shopware\Bundle\SearchBundle\Condition\SearchTermCondition;
use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\CriteriaPartInterface;
use Shopware\Bundle\SearchBundleES\PartialConditionHandlerInterface;
use Shopware\Bundle\SearchBundleES\SearchTermQueryBuilderInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class SearchTermConditionHandler implements PartialConditionHandlerInterface
{
    private SearchTermQueryBuilderInterface $queryBuilder;

    public function __construct(SearchTermQueryBuilderInterface $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(CriteriaPartInterface $criteriaPart)
    {
        return $criteriaPart instanceof SearchTermCondition;
    }

    /**
     * {@inheritdoc}
     */
    public function handleFilter(
        CriteriaPartInterface $criteriaPart,
        Criteria $criteria,
        Search $search,
        ShopContextInterface $context
    ) {
        $search->addQuery($this->getQuery($criteriaPart, $context));
    }

    /**
     * {@inheritdoc}
     */
    public function handlePostFilter(
        CriteriaPartInterface $criteriaPart,
        Criteria $criteria,
        Search $search,
        ShopContextInterface $context
    ) {
        $this->handleFilter($criteriaPart, $criteria, $search, $context);
    }

    private function getQuery(SearchTermCondition $criteriaPart, ShopContextInterface $context): BoolQuery
    {
        return $this->queryBuilder->buildQuery($context, $criteriaPart->getTerm());
    }
}
