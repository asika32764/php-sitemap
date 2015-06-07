<?php
/**
 * Part of zero project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Asika\Sitemap;

/**
 * The Sitemap class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Sitemap extends AbstractSitemap
{
	/**
	 * Property root.
	 *
	 * @var  string
	 */
	protected $root = 'urlset';

	/**
	 * addItem
	 *
	 * @param string $loc
	 * @param string $priority
	 * @param string $changefreq
	 * @param string $lastmod
	 *
	 * @return  static
	 */
	public function addItem($loc, $priority = null, $changefreq = null, $lastmod = null)
	{
		if ($this->autoEscape)
		{
			$loc = htmlspecialchars($loc);
		}

		$url = $this->xml->addChild('url');

		$url->addChild('loc', $loc);

		$changefreq ? $url->addChild('changefreq', $changefreq) : null;
		$priority   ? $url->addChild('priority', $priority)     : null;

		if ($lastmod)
		{
			if (!($lastmod instanceof \DateTime))
			{
				$lastmod = new \DateTime($lastmod);
			}

			$url->addChild('lastmod', $lastmod->format($this->dateFormat));
		}

		return $this;
	}
}
