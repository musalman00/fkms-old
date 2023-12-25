<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kiosk;
use App\Models\Payment;
use Illuminate\View\View;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Requests\ApplicationUpdateRequest;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Application::class);

        $search = $request->get('search', '');

        $applications = Application::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.applications.index',
            compact('applications', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Application::class);

        $kiosks = Kiosk::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $payments = Payment::pluck('qr_picture', 'id');

        return view(
            'app.applications.create',
            compact('kiosks', 'users', 'payments')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Application::class);

        $validated = $request->validated();

        $application = Application::create($validated);

        return redirect()
            ->route('applications.edit', $application)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Application $application): View
    {
        $this->authorize('view', $application);

        return view('app.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Application $application): View
    {
        $this->authorize('update', $application);

        $kiosks = Kiosk::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $payments = Payment::pluck('qr_picture', 'id');

        return view(
            'app.applications.edit',
            compact('application', 'kiosks', 'users', 'payments')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ApplicationUpdateRequest $request,
        Application $application
    ): RedirectResponse {
        $this->authorize('update', $application);

        $validated = $request->validated();

        $application->update($validated);

        return redirect()
            ->route('applications.edit', $application)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Application $application
    ): RedirectResponse {
        $this->authorize('delete', $application);

        $application->delete();

        return redirect()
            ->route('applications.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
