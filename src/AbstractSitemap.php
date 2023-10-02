<?php

declare(strict_types=1);

namespace Asika\Sitemap;

use DateTimeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use SimpleXMLElement;

/**
 * The AbstractSitemap class.
 *
 * @since  {DEPLOY_VERSION}
 */
abstract class AbstractSitemap
{
    /**
     * Property root.
     *
     * @var  string
     */
    protected string $root = 'sitemap';

    /**
     * Property xmlns.
     *
     * @var  string
     */
    protected string $xmlns = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    /**
     * Property encoding.
     *
     * @var  string
     */
    protected string $encoding = 'utf-8';

    /**
     * Property XmlVersion.
     *
     * @var  string
     */
    protected string $xmlVersion = '1.0';

    /**
     * @var string
     */
    protected string $contentType = 'application/xml';

    /**
     * Property xml.
     *
     * @var  SimpleXMLElement
     */
    protected SimpleXMLElement $xml;

    /**
     * Property autoEscape.
     *
     * @var  bool
     */
    protected bool $autoEscape = true;

    /**
     * Property dateFormat.
     *
     * @var  string
     */
    protected string $dateFormat = DateTimeInterface::W3C;

    /**
     * Class init.
     *
     * @param string|null $xmlns
     * @param string      $encoding
     * @param string      $xmlVersion
     */
    public function __construct(
        string $xmlns = null,
        string $encoding = 'utf-8',
        string $xmlVersion = '1.0'
    ) {
        $this->xmlns      = $xmlns ?: $this->xmlns;
        $this->encoding   = $encoding;
        $this->xmlVersion = $xmlVersion;

        $this->xml = $this->getSimpleXmlElement();
    }

    /**
     * @return  SimpleXMLElement
     */
    public function getSimpleXmlElement(): SimpleXMLElement
    {
        return $this->xml ??= simplexml_load_string(
            sprintf(
                '<?xml version="%s" encoding="%s"?' . '><%s xmlns="%s" />',
                $this->xmlVersion,
                $this->encoding,
                $this->root,
                $this->xmlns
            )
        );
    }

    /**
     * toString
     *
     * @return  string
     */
    public function render(): string
    {
        return $this->xml->asXML();
    }

    /**
     * @return  string
     */
    public function __toString()
    {
        return $this->render();
    }

    public function handleResponse(
        ResponseInterface $response,
        StreamInterface $body = null
    ): ResponseInterface {
        $body ??= $response->getBody();
        $body->rewind();
        $body->write($this->render());

        return $response->withHeader('content-type', $this->contentType)
            ->withBody($body);
    }

    public function output(): void
    {
        header('Content-Type: ' . $this->contentType);

        echo $this->render();
    }

    /**
     * Method to get property AutoEscape
     *
     * @return  bool
     */
    public function getAutoEscape(): bool
    {
        return $this->autoEscape;
    }

    /**
     * Method to set property autoEscape
     *
     * @param bool $autoEscape
     *
     * @return  static  Return self to support chaining.
     */
    public function setAutoEscape(bool $autoEscape): static
    {
        $this->autoEscape = $autoEscape;

        return $this;
    }

    /**
     * Method to get property DateFormat
     *
     * @return  string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * Method to set property dateFormat
     *
     * @param string $dateFormat
     *
     * @return  static  Return self to support chaining.
     */
    public function setDateFormat(string $dateFormat): static
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     *
     * @return  static  Return self to support chaining.
     */
    public function setContentType(string $contentType): static
    {
        $this->contentType = $contentType;

        return $this;
    }
}
