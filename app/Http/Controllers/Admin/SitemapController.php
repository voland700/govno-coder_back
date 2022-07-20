<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Category;
use App\Models\Post;
use App\Models\Information;






class SitemapController extends Controller
{
    public function createSitemap()
    {
        $path = public_path() . '/sitemap.xml';
        $res = Sitemap::create();

        // Главная
        $res->add(
            Url::create(route('index'))
                //->setLastModificationDate(null)
                ->setChangeFrequency('daily')
                ->setPriority(0.8)
        );
        // Статьи - категории

        $categories = Category::where('active', 1)->select('id', 'slug', 'updated_at')->get();
        foreach ($categories as $category) {
            $res->add(
                Url::create(route('posts', $category->slug))
                    ->setLastModificationDate(Carbon::parse($category->updated_at))
                    ->setChangeFrequency('daily')
                    ->setPriority(0.8)
            );
        }
        // Статьи
        $posts = Post::where('active', 1)->select('id', 'slug', 'updated_at')->get();
        foreach ($posts as $post) {
            $res->add(
                Url::create(route('post', $post->slug))
                    ->setLastModificationDate(Carbon::parse($post->updated_at))
                    ->setChangeFrequency('daily')
                    ->setPriority(0.8)
            );
        }
        // Новости
        $res->add('/news-list');
        $news = Information::where('active', 1)->select('id', 'slug', 'updated_at')->get();
        foreach ($news as $new) {
            $res->add(
                Url::create(route('new', $new->slug))
                    ->setLastModificationDate(Carbon::parse($new->updated_at))
                    ->setChangeFrequency('daily')
                    ->setPriority(0.8)
            );
        }

        $res->writeToFile($path);
        return $res;
    }
}
