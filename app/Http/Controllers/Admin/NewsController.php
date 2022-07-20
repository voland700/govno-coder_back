<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = Information::select('id', 'title', 'slug', 'active', 'created_at')->get();
        //dd($posts);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
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
        $data['active'] = $request->active ? 1 : 0;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path_to = '/news/' . getfolderName() . '/';
            $fileName = 'news_' . Str::lower(Str::random(8)) . '.' .$image->getClientOriginalExtension();
            $path = $image->storeAs($path_to, $fileName, 'public');
            $data['image'] = '/storage'.$path_to.$fileName;
        }
        Information::create($data);
        return redirect()->route('news.index')->with('success', 'Новость добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $new = Information::find($id);
        return view('admin.news.update', compact('new'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $new = Information::find($id);
        $img = [];

        if($new->image &&  Storage::disk('public')->exists(str_replace('storage', '', $new->image))){
            $img['url'] = $new->image;
            $img['name'] =  basename($new->image);
        } else {
            $img['url'] = null;
            $img['name'] = null;
        }
        return view('admin.news.update', compact('new', 'img'));
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
        $new = Information::find($id);
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        dd($request->active);
        //$new->update($data);
        return redirect()->route('news.index')->with('success', 'Данные обновлены');
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
        $new = Information::find($request->id);
        if (Storage::disk('public')->exists(str_replace('storage', '', $new->image))){
            Storage::disk('public')->delete(str_replace('storage', '', $new->image));
        }
        $new->image = null;
        $new->save();
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
        $new = Information::find($request->id);
        if ($request->file) {
            if ($new->image && Storage::disk('public')->exists(str_replace('storage', '', $new->image))){
                Storage::disk('public')->delete(str_replace('storage', '', $new->image));
            }
            $image = $request->file('file');
            $path_to = '/news/' . getfolderName() . '/';
            $fileName = 'news_' . Str::lower(Str::random(8)) . '.' .$image->getClientOriginalExtension();
            $image->storeAs($path_to, $fileName, 'public');
            $new->image  = '/storage'.$path_to.$fileName;
            $new->save();
            $template = ' <div class="post_img_wrap mb-3"><img src="'.'/storage'.$path_to.$fileName.'" alt="Изображение" id="imgPost" class="post_img"></div>
                          <div class="post_btn_img_delete" id="imgDelete" onclick="imageRemove()"><i class="fas fa-times"></i></div>';
            return response()->json([
                'template' => $template,
                'fileName' => $fileName,
                'error' => false,
                'errorMessage' => null,
            ]);
        } else {
            return false;
        }
    }
}
