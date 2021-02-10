<?php

use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Butschster\Head\Facades\Meta;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use \App\Http\Controllers\Api\CategoryController;
use \App\Http\Controllers\Api\ProductController;

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

if (request()->has('_escaped_fragment_')) {
    Route::get('/', [ CategoryController::class, 'index' ]);
    Route::get('/category/{category}/{slug}', [ CategoryController::class, 'show' ])->name('category');
    Route::get('/category', [ CategoryController::class, 'index' ]);
    Route::get('/product/{product}/{slug}', [ ProductController::class, 'show' ])->name('product');
    Route::get('/product', [ ProductController::class, 'index' ]);
}

Route::get('/{type?}', function ($type = 'category') {
    $titles = [
        'category' => 'Категории товаров',
        'product' => 'Продукты',
        'order' => 'Как оформить заказ',
    ];
    $og = new OpenGraphPackage('og');
    $og->setType('website');
    $og->setDescription($titles[$type]);
    $og->setTitle($titles[$type]);
    $og->setSiteName(env('APP_NAME'));
    $og->setUrl(url()->current());
    $og->addImage(url()->route('article-picture', ['article' => 'about', 'picture' => 'default']));
    Meta::registerPackage($og);    return view('app');
})->where([ 'type' => 'category|order|product' ]);

Route::get('/{path}/{id}/{slug}', function ($path, $id) {
    $classes = [
        'category' => \App\Models\Category::class,
        'product' => \App\Models\Product::class,
    ];
    $model = (new $classes[$path]())->find($id);
    if (!$model) return abort(404);
    $og = new OpenGraphPackage('og');
    $og->setType($path);
    $og->setDescription($model->description);
    $og->setTitle($model->name);
    $og->setSiteName(env('APP_NAME'));
    $og->setUrl(url()->current());
    $og->addImage(
        url()->route(
            'model-picture',
            ['slug' => $model->slug, 'id' => $model->id, 'picture' => $model->picture ? $model->picture->file : '1']
        )
    );
    Meta::registerPackage($og);    return view('app');
    return view('app');
})->where([ 'path' => 'category|product' ]);

/* Pictures */

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
})->name('article-picture');

Route::get('/picture/{slug}/{id}/{picture}', function(string $slug, string $id, string $picture) {
    return Cache::remember(url()->current(), 3600, function () use ($slug, $id, $picture) {
        $path = Storage::exists('public/pictures/' . $slug . '/' . $id . '/' . $picture)
            ? 'pictures/' . $slug . '/' . $id . '/' . $picture
            : 'articles/default.png';
        return Image::make(public_path($path))->response();
    });
    /*
    return Image::cache(function($image) use ($slug, $id, $picture) {
        $path = Storage::exists('public/pictures/' . $slug . '/' . $id . '/' . $picture)
            ? 'pictures/' . $slug . '/' . $id . '/' . $picture
            : 'articles/default.png';
        $image->make(public_path($path));
    }, 10, true)->response();*/
})->name('model-picture');

/*
Route::get('/{path?}', function () {
    return view('app');
});
Route::get('/{path?}/{id?}', function () {
    return view('app');
});

Route::get('/{path?}/{slug?}/{id?}', function () {
    return view('app');
});
*/

