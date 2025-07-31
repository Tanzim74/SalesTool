<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Reports\ReportGenerationInterface;
use App\Services\SalesReportService;
class ReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(ReportGenerationInterface::class,function(){
            $driver  = config('report.report-type');
            $class = config('report.driver.$driver',  SalesReportService::class);
            return $this->app->make($class);
        });
        //
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
