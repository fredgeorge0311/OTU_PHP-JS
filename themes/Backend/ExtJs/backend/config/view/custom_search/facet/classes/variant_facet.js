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

//{block name="backend/config/view/custom_search/facet/classes/variant"}

Ext.define('Shopware.apps.Config.view.custom_search.facet.classes.VariantFacet', {

    getClass: function() {
        return 'Shopware\\Bundle\\SearchBundle\\Facet\\VariantFacet';
    },

    createItems: function () {
        var factory = Ext.create('Shopware.attribute.SelectionFactory');

        return [{
            xtype: 'shopware-form-field-grid',
            name: 'groupIds',
            searchStore: factory.createEntitySearchStore("Shopware\\Models\\Article\\Configurator\\Group"),
            store: factory.createEntitySearchStore("Shopware\\Models\\Article\\Configurator\\Group"),
            labelWidth: 150,
            translatable: true,
            fieldLabel: '{s name="available_groups"}{/s}'
        }];
    }
});

//{/block}
