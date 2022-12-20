<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(AuthLoginRequest $request): JsonResponse
    {
        $auth = $this->authService->login($request->email);

        return response()->json($auth, 200);
    }

    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $auth = $this->authService->register($request->all());

        return response()->json($auth, 200);
    }

    public function auth(Request $request): JsonResponse
    {
        return response()->json($request->user(), 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }
}
