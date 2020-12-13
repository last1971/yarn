<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $service)
    {
        $this->authService = $service;
    }

    /**
     * @param AuthRequest $request
     * @return ResponseFactory|Response
     * @throws Exception
     */
    public function register(AuthRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->authService->register($request->validated());
            $token = $user->createToken('Personal')->accessToken;
            DB::commit();
            $response = [
                'token' => $token,
                'user' => $user->only(['name', 'email']),
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ];
            return response($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
