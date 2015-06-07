<?php
/**
 * Part of php-sitemap project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

use Asika\Sitemap\Sitemap;

/**
 * The SitemapTest class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class SitemapTest extends \Windwalker\Test\TestCase\DomTestCase
{
	/**
	 * Property instance.
	 *
	 * @var Sitemap
	 */
	protected $instance;

	/**
	 * setUp
	 *
	 * @return  void
	 */
	public function setUp()
	{
		$this->instance = new Sitemap;
	}

	/**
	 * testAddItem
	 *
	 * @return  void
	 */
	public function testAddItem()
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

		$this->assertDomStringEqualsDomString($xml, $this->instance->toString());

		$this->instance->addItem('http://windwalker.io/foo/bar/?flower=sakura&fly=bird', '1.0', \Asika\Sitemap\ChangeFreq::DAILY, '2015-06-07 10:51:20');

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

		$this->assertDomStringEqualsDomString($xml, $this->instance->toString());
	}
}
