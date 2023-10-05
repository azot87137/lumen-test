<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return \App\Models\User
     */
    public function create(array $data)
    {
        $data['password'] = $this->hashPassword($data['password']);
        $data['api_token'] = $this->generateApiToken();

        return $this->repository->save($data);
    }

    public function updatePassword(User $user, string $password)
    {
        $user->password = $this->hashPassword($password);
        $user->api_token = $this->generateApiToken();

        $this->repository->update($user);
    }

    public function getUserByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function getUserById(string|int $id)
    {
        return $this->repository->findById($id);
    }

    /**
     * @param string $email
     * @param string $password
     * @return false|string
     */
    public function generateUserApiToken(string $email, string $password)
    {
        $user = $this->repository->findByEmail($email);

        if (empty($user)) {
            return false;
        }

        if (!$this->checkPassword($password, $user->password)) {
            return false;
        }

        $token = $this->generateApiToken();

        $this->repository->updateApiToken($user->id, $token);

        return $token;
    }

    /**
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password)
    {
        return Hash::make($password);
    }

    /**
     * @param string $password
     * @param string $passwordHash
     * @return bool
     */
    public function checkPassword(string $password, string $passwordHash)
    {
        return Hash::check($password, $passwordHash);
    }

    /**
     * @return string
     */
    public function generateApiToken()
    {
        $generateRandomString = Str::random(60);

        return hash('sha256', $generateRandomString);
    }
}
