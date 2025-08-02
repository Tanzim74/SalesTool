<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ReportManager;

class ReportManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReportManager::class,function($app){
            return new ReportManager();
        } );
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
