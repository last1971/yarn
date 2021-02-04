<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParameterValueRequest;
use App\Models\ParameterValue;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ParameterValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $product = json_decode(request('product'), true);
        $attributes = ['parameter_name_id', 'string_value', 'numeric_value', 'parameter_unit_id', 'fraction'];
        if ($product !== null) {
            $products = Product::select('products.id')
                ->arrayBuilder($product)
                ->withCount('warehouseBalances')
                ->without('parameterValues')
                ->get()
                ->map(function($product) {
                    return $product->id;
                });
            $p = ParameterValue::whereIn('product_id', $products)
                ->without('parameterName', 'parameterUnit')
                ->groupBy($attributes);
                //->get($attributes);
            return $p->count() === 0 ? $p->toSql() : $p->get($attributes);
        }
        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ParameterValueRequest $request
     * @return ParameterValue|Model
     */
    public function store(ParameterValueRequest $request): ParameterValue
    {
        $parameterValue = ParameterValue::create($request->validated());
        $parameterValue->load(['parameterName', 'parameterUnit']);
        return $parameterValue;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ParameterValueRequest $request
     * @param ParameterValue $parameterValue
     * @return ParameterValue
     */
    public function update(ParameterValueRequest $request, ParameterValue $parameterValue): ParameterValue
    {
        $parameterValue->update($request->validated());
        $parameterValue->refresh();
        return $parameterValue;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ParameterValue $parameterValue
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ParameterValue $parameterValue): JsonResponse
    {
        $parameterValue->delete();
        return response()->json(['message' => 'Price was removed']);
    }
}
