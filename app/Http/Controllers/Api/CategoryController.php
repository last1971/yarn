<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Kalnoy\Nestedset\QueryBuilder;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Paginator|View
     */
    public function index()
    {
        request()->merge(
            [
                'itemsPerPage' => request('itemsPerPage') && request('itemsPerPage') > 0
                    ? request('itemsPerPage')
                    : env('MYSQL_MAX', 1000),
            ]
        );
        $response = Category::query()
            ->requestBuilder()
            ->when(request('isLeaf'), function (QueryBuilder $query) {
                $query->whereRaw('_lft +1 = _rgt');
            })
            ->paginate(request('itemsPerPage'));
        return request()->has('_escaped_fragment_')
            ? view('categories', [ 'categories' => $response ])
            : $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return Category
     */
    public function store(CategoryRequest $request): Category
    {
        return Category::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @return Category
     */
    public function show(Category $category)
    {
        return request()->has('_escaped_fragment_')
            ? view('category', ['category' => $category])
            : $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return Category
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return $category;
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
}
