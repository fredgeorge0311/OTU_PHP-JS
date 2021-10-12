<?php

declare(strict_types=1);
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

namespace Shopware\Tests\Functional\Bundle\ESIndexingBundle\Property;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Shopware\Bundle\ESIndexingBundle\Property\PropertyQueryFactory;
use Shopware\Tests\Functional\Traits\ContainerTrait;

class PropertyQueryFactoryTest extends TestCase
{
    use ContainerTrait;

    public function testCreateQueryShouldContainOrderByPropertyGroups(): void
    {
        $queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['orderBy'])
            ->getMock();

        $queryBuilderMock
            ->expects(static::once())
            ->method('orderBy')
            ->with('propertyGroups.id', 'ASC')
            ->willReturn($queryBuilderMock);

        $connection = $this->createConfiguredMock(Connection::class, ['createQueryBuilder' => $queryBuilderMock]);

        $propertyFactory = new PropertyQueryFactory($connection);

        $propertyFactory->createQuery(20);
    }
}
