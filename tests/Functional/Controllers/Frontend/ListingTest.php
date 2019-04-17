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

class Shopware_Tests_Controllers_Frontend_ListingTest extends Enlight_Components_Test_Controller_TestCase
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * Set up test case, fix demo data where needed
     */
    public function setUp()
    {
        parent::setUp();

        $this->connection = Shopware()->Container()->get('dbal_connection');
        $this->connection->beginTransaction();
    }

    /**
     * Cleaning up testData
     */
    public function tearDown()
    {
        parent::tearDown();
        $this->connection->rollBack();
    }

    /**
     * Test that requesting an existing category-id is successfull
     */
    public function testDispatchExistingCategory()
    {
        $this->dispatch('/cat/?sCategory=14');
        static::assertEquals(200, $this->Response()->getHttpResponseCode());
    }

    /**
     * Test that requesting a non-existing category-id throws an error
     *
     * @expectedException \Enlight_Exception
     */
    public function testDispatchNonexistingCategory()
    {
        $this->dispatch('/cat/?sCategory=4711');
        static::assertEquals(404, $this->Response()->getHttpResponseCode());
        static::assertTrue($this->Response()->isRedirect());
    }

    /**
     * Test that requesting a non-existing category-id throws an error
     *
     * @expectedException \Enlight_Exception
     */
    public function testDispatchEmptyCategoryId()
    {
        $this->dispatch('/cat/?sCategory=');
        static::assertEquals(404, $this->Response()->getHttpResponseCode());
        static::assertTrue($this->Response()->isRedirect());
    }

    /**
     * Test that requesting a blog category-id creates a redirect
     *
     * @expectedException \Enlight_Exception
     */
    public function testDispatchBlogCategory()
    {
        $this->dispatch('/cat/?sCategory=17');
        static::assertEquals(404, $this->Response()->getHttpResponseCode());
        static::assertTrue($this->Response()->isRedirect());
    }

    /**
     * Test the home redirect if the base category called directly
     * The request should return a 301 redirection to the base homepage.
     *
     * @ticket SW-11418
     */
    public function testHomeRedirect()
    {
        $mainCategory = Shopware()->Shop()->getCategory()->getId();

        $this->dispatch('/cat/index/sCategory/' . $mainCategory);

        static::assertEquals(301, $this->Response()->getHttpResponseCode());
    }

    public function testManufacturerPage()
    {
        $this->dispatch('/das-blaue-haus/');

        $source = $this->Response()->getBody();

        static::assertContains('blaueshaus_200x200.png', $source);
    }

    public function testWithoutImageManufacturerPage()
    {
        $sql = <<<'SQL'
        UPDATE s_articles_supplier
        SET img = ''
        WHERE img = 'media/image/blaueshaus.png';
SQL;

        Shopware()->Db()->executeUpdate($sql);

        $this->dispatch('/das-blaue-haus/');

        $source = $this->Response()->getBody();

        static::assertNotContains('blaueshaus_200x200.png', $source);
    }
}
