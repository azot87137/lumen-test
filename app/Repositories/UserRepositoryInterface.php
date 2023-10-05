<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function save(array $data): User;

    public function update(User $user): void;

    public function findByEmail(string $email): User;

    public function findByToken(string $token): User;

    public function findById(int $id): User;

    public function updateApiToken(string|int $id, string $key): bool;
}
