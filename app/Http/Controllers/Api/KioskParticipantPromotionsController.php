<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\KioskParticipant;
use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Http\Resources\PromotionCollection;

class KioskParticipantPromotionsController extends Controller
{
    public function index(
        Request $request,
        KioskParticipant $kioskParticipant
    ): PromotionCollection {
        $this->authorize('view', $kioskParticipant);

        $search = $request->get('search', '');

        $promotions = $kioskParticipant
            ->promotions()
            ->search($search)
            ->latest()
            ->paginate();

        return new PromotionCollection($promotions);
    }

    public function store(
        Request $request,
        KioskParticipant $kioskParticipant
    ): PromotionResource {
        $this->authorize('create', Promotion::class);

        $validated = $request->validate([
            'picture' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'publish_time' => ['required', 'date'],
            'promotion_ends' => ['required', 'date'],
            'status' => ['required', 'in:approve,reject'],
        ]);

        $promotion = $kioskParticipant->promotions()->create($validated);

        return new PromotionResource($promotion);
    }
}
