<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionStoreRequest extends FormRequest
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
            'picture' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'publish_time' => ['required', 'date'],
            'promotion_ends' => ['required', 'date'],
            'status' => ['required', 'in:approve,reject'],
        ];
    }
}
