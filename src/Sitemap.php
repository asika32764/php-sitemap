<?php

declare(strict_types=1);

namespace Asika\Sitemap;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use UnexpectedValueException;

/**
 * The Sitemap class.
 */
class Sitemap extends AbstractSitemap
{
    /**
     * Property root.
     *
     * @var  string
     */
    protected string $root = 'urlset';

    /**
     * @param string                         $loc
     * @param string|null                    $priority
     * @param ChangeFreq|string|null         $changeFreq
     * @param DateTimeInterface|string|null $lastmod
     *
     * @return  static
     * @throws Exception
     */
    public function addItem(
        string $loc,
        string $priority = null,
        ChangeFreq|string $changeFreq = null,
        DateTimeInterface|string $lastmod = null
    ): static {
        if ($this->autoEscape) {
            $loc = htmlspecialchars($loc);
        }

        $url = $this->xml->addChild('url');

        if ($url === null) {
            throw new UnexpectedValueException('Add URL to XML failed.');
        }

        $url->addChild('loc', $loc);

        if ($changeFreq) {
            if ($changeFreq instanceof ChangeFreq) {
                $changeFreq = $changeFreq->value;
            }

            $url->addChild('changefreq', $changeFreq);
        }

        if ($priority) {
            $url->addChild('priority', $priority);
        }

        if ($lastmod) {
            if (!($lastmod instanceof DateTimeInterface)) {
                $lastmod = new DateTimeImmutable($lastmod);
            }

            $url->addChild('lastmod', $lastmod->format($this->dateFormat));
        }

        return $this;
    }
}
