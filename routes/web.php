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

Route::get('/', [\App\Http\Controllers\Front\PostController::class, 'index'])->name('index');

Route::get('/news-list', [\App\Http\Controllers\Front\NewsController::class, 'list'])->name('news');
Route::get('/news-item/{slug}', [\App\Http\Controllers\Front\NewsController::class, 'item'])->name('new');


Route::get('/post-list/{slug}', [\App\Http\Controllers\Front\PostController::class, 'list'])->name('posts');
Route::get('/post-item/{slug}', [\App\Http\Controllers\Front\PostController::class, 'item'])->name('post');
Route::get('/search', [\App\Http\Controllers\Front\PostController::class, 'search'])->name('search');


Route::get('/tags-list', [\App\Http\Controllers\Front\TagController::class, 'list'])->name('tags');
Route::get('/tags-item/{slug}', [\App\Http\Controllers\Front\TagController::class, 'tags'])->name('tag');



Route::get('/user-auth', [App\Http\Controllers\Front\UserController::class, 'userAuth'])->name('user.auth');
Route::post('/user-login', [App\Http\Controllers\Front\UserController::class, 'userAuthStore'])->name('user.auth.store');


Route::get('/user-register', [App\Http\Controllers\Front\UserController::class, 'userRegister'])->name('user.register');
Route::post('/user-store', [App\Http\Controllers\Front\UserController::class, 'userStore'])->name('user.store');

Route::post('/comment-store', [App\Http\Controllers\Front\CommentController::class, 'store'])->name('comment.store');

Route::post('/comment-reaction', [App\Http\Controllers\Front\CommentController::class, 'reaction'])->name('comment.reaction');

//remove
Route::get('/comment-test', [App\Http\Controllers\Front\CommentController::class, 'test']);




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
    Route::get('/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users');

    Route::get('/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users');
    Route::get('/user-detail/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'detail'])->name('admin.users.detail');

    Route::get('/comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin.comments');
    Route::get('/comments-tree/{id}', [\App\Http\Controllers\Admin\CommentController::class, 'commentsTree'])->name('admin.comments.tree');

    Route::get('/comments-edit/{id}', [\App\Http\Controllers\Admin\CommentController::class, 'edit'])->name('comment.edit');
    Route::delete('/comments-destroy/{id}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comment.destroy');
    Route::post('/comments-update/{id}', [\App\Http\Controllers\Admin\CommentController::class, 'update'])->name('comment.update');

    Route::resource('/news', \App\Http\Controllers\Admin\NewsController::class);






    //Route::post('/upload-file',[\App\Http\Controllers\Admin\PostController::class, 'upload_file'])->name('dropzone.upload');
    //Route::post('/remove-img',[\App\Http\Controllers\Admin\PostController::class, 'remove_img'])->name('remove.img');

    Route::post('/remove-img', [App\Http\Controllers\Admin\PostController::class, 'removeImg'])->name('remove.img');
    Route::post('/update-img', [App\Http\Controllers\Admin\PostController::class, 'updateImg'])->name('update.img');

    Route::post('/remove-new-img', [App\Http\Controllers\Admin\NewsController::class, 'removeImg'])->name('remove.new.img');
    Route::post('/update-new-img', [App\Http\Controllers\Admin\NewsController::class, 'updateImg'])->name('update.new.img');


    Route::get('/parser', [App\Http\Controllers\News\NewsController::class, 'getNews'])->name('parser');
    Route::get('/pars-links', [App\Http\Controllers\News\NewsController::class, 'parsingListLinks'])->name('pars.links');

    Route::get('/sitemap', [\App\Http\Controllers\Admin\SitemapController::class, 'createSitemap'])->name('sitemap');


});

Route::get('/test', [App\Http\Controllers\News\NewsController::class, 'test']);
