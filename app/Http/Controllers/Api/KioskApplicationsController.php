<?php

namespace App\Http\Controllers\Api;

use App\Models\Kiosk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ApplicationCollection;

class KioskApplicationsController extends Controller
{
    public function index(Request $request, Kiosk $kiosk): ApplicationCollection
    {
        $this->authorize('view', $kiosk);

        $search = $request->get('search', '');

        $applications = $kiosk
            ->applications()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApplicationCollection($applications);
    }

    public function store(Request $request, Kiosk $kiosk): ApplicationResource
    {
        $this->authorize('create', Application::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'payment_id' => ['required', 'exists:payments,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'operating_day' => ['required', 'max:255', 'string'],
            'operating_hour' => ['required', 'max:255', 'string'],
            'business_type' => ['required', 'max:255', 'string'],
            'status' => ['required', 'in:approve,reject'],
            'reason_reject' => ['required', 'max:255', 'string'],
        ]);

        $application = $kiosk->applications()->create($validated);

        return new ApplicationResource($application);
    }
}
