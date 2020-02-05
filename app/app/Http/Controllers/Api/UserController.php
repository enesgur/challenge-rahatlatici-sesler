<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'email' => 'required|string|email',
            'pass' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->responseError(
                'Validation error',
                $validator->errors(),
                self::ERROR_CODE_VALIDATION,
                400);
        }

        // Authentication Attempt
        $attempt = Auth::guard('web')->attempt([
            'email' => $request->post('email'),
            'password' => $request->post('pass')
        ]);

        // Login control
        if ($attempt === false) {
            return $this->responseError(
                'The username or password is wrong',
                null,
                self::ERROR_CODE_VALIDATION,
                400);
        }

        // Token generate and save.
        $user = Auth::guard('web')->user();
        $user = User::find($user->id);
        $token = Str::random(80);
        $user->api_token = hash('sha256', $token);
        $user->save();

        return $this->responseSuccess([
            'authentication' => true,
            'token' => $token
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->api_token = null;
        $user->save();

        return $this->responseSuccess('logout successfully.');
    }
}
