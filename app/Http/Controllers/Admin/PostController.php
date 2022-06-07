<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StorePostRequest $request)
    {
        $post = new Post($request->all());
        $post->active = $request->has('active') ? 1 : 0;
        if($request->img || !$request->preview){
            $pathSmall = str_replace('big_', 'small_', $request->img);
            if (Storage::disk('public')->exists(str_replace('storage', '', $request->img))){
                Storage::disk('public')->copy(str_replace('storage', '', $request->img), str_replace('storage', '', $pathSmall));
                Image::make(storage_path(str_replace('storage', 'app/public', $pathSmall)))->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
                $post->preview = $pathSmall;
            }
        }
        $post->save();
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
        //
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
}
