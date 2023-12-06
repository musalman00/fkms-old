<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\KioskParticipant;
use App\Http\Controllers\Controller;
use App\Http\Resources\KioskParticipantResource;
use App\Http\Resources\KioskParticipantCollection;
use App\Http\Requests\KioskParticipantStoreRequest;
use App\Http\Requests\KioskParticipantUpdateRequest;

class KioskParticipantController extends Controller
{
    public function index(Request $request): KioskParticipantCollection
    {
        $this->authorize('view-any', KioskParticipant::class);

        $search = $request->get('search', '');

        $kioskParticipants = KioskParticipant::search($search)
            ->latest()
            ->paginate();

        return new KioskParticipantCollection($kioskParticipants);
    }

    public function store(
        KioskParticipantStoreRequest $request
    ): KioskParticipantResource {
        $this->authorize('create', KioskParticipant::class);

        $validated = $request->validated();

        $kioskParticipant = KioskParticipant::create($validated);

        return new KioskParticipantResource($kioskParticipant);
    }

    public function show(
        Request $request,
        KioskParticipant $kioskParticipant
    ): KioskParticipantResource {
        $this->authorize('view', $kioskParticipant);

        return new KioskParticipantResource($kioskParticipant);
    }

    public function update(
        KioskParticipantUpdateRequest $request,
        KioskParticipant $kioskParticipant
    ): KioskParticipantResource {
        $this->authorize('update', $kioskParticipant);

        $validated = $request->validated();

        $kioskParticipant->update($validated);

        return new KioskParticipantResource($kioskParticipant);
    }

    public function destroy(
        Request $request,
        KioskParticipant $kioskParticipant
    ): Response {
        $this->authorize('delete', $kioskParticipant);

        $kioskParticipant->delete();

        return response()->noContent();
    }
}
