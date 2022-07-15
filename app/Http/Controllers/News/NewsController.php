<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;


use App\Http\Helpers\ParserContent;
use App\Http\Helpers\ParserLinks;

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
}
