<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\AdminRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {   
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
    }

    public function boot()
    {
        //
    }
}
