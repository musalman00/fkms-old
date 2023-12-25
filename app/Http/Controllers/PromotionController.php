<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\KioskParticipant;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PromotionStoreRequest;
use App\Http\Requests\PromotionUpdateRequest;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Promotion::class);

        $search = $request->get('search', '');

        $promotions = Promotion::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.promotions.index', compact('promotions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Promotion::class);

        $kioskParticipants = KioskParticipant::pluck('id', 'id');

        return view('app.promotions.create', compact('kioskParticipants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromotionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Promotion::class);

        $validated = $request->validated();

        $promotion = Promotion::create($validated);

        return redirect()
            ->route('promotions.edit', $promotion)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Promotion $promotion): View
    {
        $this->authorize('view', $promotion);

        return view('app.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Promotion $promotion): View
    {
        $this->authorize('update', $promotion);

        $kioskParticipants = KioskParticipant::pluck('id', 'id');

        return view(
            'app.promotions.edit',
            compact('promotion', 'kioskParticipants')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PromotionUpdateRequest $request,
        Promotion $promotion
    ): RedirectResponse {
        $this->authorize('update', $promotion);

        $validated = $request->validated();

        $promotion->update($validated);

        return redirect()
            ->route('promotions.edit', $promotion)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Promotion $promotion
    ): RedirectResponse {
        $this->authorize('delete', $promotion);

        $promotion->delete();

        return redirect()
            ->route('promotions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
