<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;

class NewsController extends Controller
{
    public function list()
    {
        $news  = Information::where('active', 1)->select('id', 'title', 'slug', 'preview', 'image', 'created_at')->paginate(12);
        return view('front.news.list', compact('news'));
    }

    public function item(Request $request)
    {
        $new  = Information::where('slug', $request->slug)->first();

        $theLast = Information::orderByDesc('id')
            ->where('id', '<>', $new->id)
            ->where('active', 1)
            ->select('id', 'title', 'slug', 'preview', 'image', 'created_at')
            ->take(3)
            ->get();
        //dd($theLast);
        return view('front.news.item', compact('new', 'theLast'));
    }
}
