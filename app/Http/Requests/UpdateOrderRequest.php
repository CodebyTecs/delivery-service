<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sender_name' => ['sometimes', 'string', 'max:255'],
            'recipient_name' => ['sometimes', 'string', 'max:255'],
            'origin_city' => ['sometimes', 'string', 'max:120'],
            'destination_city' => ['sometimes', 'string', 'max:120'],
            'weight' => ['sometimes', 'numeric', 'min:0.01', 'max:1000'],
            'status' => ['sometimes', Rule::in(Order::STATUSES)],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
