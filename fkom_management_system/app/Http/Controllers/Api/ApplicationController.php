<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ApplicationCollection;
use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Requests\ApplicationUpdateRequest;

class ApplicationController extends Controller
{
    public function index(Request $request): ApplicationCollection
    {
        $this->authorize('view-any', Application::class);

        $search = $request->get('search', '');

        $applications = Application::search($search)
            ->latest()
            ->paginate();

        return new ApplicationCollection($applications);
    }

    public function store(ApplicationStoreRequest $request): ApplicationResource
    {
        $this->authorize('create', Application::class);

        $validated = $request->validated();

        $application = Application::create($validated);

        return new ApplicationResource($application);
    }

    public function show(
        Request $request,
        Application $application
    ): ApplicationResource {
        $this->authorize('view', $application);

        return new ApplicationResource($application);
    }

    public function update(
        ApplicationUpdateRequest $request,
        Application $application
    ): ApplicationResource {
        $this->authorize('update', $application);

        $validated = $request->validated();

        $application->update($validated);

        return new ApplicationResource($application);
    }

    public function destroy(
        Request $request,
        Application $application
    ): Response {
        $this->authorize('delete', $application);

        $application->delete();

        return response()->noContent();
    }
}
