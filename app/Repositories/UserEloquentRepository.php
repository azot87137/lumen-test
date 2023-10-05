<?php

namespace App\Repositories;

use App\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function save(array $data): User
    {
        $model = new User();
        $model->first_name = $data['first_name'];
        $model->last_name = $data['last_name'];
        $model->email = $data['email'];
        $model->password = $data['password'];
        $model->api_token = $data['api_token'];

        $model->save();

        return $model;
    }

    public function findByEmail(string $email): User
    {
        return User::where(['email' => $email])->first();
    }

    public function findByToken(string $token): User
    {
        return User::where(['api_token' => $token])->first();
    }

    public function update(User $user): void
    {
        $user->save();
    }

    public function findById(int $id): User
    {
        return User::where(['id' => $id])->first();
    }

    public function updateApiToken(string|int $id, string $key): bool
    {
        $user = User::where(['id' => $id])->first();

        if (!$user) {
            return false;
        }

        $user->api_token = $key;
        $user->save();

        return true;
    }
}
