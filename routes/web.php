<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Front\IndexController::class, 'index'])->name('index');

Route::get('/news', [\App\Http\Controllers\Front\NewsController::class, 'list'])->name('news');
Route::get('/new/{slug}', [\App\Http\Controllers\Front\NewsController::class, 'item'])->name('new');


Route::get('/posts/{slug?}', [\App\Http\Controllers\Front\PostController::class, 'list'])->name('posts');
Route::get('/post/{slug}', [\App\Http\Controllers\Front\PostController::class, 'item'])->name('post');

Route::get('/tags', [\App\Http\Controllers\Front\TagController::class, 'list'])->name('tags');
Route::get('/tag/{slug}', [\App\Http\Controllers\Front\TagController::class, 'item'])->name('tag');






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';








Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Кэш очищен.";
})->name('clear.cash');



Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isadmin']], function () {

    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('admin.index');
    Route::resource('/category', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('/tag', \App\Http\Controllers\Admin\TagController::class);
    Route::resource('/post', \App\Http\Controllers\Admin\PostController::class);

    //Route::post('/upload-file',[\App\Http\Controllers\Admin\PostController::class, 'upload_file'])->name('dropzone.upload');
    //Route::post('/remove-img',[\App\Http\Controllers\Admin\PostController::class, 'remove_img'])->name('remove.img');

    Route::post('/remove-img', [App\Http\Controllers\Admin\PostController::class, 'removeImg'])->name('remove.img');
    Route::post('/update-img', [App\Http\Controllers\Admin\PostController::class, 'updateImg'])->name('update.img');


    Route::get('/test', [\App\Http\Controllers\Admin\PostController::class, 'test'])->name('admin.test');
});
