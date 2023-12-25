<?php

namespace App\Http\Controllers\Api;

use App\Models\Kiosk;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\KioskResource;
use App\Http\Resources\KioskCollection;
use App\Http\Requests\KioskStoreRequest;
use App\Http\Requests\KioskUpdateRequest;

class KioskController extends Controller
{
    public function index(Request $request): KioskCollection
    {
        $this->authorize('view-any', Kiosk::class);

        $search = $request->get('search', '');

        $kiosks = Kiosk::search($search)
            ->latest()
            ->paginate();

        return new KioskCollection($kiosks);
    }

    public function store(KioskStoreRequest $request): KioskResource
    {
        $this->authorize('create', Kiosk::class);

        $validated = $request->validated();

        $kiosk = Kiosk::create($validated);

        return new KioskResource($kiosk);
    }

    public function show(Request $request, Kiosk $kiosk): KioskResource
    {
        $this->authorize('view', $kiosk);

        return new KioskResource($kiosk);
    }

    public function update(
        KioskUpdateRequest $request,
        Kiosk $kiosk
    ): KioskResource {
        $this->authorize('update', $kiosk);

        $validated = $request->validated();

        $kiosk->update($validated);

        return new KioskResource($kiosk);
    }

    public function destroy(Request $request, Kiosk $kiosk): Response
    {
        $this->authorize('delete', $kiosk);

        $kiosk->delete();

        return response()->noContent();
    }
}
