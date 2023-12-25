<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kiosk_id' => ['required', 'exists:kiosks,id'],
            'user_id' => ['required', 'exists:users,id'],
            'payment_id' => ['required', 'exists:payments,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'operating_day' => ['required', 'max:255', 'string'],
            'operating_hour' => ['required', 'max:255', 'string'],
            'business_type' => ['required', 'max:255', 'string'],
            'status' => ['required', 'in:approved,rejected,pending'],
            'reason_reject' => ['required', 'max:255', 'string'],
        ];
    }
}
