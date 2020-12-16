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

Route::get('/avatar/{size}/{avatar}', function (int $size, string $avatar) {
    $path = Storage::exists('public/avatars/' . $avatar )
        ? 'avatars/' . $avatar
        : 'avatars/default.png';
    return Image::make(public_path($path))->resize($size, $size)->response();
});

Route::get('/picture/{article}/{picture}', function(string $article, string $picture) {
    $path = Storage::exists('public/articles/' . $article . '/' . $picture)
        ? 'articles/' . $article . '/' . $picture
        : 'articles/default.png';
    return Image::make(public_path($path))->response();
});

Route::get('/{path?}', function () {
    return view('app');
});
Route::get('/{path?}/{id?}', function () {
    return view('app');
});

