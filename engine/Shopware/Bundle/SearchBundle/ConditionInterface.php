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

namespace Shopware\Bundle\SearchBundle;

/**
 * Defines a condition which can be added to the
 * \Shopware\Bundle\SearchBundle\Criteria class.
 *
 * Each condition is handled by his own condition handler
 * which defined in the specify gateway engines.
 */
interface ConditionInterface extends CriteriaPartInterface
{
    public const OPERATOR_EQ = '=';
    public const OPERATOR_NEQ = '!=';
    public const OPERATOR_LT = '<';
    public const OPERATOR_LTE = '<=';
    public const OPERATOR_GT = '>';
    public const OPERATOR_GTE = '>=';
    public const OPERATOR_IN = 'IN';
    public const OPERATOR_BETWEEN = 'BETWEEN';
    public const OPERATOR_NOT_BETWEEN = 'NOT BETWEEN';
    public const OPERATOR_NOT_IN = 'NOT IN';
    public const OPERATOR_STARTS_WITH = 'STARTS_WITH';
    public const OPERATOR_ENDS_WITH = 'ENDS_WITH';
    public const OPERATOR_CONTAINS = 'CONTAINS';
}
