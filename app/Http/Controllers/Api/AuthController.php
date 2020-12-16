<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'user' => $user,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ];
            return response($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param AuthRequest $request
     * @return ResponseFactory|Response
     */
    public function login(AuthRequest $request)
    {
        $user = User::query()->whereEmail($request->email)->first();
        $status = 200;
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Personal')->accessToken;
                $response = [
                    'token' => $token,
                    'user' => $user,
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name'),
                ];
            } else {
                $response = [
                    'message' => 'The given data was invalid.',
                    'errors' => ['password' => ['Password missmatch']]
                ];
                $status = 422;
            }
        } else {
            $response = [
                'message' => 'The given data was invalid.',
                'errors' => ['email' => ['User does not exist']]
            ];
            $status = 422;
        }
        return response($response, $status);
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return response()->json([
            'user' => request()->user(),
            'roles' => request()->user()->getRoleNames(),
            'permissions' => request()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been succesfully logged out!'];
        return response($response, 200);
    }
}
