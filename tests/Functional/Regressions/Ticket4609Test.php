<?php

declare(strict_types=1);
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

namespace Shopware\Tests\Functional\Regressions;

use Enlight_Components_Test_Controller_TestCase;
use Exception;
use Shopware\Tests\Functional\Traits\DatabaseTransactionBehaviour;

class Ticket4609Test extends Enlight_Components_Test_Controller_TestCase
{
    use DatabaseTransactionBehaviour;

    /**
     * Test case method
     */
    public function testNewsletterLog(): void
    {
        $sql = file_get_contents(__DIR__ . '/testdata/newsletter.sql');
        static::assertIsString($sql);
        Shopware()->Models()->getConnection()->executeStatement($sql);

        $this->Front()->setParam('noViewRenderer', false);

        $e = null;

        try {
            $this->dispatch('/backend/newsletter/log/mailling/1/mailaddress/70');
        } catch (Exception $e) {
        }

        static::assertNull($e);
    }
}
