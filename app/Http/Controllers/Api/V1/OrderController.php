<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CreateOrderAction;
use App\Actions\UpdateOrderAction;
use App\Order;
use App\Http\Resources\OrderCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderCreateRequest;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::forUser($request->user());

        return $this->sendResponse([
            'orders' => new OrderCollection($orders)
        ], 'Orders retrieved successfully.');
    }

    public function store(OrderCreateRequest $request, CreateOrderAction $createOrderAction)
    {
        $order = $createOrderAction->call($request->all());

        return $this->sendResponse([
            'order' => new OrderResource($order->refresh())
        ], 'Order successfully created');
    }

    public function show(Order $order)
    {
         $order['customer'] = $order->customer;
         $order['driver'] = $order->driver;

        return $this->sendResponse([
            'order' => new OrderResource($order)
        ], 'Order retrieved successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return $this->sendResponse([], 'Order successfully deleted.');
    }

    public function update(Request $request, Order $order, UpdateOrderAction $updateOrderAction)
    {
        $order = $updateOrderAction->call($request->all(), $order);

        return $this->sendResponse([
            'order' => new OrderResource($order->refresh())
        ], 'Order successfully updated');
    }
}
