<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return Warehouse::query()->requestBuilder()->paginate(request('itemsPerPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Warehouse $request
     * @return Warehouse
     */
    public function store(WarehouseRequest $request): Warehouse
    {
        return Warehouse::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param Warehouse $warehouse
     * @return Warehouse
     */
    public function show(Warehouse $warehouse): Warehouse
    {
        return $warehouse;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WarehouseRequest $request
     * @param Warehouse $warehouse
     * @return Warehouse
     */
    public function update(WarehouseRequest $request, Warehouse $warehouse): Warehouse
    {
        $warehouse->update($request->validated());
        return $warehouse->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Warehouse $warehouse
     * @return JsonResponse
     */
    public function destroy(Warehouse $warehouse): JsonResponse
    {
        $warehouse->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
