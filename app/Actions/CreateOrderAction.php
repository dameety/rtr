<?php

namespace App\Actions;

use App\Meal;
use App\Order;

class CreateOrderAction
{
    public function call($data)
    {
        $order = Order::create([
            'cart' => json_encode($data['cart']),
            'user_id' => auth()->user()->id,
            'address' => $data['address'],
            'total_amount' => $data['total_amount']
        ]);

        $this->reduceMealUnits($data['cart']);

        return $order;
    }

    private function reduceMealUnits($cart)
    {
        collect($cart)->each(function ($item, $key) {
            $meal= Meal::findOrFail($item['meal_id']);

            $meal->reduceUnits();
        });
    }
}
