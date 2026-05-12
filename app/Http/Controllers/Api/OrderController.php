<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['price'] = Order::calculatePrice((float) $data['weight']);
        $data['status'] = Order::STATUS_CREATED;

        $order = Order::query()->create($data);

        return response()->json([
            'data' => $order,
        ], 201);
    }
}
