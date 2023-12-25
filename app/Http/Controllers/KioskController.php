<?php

namespace App\Http\Controllers;

use App\Models\Kiosk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\KioskStoreRequest;
use App\Http\Requests\KioskUpdateRequest;

class KioskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Kiosk::class);

        $search = $request->get('search', '');

        $kiosks = Kiosk::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.kiosks.index', compact('kiosks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Kiosk::class);

        return view('app.kiosks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KioskStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Kiosk::class);

        $validated = $request->validated();

        $kiosk = Kiosk::create($validated);

        return redirect()
            ->route('kiosks.edit', $kiosk)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Kiosk $kiosk): View
    {
        $this->authorize('view', $kiosk);

        return view('app.kiosks.show', compact('kiosk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Kiosk $kiosk): View
    {
        $this->authorize('update', $kiosk);

        return view('app.kiosks.edit', compact('kiosk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        KioskUpdateRequest $request,
        Kiosk $kiosk
    ): RedirectResponse {
        $this->authorize('update', $kiosk);

        $validated = $request->validated();

        $kiosk->update($validated);

        return redirect()
            ->route('kiosks.edit', $kiosk)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Kiosk $kiosk): RedirectResponse
    {
        $this->authorize('delete', $kiosk);

        $kiosk->delete();

        return redirect()
            ->route('kiosks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
