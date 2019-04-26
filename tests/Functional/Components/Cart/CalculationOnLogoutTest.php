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

namespace Shopware\Tests\Functional\Components\Cart;

use Enlight_Controller_Request_RequestHttp;
use Shopware\Components\Test\CheckoutTest;

class CalculationOnLogoutTest extends CheckoutTest
{
    public $clearBasketOnReset = false;

    public function testLogout()
    {
        Shopware()->Front()->setRequest(new Enlight_Controller_Request_RequestHttp());

        $this->setConfig('clearBasketAfterLogout', false);

        $productNumber = $this->createArticle(100, 19.00);
        Shopware()->Modules()->Basket()->sAddArticle($productNumber);
        Shopware()->Modules()->Basket()->sRefreshBasket();

        $currentAmount = Shopware()->Session()->get('sBasketAmount');

        $this->loginFrontendUser('H');

        Shopware()->Modules()->Admin()->logout();

        static::assertEquals($currentAmount, Shopware()->Session()->get('sBasketAmount'));
    }
}
