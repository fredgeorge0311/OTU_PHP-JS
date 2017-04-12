/* global Ext */
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

// {namespace name="backend/customer_stream/translation"}
Ext.define('Shopware.apps.Customer.view.customer_stream.conditions.OrderedWithPaymentCondition', {

    getLabel: function() {
        return '{s name="ordered_with_payment_condition"}{/s}';
    },

    supports: function(conditionClass) {
        return (conditionClass == 'Shopware\\Bundle\\CustomerSearchBundle\\Condition\\OrderedWithPaymentCondition');
    },

    create: function(callback) {
        callback(this._create());
    },

    load: function(conditionClass, items, callback) {
        callback(this._create());
    },

    _create: function() {
        var factory = Ext.create('Shopware.attribute.SelectionFactory');

        return {
            title: '{s name="ordered_with_payment_condition_selection"}{/s}',
            conditionClass: 'Shopware\\Bundle\\CustomerSearchBundle\\Condition\\OrderedWithPaymentCondition',
            items: [{
                xtype: 'shopware-form-field-payment-grid',
                name: 'paymentIds',
                flex: 1,
                allowSorting: false,
                useSeparator: false,
                allowBlank: false,
                store: factory.createEntitySearchStore('Shopware\\Models\\Payment\\Payment'),
                searchStore: factory.createEntitySearchStore('Shopware\\Models\\Payment\\Payment')
            }]
        };
    }
});
