# PHP Sitemap


![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/asika32764/php-sitemap/ci.yml?style=for-the-badge)
[![Packagist Version](https://img.shields.io/packagist/v/asika/sitemap?style=for-the-badge)
](https://packagist.org/packages/asika/sitemap)
[![Packagist Downloads](https://img.shields.io/packagist/dt/asika/sitemap?style=for-the-badge)](https://packagist.org/packages/asika/sitemap)

PHP Simple Sitemap Generator. Follows the [W3C Sitemap Protocol](http://www.sitemaps.org/protocol.html)

<!-- TOC -->
* [PHP Sitemap](#php-sitemap)
  * [Installation via Composer](#installation-via-composer)
  * [Getting Started](#getting-started)
    * [Render it to XML:](#render-it-to-xml)
  * [Arguments](#arguments)
    * [loc](#loc)
    * [changefreq](#changefreq)
    * [priority](#priority)
    * [lastmod](#lastmod)
  * [Google News Sitemap](#google-news-sitemap)
  * [Using Sitemap index files (to group multiple sitemap files)](#using-sitemap-index-files-to-group-multiple-sitemap-files)
  * [More](#more)
<!-- TOC -->

## Installation via Composer

```shell
composer require 
```

## Getting Started

Create a sitemap object:

```php
use Asika\Sitemap\Sitemap;

$sitemap = new Sitemap();
```

Add items to sitemap:

```php
$sitemap->addItem($url);
$sitemap->addItem($url);
$sitemap->addItem($url);
```

You can add some optional params.

```php
use Asika\Sitemap\ChangeFreq;

$sitemap->addItem($url, '1.0', ChangeFreq::DAILY, '2015-06-07 10:51:20');
$sitemap->addItem($url, '0.7', ChangeFreq::WEEKLY, new \DateTime('2015-06-03 11:24:20'));
```

The arguments are `loc`, `priority`, `changefreq` and `lastmod`. See this table:
 
| Params       | Required | Description                                                                                                                                                                                                                                                                 |
|--------------|----------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `loc`        | required | URL of the page. This URL must begin with the protocol (such as http) and end with a trailing slash, if your web server requires it. This value must be less than 2,048 characters.                                                                                         |
| `priority`   | optional | The priority of this URL relative to other URLs on your site. Valid values range from 0.0 to 1.0. This value does not affect how your pages are compared to pages on other sites—it only lets the search engines know which pages you deem most important for the crawlers. |
| `changefreq` | optional | How frequently the page is likely to change. This value provides general information to search engines and may not correlate exactly to how often they crawl the page.                                                                                                      |
| `lastmod`    | optional | The date of last modification of the file. This date should be in [W3C Datetime format](http://www.w3.org/TR/NOTE-datetime). This format allows you to omit the time portion, if desired, and use YYYY-MM-DD.                                                               |

See: http://www.sitemaps.org/protocol.html#xmlTagDefinitions

### Render it to XML:

```php
echo $sitemap->render();

// OR

(string) $sitemap;
```

This is an example to send it as real sitemap for Google or other search engine:

```php
header('Content-Type: application/xml');

echo $sitemap;

exit();
```

Use `output()` to instantly print header and XML body:

```php
$sitemap->output();

exit();
```

Handle Psr7 Response

```php
$response = new Response();

$response = $sitemap->handleResponse($response);

return $response;
```

The XML output in browser:

```xml
<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>http://sitemap.io</loc>
	</url>
	<url>
		<loc>http://sitemap.io/foo/bar/?flower=sakura&amp;fly=bird</loc>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
		<lastmod>2015-06-07T10:51:20+02:00</lastmod>
	</url>
</urlset>
```

## Arguments

### loc

The URL will be auto escaped. For example, the `&`, `>` will convert to `&amp;`, `&gt;`. 

If you want to escape it yourself, set auto escape off:

```php
$sitemap->setAutoEscape(false);
```

See: http://www.sitemaps.org/protocol.html#escaping

### changefreq

Valid values are:

```php
ChangeFreq::ALWAYS;
ChangeFreq::HOURLY;
ChangeFreq::DAILY;
ChangeFreq::WEEKLY;
ChangeFreq::MONTHLY;
ChangeFreq::YEARLY;
ChangeFreq::NEVER;
```

The value `always` should be used to describe documents that change each time they are accessed. 

The value `never` should be used to describe archived URLs.

Please note that the value of this tag is considered a hint and not a command. Even though search engine crawlers may consider this information when making decisions, 
they may crawl pages marked `hourly` less frequently than that, and they may crawl pages marked `yearly` more frequently than that. 

Crawlers may periodically crawl pages marked `never` so that they can handle unexpected changes to those pages.

### priority

The default priority of a page is `0.5`.
Please note that the priority you assign to a page is not likely to influence the position of your URLs in a search engine's result pages. Search engines may use this information when selecting between URLs on the same site, so you can use this tag to increase the likelihood that your most important pages are present in a search index.
Also, please note that assigning a high priority to all of the URLs on your site is not likely to help you. Since the priority is relative, it is only used to select between URLs on your site.

### lastmod

Your date format will auto convert to [W3c Datetime format](http://www.w3.org/TR/NOTE-datetime). for example, if you send
a string look like: `2015-06-07 10:51:20`, Sitemap object will auto convert it to `2015-06-07T10:51:20+02:00`.

You can set the format you want:

```php
$sitemap->setDateFormat(\DateTimeInterface::ISO8601);

// OR

$sitemap->setDateFormat('Y-m-d');
```

## Google News Sitemap

Please see [Google News Sitemap](https://developers.google.com/search/docs/crawling-indexing/sitemaps/news-sitemap?visit_id=637247859078479568-4208069007&rd=3) document.

```php
$sitemap = new \Asika\Sitemap\NewsSitemap();

$sitemap->addItem(
    $url,
    $newsTitle,
    'Publication Name',
    'en-us',
    $publishedDate
);
```

The format:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
  <url>
  <loc>http://www.example.org/business/article55.html</loc>
  <news:news>
    <news:publication>
      <news:name>The Example Times</news:name>
      <news:language>en</news:language>
    </news:publication>
    <news:publication_date>2008-12-23</news:publication_date>
    <news:title>Companies A, B in Merger Talks</news:title>
  </news:news>
  </url>
</urlset>
```

## Using Sitemap index files (to group multiple sitemap files)

```php
use Asika\Sitemap\SitemapIndex;

$index = new SitemapIndex();

$index->addItem('http://domain.com/sitemap1.xml', $lastmod1);
$index->addItem('http://domain.com/sitemap2.xml', $lastmod2);

echo $index->render();
```

Output:

```xml
<?xml version="1.0" encoding="utf-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<sitemap>
        <loc>http://domain.com/sitemap1.xml</loc>
        <lastmod>2015-06-07T10:51:20+02:00</lastmod>
    </sitemap>
	<sitemap>
		<loc>http://domain.com/sitemap2.xml</loc>
		<lastmod>2015-06-07T10:51:20+02:00</lastmod>
	</sitemap>
</sitemapindex>
```

See: http://www.sitemaps.org/protocol.html#index

## More

- [Extending the Sitemaps protocol](http://www.sitemaps.org/protocol.html#extending)
