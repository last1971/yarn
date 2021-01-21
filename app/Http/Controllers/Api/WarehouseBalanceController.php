<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseBalanceRequest;
use App\Models\WarehouseBalance;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class WarehouseBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return WarehouseBalance::query()->requestBuilder()->paginate(request('itemsPerPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WarehouseBalance $request
     * @return WarehouseBalance
     */
    public function store(WarehouseBalanceRequest $request): WarehouseBalance
    {
        return WarehouseBalance::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param WarehouseBalance $warehouseBalance
     * @return WarehouseBalance
     */
    public function show(WarehouseBalance $warehouseBalance): WarehouseBalance
    {
        return $warehouseBalance;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WarehouseBalanceRequest $request
     * @param WarehouseBalance $warehouseBalance
     * @return WarehouseBalance
     */
    public function update(WarehouseBalanceRequest $request, WarehouseBalance $warehouseBalance): WarehouseBalance
    {
        $warehouseBalance->update($request->validated());
        return $warehouseBalance->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  WarehouseBalance $warehouse
     * @return JsonResponse
     */
    public function destroy(WarehouseBalance $warehouseBalance): JsonResponse
    {
        $warehouseBalance->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
