<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KioskParticipantUpdateRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'kiosk_id' => ['required', 'exists:kiosks,id'],
        ];
    }
}
