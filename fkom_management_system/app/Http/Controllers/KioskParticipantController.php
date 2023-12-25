<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kiosk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\KioskParticipant;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\KioskParticipantStoreRequest;
use App\Http\Requests\KioskParticipantUpdateRequest;

class KioskParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', KioskParticipant::class);

        $search = $request->get('search', '');

        $kioskParticipants = KioskParticipant::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.kiosk_participants.index',
            compact('kioskParticipants', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', KioskParticipant::class);

        $users = User::pluck('name', 'id');
        $kiosks = Kiosk::pluck('name', 'id');

        return view(
            'app.kiosk_participants.create',
            compact('users', 'kiosks')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        KioskParticipantStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', KioskParticipant::class);

        $validated = $request->validated();

        $kioskParticipant = KioskParticipant::create($validated);

        return redirect()
            ->route('kiosk-participants.edit', $kioskParticipant)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        KioskParticipant $kioskParticipant
    ): View {
        $this->authorize('view', $kioskParticipant);

        return view('app.kiosk_participants.show', compact('kioskParticipant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        KioskParticipant $kioskParticipant
    ): View {
        $this->authorize('update', $kioskParticipant);

        $users = User::pluck('name', 'id');
        $kiosks = Kiosk::pluck('name', 'id');

        return view(
            'app.kiosk_participants.edit',
            compact('kioskParticipant', 'users', 'kiosks')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        KioskParticipantUpdateRequest $request,
        KioskParticipant $kioskParticipant
    ): RedirectResponse {
        $this->authorize('update', $kioskParticipant);

        $validated = $request->validated();

        $kioskParticipant->update($validated);

        return redirect()
            ->route('kiosk-participants.edit', $kioskParticipant)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        KioskParticipant $kioskParticipant
    ): RedirectResponse {
        $this->authorize('delete', $kioskParticipant);

        $kioskParticipant->delete();

        return redirect()
            ->route('kiosk-participants.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
