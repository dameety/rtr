<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    use ThrottlesLogins;

    protected $maxAttempts = 5;
    protected $decayMinutes = 30;

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login (Request $request)
    {
        $this->validate($request,['email' => 'required|email','password'=> 'required']);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (! auth()->attempt( $request->only(['email','password']) )) {
            $this->incrementLoginAttempts($request);
            return $this->sendError([], 'Invalid account credentials', 401);
        }

        $user = auth()->user();

        return $this->sendResponse([
            'user' => new UserResource($user),
            'access_token' => $user->createToken(env('APP_NAME'))->accessToken
        ], 'Successfully logged in to your account');
    }

    public function logout ()
    {
        auth()->logout();

        return $this->sendResponse([], 'Successfully logged out of your account');
    }


    public function register (UserRegistrationRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return $this->sendResponse([
            'user' => new UserResource($user),
            'access_token' => $user->createToken(env('APP_NAME'))->accessToken
        ], 'Account registration successful.');
    }

}
