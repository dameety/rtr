<?php

namespace App\Http\Controllers\Api\V1;

use App\Order;
use App\Http\Resources\OrderCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
    public function index(Request $request)
    {
        $deliveries = Order::deliveries($request->user());

        return $this->sendResponse([
            'deliveries' => new OrderCollection($deliveries)
        ], 'Deliveries retrieved successfully.');
    }
}
