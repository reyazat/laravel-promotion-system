<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Promotion\PromotionRequest;
use App\Http\Resources\Promotion\PromotionResource;
use App\Http\Resources\DummyResource;
use App\Http\Resources\ResponseCollection;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index():ResponseCollection
    {
        return new ResponseCollection(PromotionResource::class, Promotion::query());
    }

    public function store(PromotionRequest $request):PromotionResource
    {
        return new PromotionResource(Promotion::query()->create($request->validated()));
    }

    public function show($promotion):PromotionResource
    {
        return new PromotionResource($promotion);
    }

    public function update(PromotionRequest $request, $promotion):PromotionResource
    {
        return new PromotionResource($promotion->update($request->validated()));
    }

    public function destroy($promotion):DummyResource
    {
        $promotion->delete();
        return new DummyResource([
            'status' => 'success',
            'message' => 'Promotion deleted successfully'
        ]);
    }
}
