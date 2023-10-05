<?php

namespace App\Repositories;

use App\Models\PasswordReset;
use Mockery\Generator\StringManipulation\Pass\Pass;

interface PasswordRecoverRepositoryInterface
{
    public function findByUser(string|int $id): ?PasswordReset;

    public function findByToken(string $token, $expirationTime = null): ?PasswordReset;

    public function save(PasswordReset $reset): PasswordReset;

    public function delete(PasswordReset $reset): void;
}
