<?php

namespace App\Http\Controllers\Api;

use App\Models\Kiosk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KioskParticipantResource;
use App\Http\Resources\KioskParticipantCollection;

class KioskKioskParticipantsController extends Controller
{
    public function index(
        Request $request,
        Kiosk $kiosk
    ): KioskParticipantCollection {
        $this->authorize('view', $kiosk);

        $search = $request->get('search', '');

        $kioskParticipants = $kiosk
            ->kioskParticipants()
            ->search($search)
            ->latest()
            ->paginate();

        return new KioskParticipantCollection($kioskParticipants);
    }

    public function store(
        Request $request,
        Kiosk $kiosk
    ): KioskParticipantResource {
        $this->authorize('create', KioskParticipant::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $kioskParticipant = $kiosk->kioskParticipants()->create($validated);

        return new KioskParticipantResource($kioskParticipant);
    }
}
