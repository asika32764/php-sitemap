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
class NewsSitemap extends AbstractSitemap
{
    /**
     * Property root.
     *
     * @var  string
     */
    protected string $root = 'urlset';

    protected string $newsXmlns = 'http://www.google.com/schemas/sitemap-news/0.9';

    public function __construct(?string $xmlns = null, string $encoding = 'utf-8', string $xmlVersion = '1.0')
    {
        parent::__construct($xmlns, $encoding, $xmlVersion);

        $this->xml['xmlns:news'] = $this->newsXmlns;
        $this->xml->registerXPathNamespace('news', $this->newsXmlns);
    }

    /**
     * @param  string|\Stringable        $loc
     * @param  string                    $title
     * @param  string                    $publicationName
     * @param  string                    $language
     * @param  DateTimeInterface|string  $publicationDate
     *
     * @return  static
     * @throws Exception
     */
    public function addItem(
        string|\Stringable $loc,
        string $title,
        string $publicationName,
        string $language,
        DateTimeInterface|string $publicationDate,
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
        $news = $url->addChild('xmlns:news:news');

        if ($news === null) {
            throw new UnexpectedValueException('Add URL to XML failed.');
        }

        $publication = $news->addChild('xmlns:news:publication');

        if ($publication === null) {
            throw new UnexpectedValueException('Add URL to XML failed.');
        }

        $publication->addChild('xmlns:news:name', $publicationName);
        $publication->addChild('xmlns:news:language', $language);

        if (!($publicationDate instanceof DateTimeInterface)) {
            $publicationDate = new DateTimeImmutable($publicationDate);
        }

        $news->addChild('xmlns:news:publication_date', $publicationDate->format($this->dateFormat));
        $news->addChild('xmlns:news:title', $title);

        return $this;
    }

    public function getNewsXmlns(): string
    {
        return $this->newsXmlns;
    }

    public function setNewsXmlns(string $newsXmlns): static
    {
        $this->newsXmlns = $newsXmlns;

        return $this;
    }
}
