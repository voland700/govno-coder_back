<?php


namespace App\Http\Helpers;

use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParserContent
{
    public $title;
    public $preview;
    public $description;
    public $image;
    public $link;
    public $allowed;

    public  function  __construct()
    {
        $this->title = null;
        $this->preview = null;
        $this->description = null;
        $this->image = null;
        $this->link = null;
        $this->allowed = false;
    }

    public function getContent(string $src)
    {
        if(!$src) return $this;
        $html = @file_get_contents($src);
        if(!$html) return $this;
        $crawler = new Crawler(null, $src);
        $crawler->addHtmlContent($html, 'UTF-8');
        $crawler = $crawler->filter('sape_index');
        $mainImages = $crawler->filter('img')->eq(0);
        $body = $crawler->filter('div')->eq(5);

        if($body->filter('img')->count()) {
            $body->filter('img')->each(function (Crawler $node, $i) {
                $file = file_get_contents($node->image()->getUri());
                $path_to = '/news/' . getfolderName() . '/';
                $ext = pathinfo(basename($node->image()->getUri()), PATHINFO_EXTENSION);
                $ext = $ext['extension'] ?? 'jpg';
                $fileName = 'extra_' . Str::lower(Str::random(8)) . '.' . $ext;

                Storage::disk('local')->put('public' . $path_to . $fileName, $file);

                $node->getNode(0)->removeAttribute('src');
                $node->getNode(0)->setAttribute('src', '/storage' . $path_to . $fileName);
                $node->getNode(0)->removeAttribute('imagescaler');
                $node->getNode(0)->removeAttribute('id');
                $node->getNode(0)->removeAttribute('class');
                $node->getNode(0)->removeAttribute('srcset');
                $node->getNode(0)->removeAttribute('sizes');
                $node->getNode(0)->removeAttribute('width');
                $node->getNode(0)->removeAttribute('height');
                $node->getNode(0)->setAttribute('class', 'news_img');
            });
        }

        if($mainImages->count()){
            $image = $mainImages->image()->getUri();
            if($image) {
                $img = file_get_contents($image);
                $path_to = '/news/' . getfolderName() . '/';
                $ext = pathinfo(basename($image), PATHINFO_EXTENSION);
                $fileName = 'news_' . Str::lower(Str::random(8)) . '.' . $ext;
                Storage::disk('local')->put('public'. $path_to . $fileName, $img);
                $this->image = '/storage'. $path_to . $fileName;
            }
        }

        $this->preview = $crawler->filter('p')->eq(0)->text();
        $this->title   = $crawler->filter('div')->eq(0)->text();
        $this->link    = $src;
        $this->description =  removeLink($crawler->filter('div')->eq(5)->html());
        $this->allowed = true;

        return $this;
    }

}
