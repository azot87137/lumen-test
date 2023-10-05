<?php

namespace App\Repositories;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function findByUser(string|int $userId);

    public function save(array $data): Company;
}
