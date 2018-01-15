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

namespace Shopware\Tests\Unit\Components\HttpCache;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @category  Shopware
 *
 * @copyright Copyright (c) shopware AG (http://www.shopware.de)
 */
class StoreTest extends TestCase
{
    public function setUp()
    {
        $this->httpCacheStore = new \Shopware\Components\HttpCache\Store(
            'test',
            [],
            true,
            [          //Set of parameters that must be ignored in the url
                'foo',
                '_foo',
                '__foo',
            ]
        );
    }

    public function provideUrls()
    {
        return [
            [
                'original' => 'http://example.com/',
                'compare' => 'http://example.com',
            ],
            [
                'original' => 'http://example.com?a=a&a=1',
                'compare' => 'http://example.com/?a=a',
            ],
            [
                'original' => 'http://example.com?z=a&a=a',
                'compare' => 'http://example.com/?a=a&z=a',
            ],
            [
                'original' => 'http://example.com?Z=a&z=a',
                'compare' => 'http://example.com/?Z=a&z=a',
            ],
            [
                'original' => 'http://example.com/?cars[0]=Saab&cars[1]=Audi&colors[0]=red&colors[1]=red&colors[2]=blue&foo=1',
                'compare' => 'http://example.com/?cars[0]=Saab&cars[1]=Audi&colors[0]=red&colors[1]=red&colors[2]=blue',
            ],

            [
                'original' => 'http://example.com?foo',
                'compare' => 'http://example.com',
            ],
            [
                'original' => 'http://example.com?foo=bar',
                'compare' => 'http://example.com',
            ],
            [
                'original' => 'http://example.com?_foo=bar',
                'compare' => 'http://example.com',
            ],
            [
                'original' => 'http://example.com?__foo=bar',
                'compare' => 'http://example.com',
            ],
            [
                'original' => 'http://example.com?foo&z=a&a=a',
                'compare' => 'http://example.com/?a=a&z=a',
            ],
            [
                'original' => 'http://example.com?foo=bar&z=a&a=a',
                'compare' => 'http://example.com/?a=a&z=a',
            ],
            [
                'original' => 'http://example.com?_foo=bar&z=a&a=a',
                'compare' => 'http://example.com/?a=a&z=a',
            ],
            [
                'original' => 'http://example.com?__foo=bar&z=a&a=a',
                'compare' => 'http://example.com/?a=a&z=a',
            ],
            [
                'original' => 'http://example.com?z=a&foo=bar&a=a',
                'compare' => 'http://example.com/?a=a&z=a',
            ],
            [
                'original' => 'http://example.com?z=a&a=a&foo=bar',
                'compare' => 'http://example.com/?a=a&z=a',
            ],
        ];
    }

    /**
     * @dataProvider provideUrls
     *
     * @param string $originalURL
     * @param string $expectedURL
     *
     * @see Shopware\Components\HttpCache\Store::generateCacheKey
     */
    public function testGenerateCacheKey($originalURL, $expectedURL)
    {
        $originalRequest = Request::create($originalURL);
        $class = new \ReflectionClass($this->httpCacheStore);
        $method = $class->getMethod('generateCacheKey');
        $method->setAccessible(true);

        $this->assertSame(
            'md' . hash('sha256', $expectedURL),
            $method->invokeArgs($this->httpCacheStore, [$originalRequest])
        );
    }

    /**
     * @dataProvider provideUrls
     *
     * @param string $originalURL
     * @param string $expectedURL
     *
     * @see Shopware\Components\HttpCache\Store::verifyIgnoredParameters
     */
    public function testVerifyIgnoredParameters($originalURL, $expectedURL)
    {
        $originalRequest = Request::create($originalURL);
        $class = new \ReflectionClass($this->httpCacheStore);
        $method = $class->getMethod('verifyIgnoredParameters');
        $method->setAccessible(true);

        $this->assertSame(
            $expectedURL,
            $method->invokeArgs($this->httpCacheStore, [$originalRequest])
        );
    }
}
