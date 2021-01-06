<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PriceRequest;
use App\Models\Price;
use Illuminate\Http\JsonResponse;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PriceRequest $request
     * @return Price
     */
    public function store(PriceRequest $request): Price
    {
        return Price::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PriceRequest $request
     * @param Price $price
     * @return Price
     */
    public function update(PriceRequest $request, Price $price): Price
    {
        $price->update($request->validated());
        return $price;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Price $price
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Price $price): JsonResponse
    {
        $price->delete();
        return response()->json(['message' => 'Price was removed']);
    }
}
