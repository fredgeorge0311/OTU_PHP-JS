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

use Shopware\Components\Migrations\AbstractMigration;

class Migrations_Migration933 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up($modus)
    {
        $sql = <<<'SQL'
SET @parentId = (SELECT id FROM s_core_menu WHERE name = 'Kunden');

INSERT INTO `s_core_menu` (`id`, `parent`,  `name`, `onclick`,  `class`, `position`, `active`, `pluginID`,  `controller`, `shortcut`, `action`) VALUES
(null, @parentId,  'Customer Streams', '',  'sprite-customer-streams', 20, 1, NULL, 'Customer', NULL, 'customer_stream');
SQL;
        $this->addSql($sql);
    }
}
