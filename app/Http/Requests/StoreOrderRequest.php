<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sender_name' => ['required', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'origin_city' => ['required', 'string', 'max:120'],
            'destination_city' => ['required', 'string', 'max:120'],
            'weight' => ['required', 'numeric', 'min:0.01', 'max:1000'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
