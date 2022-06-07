<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class DropzoneController extends Controller
{
    public function upload_file(Request $request)
    {
        if($request->hasFile('file')){
            $image = $request->file('file');
            $fileName = time() . '_' . Str::lower(Str::random(2)) . '.' . $image->getClientOriginalExtension();
            $path_to = '/images/' . substr(str_shuffle("01234567890123456789"), 0, 2);
            if($request->type == 'img'){
                $image->storeAs('public' . $path_to, 'big_'.$fileName);
                $imgPath = 'storage' . $path_to . '/' . 'big_'.$fileName;
            }
            if($request->type == 'preview'){
                $image->storeAs('public' . $path_to, 'small_'.$fileName);
                Image::make(storage_path('app/public'.$path_to.'/'.'small_'.$fileName))->resize(450, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
                $imgPath = 'storage' . $path_to . '/' . 'small_'.$fileName;
            }
            return response()->json(['path' => $imgPath]);
        } else {
            return response()->json(['error' =>'Файл не загружен']);
        }
    }

    public function remove_tmp_file(Request $request)
    {

        if (Storage::disk('public')->exists(str_replace('storage', '', $request->path))){
            Storage::disk('public')->delete(str_replace('storage', '', $request->path));
        }
        return response()->json(['success'=>200]);
    }



}
