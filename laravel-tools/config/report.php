<?php
return[
    'report-type' => [
        0 => 'sales',
        1 => 'customer',
    ],

    'drivers' => [
    'sales' => App\Services\SalesReportService::class,
    ],
];

// config("report.report-type.$reportType");
// config('report')['report-type'][$reportType];