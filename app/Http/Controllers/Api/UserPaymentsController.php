<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentCollection;

class UserPaymentsController extends Controller
{
    public function index(Request $request, User $user): PaymentCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $payments = $user
            ->payments()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentCollection($payments);
    }

    public function store(Request $request, User $user): PaymentResource
    {
        $this->authorize('create', Payment::class);

        $validated = $request->validate([
            'amount' => ['nullable', 'numeric'],
            'qr_picture' => ['required', 'max:255', 'string'],
            'status' => ['required', 'in:paid,unpaid'],
        ]);

        $payment = $user->payments()->create($validated);

        return new PaymentResource($payment);
    }
}
