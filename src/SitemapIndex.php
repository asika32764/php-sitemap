<?php
/**
 * Part of zero project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Asika\Sitemap;

/**
 * The SitemapIndex class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class SitemapIndex extends AbstractSitemap
{
	/**
	 * Property root.
	 *
	 * @var  string
	 */
	protected $root = 'sitemapindex';

	/**
	 * addItem
	 *
	 * @param string           $loc
	 * @param string|\DateTime $lastmod
	 *
	 * @return  static
	 */
	public function addItem($loc, $lastmod = null)
	{
		if ($this->autoEscape)
		{
			$loc = htmlspecialchars($loc);
		}

		$sitemap = $this->xml->addChild('sitemap');

		$sitemap->addChild('loc', $loc);

		if ($lastmod)
		{
			if (!($lastmod instanceof \DateTime))
			{
				$lastmod = new \DateTime($lastmod);
			}

			$sitemap->addChild('lastmod', $lastmod->format($this->dateFormat));
		}

		return $this;
	}
}
