<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;




class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['categories' => function($q) {
            $q->select( 'name');
         }])->select('id', 'name', 'active')->get();
        //dd($posts);
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesArr = Category::select('id', 'name')->get()->toArray();
        $categories = [];
        foreach ($categoriesArr as $item) $categories[$item['id']] = $item['name'];
        $tags = Tag::select('id', 'name')->get();
        return view('admin.post.create', compact('categories', 'tags'));
        //dd($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->has('active') ? 1 : 0;
        $post = Post::create($data);
        if ($request->image) {
            $post->addMediaFromRequest('image')->toMediaCollection('main');
        }
        if($request->categories){
            $post->categories()->attach($request->categories);
        }
        if($request->tags){
            $post->tags()->attach($request->tags);
        }
        return redirect()->route('post.index')->with('success', 'Новая статья добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = Post::with('categories', 'tags')->find($id);


        $categoriesArr = Category::select('id', 'name')->get()->toArray();
        $categories = [];
        foreach ($categoriesArr as $item) $categories[$item['id']] = $item['name'];
        $selectedCategories = $post->categories->pluck('id')->toArray();
        $tags = Tag::select('id', 'name')->get();
        $selectedTags = $post->tags->pluck('id')->toArray();
        $img = [];
        $media = $post->getMedia('main');
        if($media->isNotEmpty()){
            $img['url'] = $media[0]->getURL();
            $img['name'] = $media[0]->file_name;
        } else {
            $img['url'] = null;
            $img['name'] = null;
        }


        //dd($media->isNotEmpty());
        //$img['url'] = $post->getFirstMediaUrl('main');
        /*
        $post = Post::find($id);
        $media = $post->getMedia('main');
        $path = $media[0]->getPath();
        $name = $media[0]->name;
        //$img = $post->getFirstMediaUrl('main');
        dd($name);
        */
        return view('admin.post.update', compact('post', 'categories', 'selectedCategories', 'tags', 'selectedTags', 'img'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function removeImg(Request $request)
    {
        $post = Post::find($request->id);
        $media = $post->getMedia('main');
        $media[0]->delete();
        return 'success';
    }

    public function updateImg(Request $request)
    {


        return $request->id;



    }




}
