<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;


use App\Http\Helpers\ParserContent;
use App\Http\Helpers\ParserLinks;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class NewsController extends Controller
{
    public function getNews()
    {

        $rss = 'https://www.securitylab.ru/_services/export/rss/';

        $links = ParserLinks::getLinksYesterday($rss);

        if($links){
            foreach ($links as $link){
                $parser = new ParserContent;
                $content = $parser->getContent($link);
                if($content->allowed){
                   Information::create([
                       'title' => $content->title,
                       'preview' => $content->preview,
                       'description' => $content->description,
                       'image' => $content->image,
                       'link' => $content->link
                   ]);
				   Log::channel('news')->info('Добавлено: ', ['name' => $content->title, 'link' => $content->link ]);
                }
            }
        }
        echo '<h1>OK</h1>';
    }

	public function parsingListLinks()
	{
       $links = [
            'https://www.securitylab.ru/news/532776.php',
            'https://www.securitylab.ru/news/532775.php',
            'https://www.securitylab.ru/news/532774.php',
            'https://www.securitylab.ru/news/532773.php',
            'https://www.securitylab.ru/news/532772.php',
            'https://www.securitylab.ru/news/532770.php',
            'https://www.securitylab.ru/news/532768.php',
            'https://www.securitylab.ru/news/532767.php',
            'https://www.securitylab.ru/news/532769.php',
            'https://www.securitylab.ru/news/532765.php',
            'https://www.securitylab.ru/news/532771.php',
            'https://www.securitylab.ru/news/532764.php',
            'https://www.securitylab.ru/news/532763.php',
            'https://www.securitylab.ru/news/532761.php',
            'https://www.securitylab.ru/news/532760.php'
           ];

       if($links){
           foreach ($links as $link){
               $parser = new ParserContent;
               $content = $parser->getContent($link);
               if($content->allowed){
                   Information::create([
                       'title' => $content->title,
                       'preview' => $content->preview,
                       'description' => $content->description,
                       'image' => $content->image,
                       'link' => $content->link
                   ]);
               }
           }
       }

       echo '<h1>OK</h1>';
	}

	public function test()
    {
        $links =[];
        $rss = 'https://www.securitylab.ru/_services/export/rss/';
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

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $userData['agent']);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Автоматом идём по редиректам
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); // Не проверять SSL сертификат
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); // Не проверять Host SSL сертификата
        curl_setopt($ch, CURLOPT_URL, $rss); // Куда отправляем
        curl_setopt($ch, CURLOPT_REFERER, $userData['refer']); // Откуда пришли
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Возвращаем, но не выводим на экран результат
        $xml = curl_exec($ch);
        curl_close($ch);

        if(!$xml) return false;


        $rss =   new Crawler($xml);

        $rss = $rss->filter('item')->reduce(function (Crawler $node, $i) {
            return Carbon::parse($node->children('pubDate')->text())->isYesterday();
        });

        $links = $rss->each(function (Crawler $node, $i) {
            $link =  $node->children('link')->text();
            if(Str::contains($link, '/news/')) return $link;
        });
       $links = Arr::whereNotNull($links);
       dd($links);
















/*




        function curl_get_contents($page_url, $agent, $base_url, $pause_time, $retry) {
            /*
            $page_url - адрес страницы-источника
            $base_url - адрес страницы для поля REFERER
            $pause_time - пауза между попытками парсинга
            $retry - 0 - не повторять запрос, 1 - повторить запрос при неудаче
            *//*
            $error_page = array();

            $response['html'] = curl_exec($ch);
            $info = curl_getinfo($ch);
            if($info['http_code'] != 200 && $info['http_code'] != 404) {
                $error_page[] = array(1, $page_url, $info['http_code']);
                if($retry) {
                    sleep($pause_time);
                    $response['html'] = curl_exec($ch);
                    $info = curl_getinfo($ch);
                    if($info['http_code'] != 200 && $info['http_code'] != 404)
                        $error_page[] = array(2, $page_url, $info['http_code']);
                }
            }
            $response['code'] = $info['http_code'];
            $response['errors'] = $error_page;
            curl_close($ch);
            return $response;
        }

        $ress =  curl_get_contents($rss, $userData['agent'], $userData['refer'], 1, 0);
*/














































    }






}
