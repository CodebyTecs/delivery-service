<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = $request->user()
            ->orders()
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['price'] = Order::calculatePrice((float) $data['weight']);
        $data['status'] = Order::STATUS_CREATED;

        $order = $request->user()->orders()->create($data);

        return response()->json([
            'data' => $order,
        ], 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $order = $this->findUserOrder($request, $id);

        return response()->json([
            'data' => $order,
        ]);
    }

    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        $order = $this->findUserOrder($request, $id);
        $data = $request->validated();

        if (array_key_exists('weight', $data)) {
            $data['price'] = Order::calculatePrice((float) $data['weight']);
        }

        $order->update($data);

        return response()->json([
            'data' => $order->refresh(),
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $order = $this->findUserOrder($request, $id);
        $order->delete();

        return response()->json(null, 204);
    }

    public function track(int $id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);

        return response()->json([
            'order_id' => $order->id,
            'status' => $order->status,
            'updated_at' => $order->updated_at,
        ]);
    }

    private function findUserOrder(Request $request, int $id): Order
    {
        return $request->user()
            ->orders()
            ->whereKey($id)
            ->firstOrFail();
    }
}
