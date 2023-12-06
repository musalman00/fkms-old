<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KioskParticipantResource;
use App\Http\Resources\KioskParticipantCollection;

class UserKioskParticipantsController extends Controller
{
    public function index(
        Request $request,
        User $user
    ): KioskParticipantCollection {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $kioskParticipants = $user
            ->kioskParticipants()
            ->search($search)
            ->latest()
            ->paginate();

        return new KioskParticipantCollection($kioskParticipants);
    }

    public function store(
        Request $request,
        User $user
    ): KioskParticipantResource {
        $this->authorize('create', KioskParticipant::class);

        $validated = $request->validate([
            'kiosk_id' => ['required', 'exists:kiosks,id'],
        ]);

        $kioskParticipant = $user->kioskParticipants()->create($validated);

        return new KioskParticipantResource($kioskParticipant);
    }
}
