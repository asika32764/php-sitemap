<?php

/**
 * Part of php-sitemap project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

declare(strict_types=1);

namespace Asika\Sitemap\Test;

use Asika\Sitemap\ChangeFreq;
use Asika\Sitemap\Sitemap;
use PHPUnit\Framework\TestCase;
use Windwalker\Test\Traits\DOMTestTrait;

/**
 * The SitemapTest class.
 */
class SitemapTest extends TestCase
{
    use DOMTestTrait;

    /**
     * Property instance.
     *
     * @var Sitemap
     */
    protected Sitemap $instance;

    /**
     * setUp
     *
     * @return  void
     */
    public function setUp(): void
    {
        $this->instance = new Sitemap();
    }

    /**
     * testAddItem
     *
     * @return  void
     */
    public function testAddItem(): void
    {
        $this->instance->addItem('http://windwalker.io');

        $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>http://windwalker.io</loc>
	</url>
</urlset>
XML;

        self::assertDomStringEqualsDomString($xml, $this->instance->render());

        $this->instance->addItem('http://windwalker.io/foo/bar/?flower=sakura&fly=bird', '1.0', ChangeFreq::DAILY, '2015-06-07 10:51:20');

        $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>http://windwalker.io</loc>
	</url>
	<url>
		<loc>http://windwalker.io/foo/bar/?flower=sakura&amp;fly=bird</loc>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
		<lastmod>2015-06-07T10:51:20+02:00</lastmod>
	</url>
</urlset>
XML;

        self::assertDomStringEqualsDomString($xml, $this->instance->render());
    }
}
