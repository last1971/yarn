<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class ProductController extends Controller
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
                'selectedParameters' => json_decode(request('selectedParameters'), true) ?? [],
                'itemsPerPage' => request('itemsPerPage') && request('itemsPerPage') > 0
                    ? request('itemsPerPage')
                    : env('MYSQL_MAX', 1000),
            ]
        );
        $response = Product::query()
            ->requestBuilder()
            ->withCount('warehouseBalances')
            ->withSum('warehouseBalances', 'balance')
            ->paginate(request('itemsPerPage'));
        return request()->has('_escaped_fragment_')
            ? view('products', [ 'products' => $response ])
            : $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return Product|View
     */
    public function store(ProductRequest $request)
    {
        return Product::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Product|View
     */
    public function show(Product $product)
    {
        return request()->has('_escaped_fragment_')
            ? view('product', ['product' => $product])
            : $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return Product
     */
    public function update(ProductRequest $request, Product $product): Product
    {
        $product->update($request->validated());
        return $product->refresh();
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
