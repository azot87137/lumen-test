<?php

namespace App\Services;

use App\Repositories\CompanyRepositoryInterface;

class CompanyService
{
    /**
     * @var CompanyRepositoryInterface
     */
    protected $repository;

    /**
     * @param CompanyRepositoryInterface $repository
     */
    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @return \App\Models\Company
     */
    public function create($data)
    {
        return $this->repository->save($data);
    }

    /**
     * @param string|int $userId
     * @return mixed
     */
    public function getUserCompanies(string|int $userId)
    {
        return $this->repository->findByUser($userId);
    }
}
