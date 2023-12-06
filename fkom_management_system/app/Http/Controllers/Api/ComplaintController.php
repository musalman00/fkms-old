<?php

namespace App\Http\Controllers\Api;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintResource;
use App\Http\Resources\ComplaintCollection;
use App\Http\Requests\ComplaintStoreRequest;
use App\Http\Requests\ComplaintUpdateRequest;

class ComplaintController extends Controller
{
    public function index(Request $request): ComplaintCollection
    {
        $this->authorize('view-any', Complaint::class);

        $search = $request->get('search', '');

        $complaints = Complaint::search($search)
            ->latest()
            ->paginate();

        return new ComplaintCollection($complaints);
    }

    public function store(ComplaintStoreRequest $request): ComplaintResource
    {
        $this->authorize('create', Complaint::class);

        $validated = $request->validated();

        $complaint = Complaint::create($validated);

        return new ComplaintResource($complaint);
    }

    public function show(
        Request $request,
        Complaint $complaint
    ): ComplaintResource {
        $this->authorize('view', $complaint);

        return new ComplaintResource($complaint);
    }

    public function update(
        ComplaintUpdateRequest $request,
        Complaint $complaint
    ): ComplaintResource {
        $this->authorize('update', $complaint);

        $validated = $request->validated();

        $complaint->update($validated);

        return new ComplaintResource($complaint);
    }

    public function destroy(Request $request, Complaint $complaint): Response
    {
        $this->authorize('delete', $complaint);

        $complaint->delete();

        return response()->noContent();
    }
}
