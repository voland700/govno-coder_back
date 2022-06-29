<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Validator;
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
    public function store(StorePostRequest $request)
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
        $post = Post::find($id);
        $data = $request->all();
        $data['active'] = $request->has('active') ? 1 : 0;
        $post->update($data);
        if($request->categories){
            $post->categories()->sync($request->categories);
        }
        if($request->tags){
            $post->tags()->sync($request->tags);
        }
        return redirect()->route('post.index')->with('success', 'Данные обновлены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::with('categories', 'tags')->find($id);
        $post->categories()->sync([]);
        $post->tags()->sync([]);
        $post->delete();
        return back()->with('success', 'Статья удалёна');
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
        $validator = Validator::make($request->all(), [
            'file' => 'image|mimes:jpeg,jpg,bmp,png|nullable',
            'file.size' => '5120|nullable'
            ], $messages = [
            'file.image' => 'Загружаемый Файл должен быть изображением',
            'file.mimes' => 'Фал с изображением должен иметь расширение: jpeg,jpg,bmp,png',
            'file.size' => 'Размер изображения не должен превышать 5 мб.'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'template' => null,
                'fileName' => null,
                'error' => true,
                'errorMessage' => $errors->first('file'),
            ]);
        }
        $post = Post::find($request->id);
        //if(array_key_exists(0, $post->getMedia('main')->toArray() ))  $post->getMedia('main')[0]->delete();
        if ($request->file) {
            $post->addMediaFromRequest('file')->toMediaCollection('main');
        }
        $post = Post::find($request->id);
        $media = $post->getMedia('main');
        if($media->isNotEmpty()){
            $template = ' <div class="post_img_wrap mb-3"><img src="'.$media[0]->getURL().'" alt="Изображение" id="imgPost" class="post_img"></div>
                          <div class="post_btn_img_delete" id="imgDelete" onclick="imageRemove()"><i class="fas fa-times"></i></div>';
            return response()->json([
                'template' => $template,
                'fileName' => $media[0]->file_name,
                'error' => false,
                'errorMessage' => null,
            ]);
        } else {
            return false;
        }
    }


    public function test()
    {
        $post = Post::find(14);




        //dd($post->getMedia('main')->isNotEmpty());

       dd($post->getFirstMedia('main')->getUrl('full'));
        dd($post->getFirstMedia('main')->hasGeneratedConversion('full'));


        //dd( array_key_exists(0, $post->getMedia('main')->toArray() ));



    }










}
