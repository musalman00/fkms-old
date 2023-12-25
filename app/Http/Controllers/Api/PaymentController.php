<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentCollection;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;

class PaymentController extends Controller
{
    public function index(Request $request): PaymentCollection
    {
        $this->authorize('view-any', Payment::class);

        $search = $request->get('search', '');

        $payments = Payment::search($search)
            ->latest()
            ->paginate();

        return new PaymentCollection($payments);
    }

    public function store(PaymentStoreRequest $request): PaymentResource
    {
        $this->authorize('create', Payment::class);

        $validated = $request->validated();

        $payment = Payment::create($validated);

        return new PaymentResource($payment);
    }

    public function show(Request $request, Payment $payment): PaymentResource
    {
        $this->authorize('view', $payment);

        return new PaymentResource($payment);
    }

    public function update(
        PaymentUpdateRequest $request,
        Payment $payment
    ): PaymentResource {
        $this->authorize('update', $payment);

        $validated = $request->validated();

        $payment->update($validated);

        return new PaymentResource($payment);
    }

    public function destroy(Request $request, Payment $payment): Response
    {
        $this->authorize('delete', $payment);

        $payment->delete();

        return response()->noContent();
    }
}
