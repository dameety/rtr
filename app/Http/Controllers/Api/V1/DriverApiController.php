<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class DriverApiController extends Controller
{
    public function index()
    {
        $users = User::where('role', UserRole::DRIVER)->get();

        $data = [
            'drivers' => UserResource::collection($users),
        ];

        return $this->sendResponse($data, 'Successfully retrieved drivers');

    }
}
