<?php
/**
 * Part of php-sitemap project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

use Asika\Sitemap\SitemapIndex;

/**
 * The SitemapTest class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class SitemapIndexTest extends \Windwalker\Test\TestCase\DomTestCase
{
	/**
	 * Property instance.
	 *
	 * @var SitemapIndex
	 */
	protected $instance;

	/**
	 * setUp
	 *
	 * @return  void
	 */
	public function setUp()
	{
		$this->instance = new SitemapIndex;
	}

	/**
	 * testAddItem
	 *
	 * @return  void
	 */
	public function testAddItem()
	{
		$this->instance->addItem('http://windwalker.io/sitemap.xml');

		$xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<sitemap>
		<loc>http://windwalker.io/sitemap.xml</loc>
	</sitemap>
</sitemapindex>
XML;

		$this->assertDomStringEqualsDomString($xml, $this->instance->toString());

		$this->instance->addItem('http://windwalker.io/sitemap2.xml', '2015-06-07 10:51:20');

		$xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<sitemap>
		<loc>http://windwalker.io/sitemap.xml</loc>
	</sitemap>
	<sitemap>
		<loc>http://windwalker.io/sitemap2.xml</loc>
		<lastmod>2015-06-07T10:51:20+02:00</lastmod>
	</sitemap>
</sitemapindex>
XML;

		$this->assertDomStringEqualsDomString($xml, $this->instance->toString());
	}
}
