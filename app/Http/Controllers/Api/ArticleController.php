<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\PictureRequest;
use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Image;
use Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return Article::query()
            ->where('name', 'like', "%{$request->get('name')}%" )
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return Model
     */
    public function store(ArticleRequest $request): Model
    {
        return Article::query()->create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Model
     */
    public function update(ArticleRequest $request, Article $article): Model
    {
        $article->update($request->validated());
        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function picture(PictureRequest $request): JsonResponse
    {
        $file = $request->file('picture');
        if (!Storage::disk('public')->exists('articles/' . $request->get('slug'))) {
            Storage::disk('public')->makeDirectory('articles/' . $request->get('slug'));
        }
        $name = 'articles/' . $request->get('slug') . '/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        Image::make($file)->save(public_path($name));
        return response()->json([ 'src' => '/' . $name]);
    }
}
