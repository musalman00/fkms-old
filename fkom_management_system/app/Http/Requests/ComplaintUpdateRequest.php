<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintUpdateRequest extends FormRequest
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
            'kiosk_participant_id' => [
                'required',
                'exists:kiosk_participants,id',
            ],
            'title' => ['required', 'max:255', 'string'],
            'category' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'attachment' => ['required', 'max:255', 'string'],
            'technician_assign' => ['required', 'max:255', 'string'],
            'reply' => ['required', 'max:255', 'string'],
            'status' => ['required', 'in:pending,done'],
        ];
    }
}
