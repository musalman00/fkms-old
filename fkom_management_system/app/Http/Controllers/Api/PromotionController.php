<?php

namespace App\Http\Controllers\Api;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Http\Resources\PromotionCollection;
use App\Http\Requests\PromotionStoreRequest;
use App\Http\Requests\PromotionUpdateRequest;

class PromotionController extends Controller
{
    public function index(Request $request): PromotionCollection
    {
        $this->authorize('view-any', Promotion::class);

        $search = $request->get('search', '');

        $promotions = Promotion::search($search)
            ->latest()
            ->paginate();

        return new PromotionCollection($promotions);
    }

    public function store(PromotionStoreRequest $request): PromotionResource
    {
        $this->authorize('create', Promotion::class);

        $validated = $request->validated();

        $promotion = Promotion::create($validated);

        return new PromotionResource($promotion);
    }

    public function show(
        Request $request,
        Promotion $promotion
    ): PromotionResource {
        $this->authorize('view', $promotion);

        return new PromotionResource($promotion);
    }

    public function update(
        PromotionUpdateRequest $request,
        Promotion $promotion
    ): PromotionResource {
        $this->authorize('update', $promotion);

        $validated = $request->validated();

        $promotion->update($validated);

        return new PromotionResource($promotion);
    }

    public function destroy(Request $request, Promotion $promotion): Response
    {
        $this->authorize('delete', $promotion);

        $promotion->delete();

        return response()->noContent();
    }
}
