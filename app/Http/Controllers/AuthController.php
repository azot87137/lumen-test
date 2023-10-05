<?php

namespace App\Http\Controllers;

use App\Services\PasswordRecoveryService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var UserService
     */
    protected $service;
    /**
     * @var PasswordRecoveryService
     */
    protected $passwordRecoverService;

    /**
     * @param UserService $service
     * @param PasswordRecoveryService $passwordRecoverService
     */
    public function __construct(UserService $service, PasswordRecoveryService $passwordRecoverService)
    {
        $this->service = $service;
        $this->passwordRecoverService = $passwordRecoverService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $token = $this->service->generateUserApiToken($request->input('email'), $request->input('password'));

        if (!$token) {
            return $this->errorResponse('Wrong login or password.', 401);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:user',
            'password' => 'required'
        ]);

        $user = $this->service->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        return $this->successResponse($user, 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function recoverPasswordRequest(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users'
        ]);

        $user = $this->service->getUserByEmail($request->input('email'));

        $this->passwordRecoverService->sendPasswordResetRequest($user->id);

        return $this->successResponse(['message' => 'Token has been sent to your email.'], 202);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function recoverPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'newPassword' => 'required'
        ]);

        $token = $request->input('token');

        if ($this->passwordRecoverService->checkPasswordResetToken($token)) {
            $this->passwordRecoverService->changePasswordByToken($token, $request->input('newPassword'));

            return $this->successResponse(['message' => 'Password was successfully changed.']);
        }

        return $this->errorResponse('Wrong token', 422);
    }
}
