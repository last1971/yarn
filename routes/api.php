<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PictureController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('refresh-user', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('avatar-upload', [UserController::class, 'avatarUpload'])->name('avatar-upload');
    Route::post('picture-upload', [ArticleController::class, 'picture'])->name('picture-upload');

    Route::apiResources([
        'article' => ArticleController::class,
        'category' => CategoryController::class,
        'picture' => PictureController::class,
    ]);
});

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

