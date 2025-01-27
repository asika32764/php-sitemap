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
     * @param  string|\Stringable             $loc
     * @param  string|int|float|null          $priority
     * @param  string|ChangeFreq|null         $changeFreq
     * @param  DateTimeInterface|string|null  $lastmod
     *
     * @return  static
     * @throws \DateMalformedStringException
     */
    public function addItem(
        string|\Stringable $loc,
        string|int|float|null $priority = null,
        ChangeFreq|string|null $changeFreq = null,
        DateTimeInterface|string|null $lastmod = null
    ): static {
        $loc = (string) $loc;

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

            $url->addChild('changefreq', (string) $changeFreq);
        }

        if ($priority) {
            $url->addChild('priority', (string) $priority);
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
