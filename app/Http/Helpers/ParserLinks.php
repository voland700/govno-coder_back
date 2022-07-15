<?php


namespace App\Http\Helpers;

use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;

class ParserLinks
{
    public static $links = [];

    public static function getLinksYesterday(string $src){

        $xml = @file_get_contents($src);
        if(!$xml) return self::$links;
        $rss =   new Crawler($xml);

        $rss = $rss->filter('item')->reduce(function (Crawler $node, $i) {
            return Carbon::parse($node->children('pubDate')->text())->isYesterday();
        });

        self::$links = $rss->each(function (Crawler $node, $i) {
            return $node->children('link')->text();
        });

        return self::$links;
    }
}
