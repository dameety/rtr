<?php

namespace App\Actions;

use App\Enums\OrderStatus;
use Illuminate\Support\Carbon;

class UpdateOrderAction
{
    public function call($requestData, $order)
    {
        $order->status = $requestData['status'];
        $order->driver_id = $requestData['driver_id'];
        $order->delivered_at = null;

        if($requestData['status'] === OrderStatus::DELIVERED) {
            $order->delivered_at = Carbon::now();
        }

        $order->save();
        $order = $order->refresh();

        $order['customer'] = $order->customer;
        $order['driver'] = $order->driver;

        return $order;
    }
}
