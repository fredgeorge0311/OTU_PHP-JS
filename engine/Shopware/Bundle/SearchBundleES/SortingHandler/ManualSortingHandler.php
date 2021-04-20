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

namespace Shopware\Bundle\SearchBundleES\SortingHandler;

use ONGR\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use Shopware\Bundle\SearchBundle\Condition\CategoryCondition;
use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\CriteriaPartInterface;
use Shopware\Bundle\SearchBundle\Sorting\ManualSorting;
use Shopware\Bundle\SearchBundleES\HandlerInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class ManualSortingHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(CriteriaPartInterface $criteriaPart)
    {
        return $criteriaPart instanceof ManualSorting;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(
        CriteriaPartInterface $criteriaPart,
        Criteria $criteria,
        Search $search,
        ShopContextInterface $context
    ) {
        if (!$criteria->hasBaseCondition('category')) {
            return;
        }

        /** @var CategoryCondition $categoryCondition */
        $categoryCondition = $criteria->getBaseCondition('category');

        $categoryId = $categoryCondition->getCategoryIds()[0];

        // Elasticsearch DSL does not support the new format
        // @see: https://www.elastic.co/guide/en/elasticsearch/reference/6.8/search-request-sort.html#_nested_sorting_examples
        $fieldSort = new FieldSort('manualSorting.position', strtolower($criteriaPart->getDirection()), [
            'unmapped_type' => 'integer',
            'nested' => [
                'path' => 'manualSorting',
                'filter' => (new TermsQuery('manualSorting.category_id', [$categoryId]))->toArray(),
            ],
        ]);

        /* @var ManualSorting $criteriaPart */
        $search->addSort(
            $fieldSort
        );
    }
}
