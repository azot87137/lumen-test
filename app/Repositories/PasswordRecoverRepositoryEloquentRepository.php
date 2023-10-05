<?php

namespace App\Repositories;

use App\Models\PasswordReset;

class PasswordRecoverRepositoryEloquentRepository implements PasswordRecoverRepositoryInterface
{
    /**
     * @param int|string $id
     * @return PasswordReset|null
     */
    public function findByUser(int|string $id): ?PasswordReset
    {
        return PasswordReset::where(['user_id' => $id])->first();
    }

    /**
     * @param string $token
     * @param $expirationTime
     * @return PasswordReset|null
     */
    public function findByToken(string $token, $expirationTime = null): ?PasswordReset
    {
        $query = PasswordReset::where(['token' => $token]);

        if ($expirationTime) {
            $query->where('created_at', '>', $expirationTime);
        }

        return $query->first();
    }

    /**
     * @param PasswordReset $reset
     * @return PasswordReset
     */
    public function save(PasswordReset $reset): PasswordReset
    {
        $reset->save();

        return $reset;
    }

    /**
     * @param PasswordReset $reset
     * @return void
     */
    public function delete(PasswordReset $reset): void
    {
        $reset->delete();
    }
}
