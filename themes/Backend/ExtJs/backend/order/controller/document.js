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
 *
 * @category   Shopware
 * @subpackage Controller
 * @version    $Id$
 * @author shopware AG
 */

//{namespace name=backend/order/main}
//{block name="backend/order/controller/document"}
Ext.define('Shopware.apps.Order.controller.Document', {
    extend: 'Ext.app.Controller',

    /**
     * all references to get the elements by the applicable selector
     *
     * @type { Array }
     */
    refs: [
        { ref: 'listing', selector: 'order-list' },
        { ref: 'documentWindow', selector: 'order-detail-window' }
    ],

    /**
     * A template method that is called when your application boots.
     * It is called before the Application's launch function is executed
     * so gives a hook point to run any code before your Viewport is created.
     */
    init: function() {
        var me = this;

        me.control({
            'order-detail-window order-document-list': {
                'delete-document': me.onDeleteDocument,
                'open-mail': me.openMail
            }
        });

        me.callParent(arguments)
    },

    /**
     * Opens the window to send an email with a selected document to the customer.
     *
     * @param { Shopware.apps.Order.model.Receipt } record
     */
    openMail: function(record) {
        var me = this;

        var order = me.getDocumentWindow().record;
        var documentTypeStore = Ext.create('Shopware.apps.Order.store.DocType');

        // The window depends on a completely loaded documentTypeStore. So we load it here and open the window
        // after successful loading.
        documentTypeStore.load({
            scope: me,
            callback: function() {
                this.getView('mail.Window').create({
                    order: order,
                    preSelectedAttachment: record,
                    documentTypeStore: documentTypeStore,
                    listStore: this.listStore
                }).show();
            }
        });
    },

    /**
     * Calls a ajax request to delete a document.
     *
     * @param { Ext.grid.Panel } grid
     * @param { Ext.data.Model } record
     */
    onDeleteDocument: function(grid, record) {
        grid.getStore().remove(record);

        Ext.Ajax.request({
            url: '{url controller="order" action="deleteDocument"}',
            method: 'POST',
            params: {
                documentId: record.get('id')
            },
            success: function(response) {
                response = Ext.JSON.decode(response.responseText);
                if (!response.success) {
                    Shopware.Notification.createGrowlMessage(
                        '{s name=document/attachemnt/error}Error{/s}',
                        response.errorMessage
                    );
                }
            },
            failure: function(response) {
                Shopware.Notification.createGrowlMessage(
                    '{s name=document/attachemnt/error}Error{/s}',
                    response.status + '<br />' + response.statusText
                );
            }
        });
    },
});
//{/block}
