<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSpaController extends Controller
{
    public function index()
    {
        $options = [
            'user_roles' => UserRole::toArray(),
            'order_statuses' => OrderStatus::toArray()
        ];

        return view('admin', [
            'options' => $options
        ]);
    }
}
