<?php
namespace App\Services;

class ReportManager {

    public function getReportInstance($reportType) {

        
        $driver = config("report.report-type.$reportType", 'SALES');
        $class = config("report.drivers.$driver", SalesReportService::class);
        
        return app()->make($class);


    }
}
