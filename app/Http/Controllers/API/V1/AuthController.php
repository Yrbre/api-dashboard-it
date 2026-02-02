<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(AuthenticateUserRequest $request)
    {
        $credential = $request->validated();

        $user = User::where('email', $credential['email'])->first();

        if (!$user || !Hash::check($credential['password'], $user->password)) {
            return ApiResponse::error(
                'Invalid credentials',
                Response::HTTP_UNAUTHORIZED
            );
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success(
            [

                'token' => $token,
                'user'  => new UserResource($user),
            ],
            'Login successful'
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success(
            null,
            'Logout successfully'
        );
    }

    public function me(Request $request)
    {
        return ApiResponse::success(
            new UserResource($request->user()),
            'User Data'
        );
    }
}
