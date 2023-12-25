<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Payment::class);

        $search = $request->get('search', '');

        $payments = Payment::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.payments.index', compact('payments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Payment::class);

        $users = User::pluck('name', 'id');

        return view('app.payments.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Payment::class);

        $validated = $request->validated();
        if ($request->hasFile('qr_picture')) {
            $validated['qr_picture'] = $request
                ->file('qr_picture')
                ->store('public');
        }

        $payment = Payment::create($validated);

        return redirect()
            ->route('payments.edit', $payment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Payment $payment): View
    {
        $this->authorize('view', $payment);

        return view('app.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Payment $payment): View
    {
        $this->authorize('update', $payment);

        $users = User::pluck('name', 'id');

        return view('app.payments.edit', compact('payment', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PaymentUpdateRequest $request,
        Payment $payment
    ): RedirectResponse {
        $this->authorize('update', $payment);

        $validated = $request->validated();
        if ($request->hasFile('qr_picture')) {
            if ($payment->qr_picture) {
                Storage::delete($payment->qr_picture);
            }

            $validated['qr_picture'] = $request
                ->file('qr_picture')
                ->store('public');
        }

        $payment->update($validated);

        return redirect()
            ->route('payments.edit', $payment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Payment $payment
    ): RedirectResponse {
        $this->authorize('delete', $payment);

        if ($payment->qr_picture) {
            Storage::delete($payment->qr_picture);
        }

        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
