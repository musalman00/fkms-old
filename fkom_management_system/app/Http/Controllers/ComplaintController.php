<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\KioskParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ComplaintStoreRequest;
use App\Http\Requests\ComplaintUpdateRequest;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Complaint::class);

        $search = $request->get('search', '');

        $complaints = Complaint::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.complaints.index', compact('complaints', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Complaint::class);

        $kioskParticipants = KioskParticipant::pluck('id', 'id');

        return view('app.complaints.create', compact('kioskParticipants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComplaintStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Complaint::class);

        $validated = $request->validated();
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request
                ->file('attachment')
                ->store('public');
        }

        $complaint = Complaint::create($validated);

        return redirect()
            ->route('complaints.edit', $complaint)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Complaint $complaint): View
    {
        $this->authorize('view', $complaint);

        return view('app.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Complaint $complaint): View
    {
        $this->authorize('update', $complaint);

        $kioskParticipants = KioskParticipant::pluck('id', 'id');

        return view(
            'app.complaints.edit',
            compact('complaint', 'kioskParticipants')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ComplaintUpdateRequest $request,
        Complaint $complaint
    ): RedirectResponse {
        $this->authorize('update', $complaint);

        $validated = $request->validated();
        if ($request->hasFile('attachment')) {
            if ($complaint->attachment) {
                Storage::delete($complaint->attachment);
            }

            $validated['attachment'] = $request
                ->file('attachment')
                ->store('public');
        }

        $complaint->update($validated);

        return redirect()
            ->route('complaints.edit', $complaint)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Complaint $complaint
    ): RedirectResponse {
        $this->authorize('delete', $complaint);

        if ($complaint->attachment) {
            Storage::delete($complaint->attachment);
        }

        $complaint->delete();

        return redirect()
            ->route('complaints.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
