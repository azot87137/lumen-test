<?php

namespace App\Providers;

use App\Repositories\CompanyEloquentRepository;
use App\Repositories\UserEloquentRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, function () {
            return new UserEloquentRepository();
        });

        $this->app->bind(CompanyEloquentRepository::class, function () {
            return new CompanyEloquentRepository();
        });
    }
}
