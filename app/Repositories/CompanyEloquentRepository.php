<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyEloquentRepository implements CompanyRepositoryInterface
{
    public function findByUser(string|int $userId)
    {
        return Company::where(['user_id' => $userId])->orderBy('id', 'DESC')->paginate();
    }

    public function save(array $data): Company
    {
        $model = new Company();
        $model->user_id = $data['user_id'];
        $model->title = $data['title'];
        $model->phone = $data['phone'];
        $model->description = $data['description'];

        $model->save();

        return $model;
    }
}
