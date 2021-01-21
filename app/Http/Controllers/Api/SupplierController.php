<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return Supplier::query()->requestBuilder()->paginate(request('itemsPerPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SupplierRequest $request
     * @return Supplier
     */
    public function store(SupplierRequest $request): Supplier
    {
        return Supplier::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param Supplier $supplier
     * @return Supplier
     */
    public function show(Supplier $supplier): Supplier
    {
        return $supplier;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SupplierRequest $request
     * @param Supplier $supplier
     * @return Supplier
     */
    public function update(SupplierRequest $request, Supplier $supplier): Supplier
    {
        $supplier->update($request->validated());
        return $supplier->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Supplier $supplier
     * @return JsonResponse
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        $supplier->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
