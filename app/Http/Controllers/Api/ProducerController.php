<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProducerRequest;
use App\Models\Producer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return Producer::query()->requestBuilder()->paginate(request('itemsPerPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProducerRequest $request
     * @return Producer
     */
    public function store(ProducerRequest $request): Producer
    {
        return Producer::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param Producer $producer
     * @return Producer
     */
    public function show(Producer $producer): Producer
    {
        return $producer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProducerRequest $request
     * @param Producer $producer
     * @return Producer
     */
    public function update(ProducerRequest $request, Producer $producer): Producer
    {
        $producer->update($request->validated());
        return $producer;
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
