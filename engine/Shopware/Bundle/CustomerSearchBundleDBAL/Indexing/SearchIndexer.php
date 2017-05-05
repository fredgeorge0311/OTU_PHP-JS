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

namespace Shopware\Bundle\CustomerSearchBundleDBAL\Indexing;

use Doctrine\DBAL\Connection;

class SearchIndexer implements SearchIndexerInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var CustomerProvider
     */
    private $provider;

    /**
     * @param Connection       $connection
     * @param CustomerProvider $provider
     */
    public function __construct(Connection $connection, CustomerProvider $provider)
    {
        $this->connection = $connection;
        $this->provider = $provider;
    }

    /**
     * @param int[] $ids
     */
    public function populate(array $ids)
    {
        $this->connection->transactional(function () use ($ids) {
            $insert = $this->createInsertQuery();
            $customers = $this->provider->get($ids);
            foreach ($customers as $customer) {
                $insert->execute($this->buildData($customer));
            }
        });
    }

    public function clearIndex()
    {
        $this->connection->executeUpdate('DELETE FROM s_customer_search_index');
    }

    public function cleanupIndex()
    {
        $this->connection->executeUpdate('
            DELETE search_index FROM s_customer_search_index search_index
            LEFT JOIN s_user customer
                ON customer.id = search_index.id
            WHERE customer.id IS NULL
        ');
    }

    /**
     * @param $customer
     *
     * @return array
     */
    protected function buildData(AnalyzedCustomer $customer)
    {
        $data = [
            'id' => $customer->getId(),
            'email' => $customer->getEmail(),
            'active' => $customer->getActive(),
            'accountmode' => $customer->getAccountMode(),
            'firstlogin' => $this->formatDate($customer->getFirstLogin()),
            'newsletter' => $customer->isNewsletter(),
            'shop_id' => $customer->getShopId(),
            'default_billing_address_id' => $customer->getDefaultBillingAddressId(),
            'title' => $customer->getTitle(),
            'salutation' => $customer->getSalutation(),
            'firstname' => $customer->getFirstname(),
            'lastname' => $customer->getLastname(),
            'birthday' => $this->formatDate($customer->getBirthday()),
            'customernumber' => $customer->getNumber(),
            'customer_group_id' => $customer->getCustomerGroup()->getId(),
            'customer_group_name' => $customer->getCustomerGroup()->getName(),
            'payment_id' => $customer->getPaymentId(),
            'company' => $customer->getBillingAddress()->getCompany(),
            'department' => $customer->getBillingAddress()->getDepartment(),
            'street' => $customer->getBillingAddress()->getStreet(),
            'zipcode' => $customer->getBillingAddress()->getZipcode(),
            'city' => $customer->getBillingAddress()->getCity(),
            'phone' => $customer->getBillingAddress()->getPhone(),
            'additional_address_line1' => $customer->getBillingAddress()->getAdditionalAddressLine1(),
            'additional_address_line2' => $customer->getBillingAddress()->getAdditionalAddressLine2(),
            'country_id' => $customer->getBillingAddress()->getCountryId(),
            'country_name' => $customer->getBillingAddress()->getCountry() ? $customer->getBillingAddress()->getCountry()->getName() : '',
            'state_id' => $customer->getBillingAddress()->getStateId(),
            'age' => $customer->getAge(),
            'count_orders' => $customer->getOrderInformation()->getOrderCount(),
            'product_avg' => $customer->getOrderInformation()->getAvgProductPrice(),
            'invoice_amount_sum' => $customer->getOrderInformation()->getTotalAmount(),
            'invoice_amount_avg' => $customer->getOrderInformation()->getAvgAmount(),
            'invoice_amount_min' => $customer->getOrderInformation()->getMinAmount(),
            'invoice_amount_max' => $customer->getOrderInformation()->getMaxAmount(),
            'first_order_time' => $this->formatDate($customer->getOrderInformation()->getFirstOrderTime()),
            'last_order_time' => $this->formatDate($customer->getOrderInformation()->getLastOrderTime()),
            'has_canceled_orders' => $customer->getOrderInformation()->hasCanceledOrders(),
            'ordered_at_weekdays' => $this->implodeUnique($customer->getOrderInformation()->getWeekdays()),
            'ordered_in_shops' => $this->implodeUnique($customer->getOrderInformation()->getShops()),
            'ordered_on_devices' => $this->implodeUnique($customer->getOrderInformation()->getDevices()),
            'ordered_with_deliveries' => $this->implodeUnique($customer->getOrderInformation()->getDispatches()),
            'ordered_with_payments' => $this->implodeUnique($customer->getOrderInformation()->getPayments()),
            'ordered_products' => $this->implodeUnique($customer->getOrderInformation()->getProducts()),
            'ordered_products_of_categories' => $this->implodeUnique($customer->getOrderInformation()->getCategories()),
            'ordered_products_of_manufacturer' => $this->implodeUnique($customer->getOrderInformation()->getManufacturers()),
        ];

        return $data;
    }

    private function createInsertQuery()
    {
        return $this->connection->prepare(
            'INSERT INTO s_customer_search_index (
                id,
                email,
                active,
                accountmode,
                firstlogin,
                newsletter,
                shop_id,
                default_billing_address_id,
                title,
                salutation,
                firstname,
                lastname,
                birthday,
                customernumber,
                customer_group_id,
                customer_group_name,
                payment_id,
                company,
                department,
                street,
                zipcode,
                city,
                phone,
                additional_address_line1,
                additional_address_line2,
                country_id,
                country_name,
                state_id,
                age,
                count_orders ,
                invoice_amount_sum,
                invoice_amount_avg,
                invoice_amount_min,
                invoice_amount_max,
                first_order_time,
                last_order_time,
                has_canceled_orders,
                ordered_at_weekdays,
                ordered_in_shops,
                ordered_on_devices,
                ordered_with_deliveries,
                ordered_with_payments,
                product_avg,
                ordered_products,
                ordered_products_of_categories,
                ordered_products_of_manufacturer,
                index_time
            ) VALUES (
                :id,
                :email,
                :active,
                :accountmode,
                :firstlogin,
                :newsletter,
                :shop_id,
                :default_billing_address_id,
                :title,
                :salutation,
                :firstname,
                :lastname,
                :birthday,
                :customernumber,
                :customer_group_id,
                :customer_group_name,
                :payment_id,
                :company,
                :department,
                :street,
                :zipcode,
                :city,
                :phone,
                :additional_address_line1,
                :additional_address_line2,
                :country_id,
                :country_name,
                :state_id,
                :age,
                :count_orders,
                :invoice_amount_sum,
                :invoice_amount_avg,
                :invoice_amount_min,
                :invoice_amount_max,
                :first_order_time,
                :last_order_time,
                :has_canceled_orders,
                :ordered_at_weekdays,
                :ordered_in_shops,
                :ordered_on_devices,
                :ordered_with_deliveries,
                :ordered_with_payments,
                :product_avg,
                :ordered_products,
                :ordered_products_of_categories,
                :ordered_products_of_manufacturer,
                NOW()
            )
      ');
    }

    private function implodeUnique($array)
    {
        if (empty($array)) {
            return null;
        }

        return '|' . implode('|', array_keys(array_flip($array))) . '|';
    }

    /**
     * @param \DateTime|null $date
     * @param string         $format
     *
     * @return null|string
     */
    private function formatDate(\DateTime $date = null, $format = 'Y-m-d H:i:s')
    {
        if ($date === null) {
            return null;
        }

        return $date->format($format);
    }
}
