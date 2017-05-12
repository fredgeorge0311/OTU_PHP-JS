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

//{namespace name=backend/custom_search/translation}

//{block name="backend/config/view/custom_search/facet/classes/width"}

Ext.define('Shopware.apps.Config.view.custom_search.facet.classes.WidthFacet', {

    getClass: function() {
        return 'Shopware\\Bundle\\SearchBundle\\Facet\\WidthFacet';
    },

    createItems: function () {
        return [{
            xtype: 'textfield',
            name: 'label',
            labelWidth: 150,
            translatable: true,
            fieldLabel: '{s name="label"}{/s}'
        }, {
            xtype: 'textfield',
            name: 'format',
            labelWidth: 150,
            translatable: true,
            fieldLabel: '{s name="format"}{/s}',
            helpText: '{s name="format_help"}{/s}'
        }, {
            xtype: 'numberfield',
            name: 'digits',
            maxValue: 3,
            minValue: 0,
            labelWidth: 150,
            translatable: true,
            value: 3,
            fieldLabel: '{s name="digits"}{/s}',
            helpText: '{s name="digits_help"}{/s}'
        }];
    }
});

//{/block}
