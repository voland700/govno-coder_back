<?php


namespace App\Http\Helpers;

use App\Models\Information;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

use GuzzleHttp\Client;


class Parser
{
    public static $links = [];
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

    public static function getContent(string $src){
        $dt = Carbon::now();
        $userData = [
            'agent' =>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36 OPR/90.0.4480.54',
            'refer' =>'https://yandex.ru/'
        ];
        if($dt->isMonday()) {
            $userData['agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36 OPR/90.0.4480.54';
            $userData['refer'] = 'https://www.google.ru/';
        }
        elseif($dt->isTuesday()) {
            $userData['agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36 OPR/90.0.4480.84';
            $userData['refer'] = 'https://yandex.ru/';
        }
        elseif($dt->isWednesday()) {
            $userData['agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36';
            $userData['refer'] = 'https://mail.ru/';
        }
        elseif($dt->isThursday()) {
            $userData['agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:104.0) Gecko/20100101 Firefox/104.0';
            $userData['refer'] = 'https://www.rambler.ru/';
        }
        elseif($dt->isFriday()) {
            $userData['agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.167 YaBrowser/22.7.5.940 Yowser/2.5 Safari/537.36';
            $userData['refer'] = 'https://www.belarusinfo.by/';
        }
        elseif($dt->isSaturday()) {
            $userData['agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.115 Safari/537.36';
            $userData['refer'] = 'https://vk.com/feed';
        }
        elseif($dt->isSunday()) {
            $userData['agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.148 Atom/23.0.0.36 Safari/537.36';
            $userData['refer'] =  'https://www.securitylab.ru/';
        }

        $client = new \GuzzleHttp\Client();
        $jar = new \GuzzleHttp\Cookie\CookieJar;
        $res = $client->request('GET', $src, [
            'cookies' => $jar,
            'referer' => true,
            'headers' => [
                'User-Agent' => $userData['agent'],
                'Referer' => $userData['refer']
            ]
        ]);
        if($res->getStatusCode()==200){
            $body = $res->getBody();
            return $body->getContents();
        } else {
            return  null;
        }
    }


    public static function getLinksYesterday(string $src){
        $xml = self::getContent($src);
        if(!$xml) return self::$links;
        $rss = new Crawler($xml);
        $rss = $rss->filter('item')->reduce(function (Crawler $node, $i) {
            return Carbon::parse($node->children('pubDate')->text())->isYesterday();
        });
        self::$links = $rss->each(function (Crawler $node, $i) {
            $link =  $node->children('link')->text();
            if(Str::contains($link, '/news/')) return $link;
        });
        self::$links = Arr::whereNotNull(self::$links);
        return self::$links;
    }

    public function getElement(string $src)
    {
        if(!$src) return $this;
        $html = self::getContent($src);
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


