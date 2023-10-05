<?php

namespace App\Services;

use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordRecoveryService
{
    protected $service;
    protected $expirationTime;

    public function __construct(UserService $service, $expirationTime = 3600)
    {
        $this->service = $service;
        $this->expirationTime = $expirationTime;
    }

    public function sendPasswordResetRequest(int|string $userId)
    {
        $model = new PasswordReset();
        $model->token = $this->generateToken();
        $model->user_id = $userId;

        $model->save();

        return $model;
    }

    public function checkPasswordResetToken(string $token)
    {
        return PasswordReset::where(['token' => $token])
            ->where('created_at', '>=', Carbon::now()->subSeconds($this->expirationTime))
            ->first();
    }

    public function changePasswordByToken(string $token, string $password)
    {
        $token = PasswordReset::where(['token' => $token])->first();

        $user = $this->service->getUserById($token->user_id);

        DB::transaction(function () use ($user, $token, $password) {
            $this->service->updatePassword($user, $password);

            $token->delete();
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
