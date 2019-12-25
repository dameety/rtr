<?php


namespace App\Actions;


use App\Order;

class CreateOrderAction
{
    public function call($data)
    {

        return Order::create([
            'cart' => json_encode($data['cart']),
            'user_id' => auth()->user()->id,
            'address' => $data['address'],
            'total_amount' => $data['total_amount']
        ]);


    }
}
