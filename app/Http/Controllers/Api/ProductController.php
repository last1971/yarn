<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return Product::query()->requestBuilder()->paginate(request('itemsPerPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return Product
     */
    public function store(ProductRequest $request): Product
    {
        return Product::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Product
     */
    public function show(Product $product): Product
    {
        return $product;
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
