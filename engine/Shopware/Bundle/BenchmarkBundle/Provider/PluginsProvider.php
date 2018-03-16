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

namespace Shopware\Bundle\BenchmarkBundle\Provider;

use Doctrine\DBAL\Connection;
use Shopware\Bundle\BenchmarkBundle\BenchmarkProviderInterface;

class PluginsProvider implements BenchmarkProviderInterface
{
    /**
     * @var Connection
     */
    private $dbalConnection;

    public function __construct(Connection $dbalConnection)
    {
        $this->dbalConnection = $dbalConnection;
    }

    public function getName()
    {
        return 'plugins';
    }

    public function getBenchmarkData()
    {
        return [
            'total' => $this->getTotalPlugins(),
            'updateable' => $this->getUpdateablePlugins(),
            'shopware' => $this->getShopwarePlugins(),
            'technical' => $this->getTechnicalPluginNames(),
        ];
    }

    /**
     * @return int
     */
    private function getTotalPlugins()
    {
        $queryBuilder = $this->dbalConnection->createQueryBuilder();

        return (int) $queryBuilder->select('COUNT(plugins.id)')
            ->from('s_core_plugins', 'plugins')
            ->execute()
            ->fetchColumn();
    }

    /**
     * @return int
     */
    private function getUpdateablePlugins()
    {
        $queryBuilder = $this->dbalConnection->createQueryBuilder();

        $pluginVersions = $queryBuilder->select('plugins.version as currentVersion, plugins.update_version as updateVersion')
            ->from('s_core_plugins', 'plugins')
            ->where('plugins.update_version IS NOT NULL')
            ->execute()
            ->fetchAll();

        // Check if the updateVersion is actually greater than the currentVersion
        foreach ($pluginVersions as $key => $pluginVersion) {
            if (version_compare($pluginVersion['updateVersion'], $pluginVersion['currentVersion'], '>')) {
                continue;
            }

            unset($pluginVersions[$key]);
        }

        return count($pluginVersions);
    }

    /**
     * @return int
     */
    private function getShopwarePlugins()
    {
        $queryBuilder = $this->dbalConnection->createQueryBuilder();

        return (int) $queryBuilder->select('COUNT(plugins.id)')
            ->from('s_core_plugins', 'plugins')
            ->where("plugins.author = 'shopware AG'")
            ->execute()
            ->fetchColumn();
    }

    /**
     * @return array
     */
    private function getTechnicalPluginNames()
    {
        $queryBuilder = $this->dbalConnection->createQueryBuilder();

        return $queryBuilder->select('plugins.name as technicalName')
            ->from('s_core_plugins', 'plugins')
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);
    }
}
