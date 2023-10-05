<?php

namespace App\Providers;

use App\Repositories\CompanyEloquentRepository;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\PasswordRecoverRepositoryEloquentRepository;
use App\Repositories\PasswordRecoverRepositoryInterface;
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

        $this->app->bind(CompanyRepositoryInterface::class, function () {
            return new CompanyEloquentRepository();
        });

        $this->app->bind(PasswordRecoverRepositoryInterface::class, function () {
            return new PasswordRecoverRepositoryEloquentRepository();
        });
    }
}
