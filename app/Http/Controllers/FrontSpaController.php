<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class FrontSpaController extends Controller
{
    public function __invoke()
    {
        $options = [
            'user_roles' => UserRole::toArray(),
            'order_statuses' => OrderStatus::toArray()
        ];

        return view('front.spa', [
            'options' => $options
        ]);
    }
}
