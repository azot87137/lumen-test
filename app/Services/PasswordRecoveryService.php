<?php

namespace App\Services;

use App\Models\PasswordReset;
use App\Repositories\PasswordRecoverRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordRecoveryService
{
    protected $service;
    protected $expirationTime;
    protected $repository;

    public function __construct(
        UserService $service,
        PasswordRecoverRepositoryInterface $repository,
        $expirationTime = 3600
    ) {
        $this->service = $service;
        $this->expirationTime = $expirationTime;
        $this->repository = $repository;
    }

    public function sendPasswordResetRequest(int|string $userId)
    {
        $model = new PasswordReset();
        $model->token = $this->generateToken();
        $model->user_id = $userId;

        $existingToken = $this->repository->findByUser($userId);

        if ($existingToken) {
            $this->repository->delete($existingToken);
        }

        $this->repository->save($model);

        return $model;
    }

    public function checkPasswordResetToken(string $token)
    {
        // token = 11 am
        // now = 11 30 am
        // 11 >= 11 30 - 1 h
        // 11 >= 10 30
        $expirationDateTime = Carbon::now()->subSeconds($this->expirationTime);

        return $this->repository->findByToken($token, $expirationDateTime);
    }

    public function changePasswordByToken(string $token, string $password)
    {
        $token = $this->repository->findByToken($token);

        $user = $this->service->getUserById($token->user_id);

        DB::transaction(function () use ($user, $token, $password) {
            $this->service->updatePassword($user, $password);

            $this->repository->delete($token);
        });
    }

    /**
     * @return string
     */
    protected function generateToken(): string
    {
        return hash('sha256', Str::random(100));
    }
}
