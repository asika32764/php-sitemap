<?php

declare(strict_types=1);

namespace Asika\Sitemap;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use UnexpectedValueException;

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
    protected string $root = 'sitemapindex';

    /**
     * @param string                         $loc
     * @param DateTimeInterface|string|null $lastmod
     *
     * @return  static
     * @throws Exception
     */
    public function addItem(string $loc, DateTimeInterface|string $lastmod = null)
    {
        if ($this->autoEscape) {
            $loc = htmlspecialchars($loc);
        }

        $sitemap = $this->xml->addChild('sitemap');

        if ($sitemap === null) {
            throw new UnexpectedValueException('Add Sitemap to XML failed.');
        }

        $sitemap->addChild('loc', $loc);

        if ($lastmod) {
            if (!($lastmod instanceof DateTimeInterface)) {
                $lastmod = new DateTimeImmutable($lastmod);
            }

            $sitemap->addChild('lastmod', $lastmod->format($this->dateFormat));
        }

        return $this;
    }
}
