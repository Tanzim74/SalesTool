<?php
return[
    'report-type' => [
        0 => 'sales',
        1 => 'customer',
        5 => 'summary',
    ],

    'drivers' => [
    'sales' => App\Services\SalesReportService::class,
    'summary' => App\Actions\SalesSummary\SalesSummary::class,
    ],
];

// config("report.report-type.$reportType");
// config('report')['report-type'][$reportType];