<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\KioskParticipant;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintResource;
use App\Http\Resources\ComplaintCollection;

class KioskParticipantComplaintsController extends Controller
{
    public function index(
        Request $request,
        KioskParticipant $kioskParticipant
    ): ComplaintCollection {
        $this->authorize('view', $kioskParticipant);

        $search = $request->get('search', '');

        $complaints = $kioskParticipant
            ->complaints()
            ->search($search)
            ->latest()
            ->paginate();

        return new ComplaintCollection($complaints);
    }

    public function store(
        Request $request,
        KioskParticipant $kioskParticipant
    ): ComplaintResource {
        $this->authorize('create', Complaint::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'category' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'attachment' => ['required', 'max:255', 'string'],
            'technician_assign' => ['required', 'max:255', 'string'],
            'reply' => ['required', 'max:255', 'string'],
            'status' => ['required', 'in:pending,done'],
        ]);

        $complaint = $kioskParticipant->complaints()->create($validated);

        return new ComplaintResource($complaint);
    }
}
