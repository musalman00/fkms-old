<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ApplicationCollection;

class UserApplicationsController extends Controller
{
    public function index(Request $request, User $user): ApplicationCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $applications = $user
            ->applications()
            ->search($search)
            ->latest()
            ->paginate();

        return new ApplicationCollection($applications);
    }

    public function store(Request $request, User $user): ApplicationResource
    {
        $this->authorize('create', Application::class);

        $validated = $request->validate([
            'kiosk_id' => ['required', 'exists:kiosks,id'],
            'payment_id' => ['required', 'exists:payments,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'operating_day' => ['required', 'max:255', 'string'],
            'operating_hour' => ['required', 'max:255', 'string'],
            'business_type' => ['required', 'max:255', 'string'],
            'status' => ['required', 'in:approve,reject'],
            'reason_reject' => ['required', 'max:255', 'string'],
        ]);

        $application = $user->applications()->create($validated);

        return new ApplicationResource($application);
    }
}
