<?php
/**
 * This file is part of the Axstrad library.
 *
 * (c) Dan Kempster <dev@dankempster.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2014-2015 Dan Kempster <dev@dankempster.co.uk>
 */

namespace Axstrad\Bundle\PageBundle\Tests\Functional\TestPage;

use Axstrad\Bundle\TestBundle\Functional\WebTestCase;

/**
 * @author Dan Kempster <dev@dankempster.co.uk>
 * @license MIT
 * @package Axstrad/PageBundle
 * @subpackage Tests
 */
class SeoDataTest extends WebTestCase
{
    protected $crawler;

    protected $response;

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadBundlesFixtures()
    {
        return array(
            'AxstradPageTestHelperBundle',
        );
    }

    public function setUp()
    {
        parent::setUp();

        $this->client = self::createClient();
        $this->crawler = $this->client->request('GET', '/about-us');
        $this->response = $this->client->getResponse();
    }

    public function testPageHasTitle()
    {
        $this->assertEquals(
            'About Us | AxstradTestPageBundle',
            $this->crawler->filter('title')->text(),
            "Page <title> doesn't match expected value"
        );
    }

    public function testPageHasMetaKeywords()
    {
        $keywords = $this->crawler->filter('meta[name="keywords"]');
        $this->assertGreaterThan(
            0,
            $keywords->count(),
            'No <meta name="keywords"/> was found on the page, one was expected!'
        );

        $this->assertEquals(
            'about, us',
            $keywords->attr('content'),
            '<meta name="keywords"/> content does not match expected'
        );
    }

    public function testPageHasMetaDescription()
    {
        $description = $this->crawler->filter('meta[name="description"]');
        $this->assertGreaterThan(
            0,
            $description->count(),
            'No <meta name="description"/> was found on the page, one was expected!'
        );

        $this->assertEquals(
            'Meta description about us.',
            $description->attr('content')
        );
    }
}
