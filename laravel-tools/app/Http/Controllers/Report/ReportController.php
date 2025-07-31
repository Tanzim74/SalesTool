<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reports\ReportGenerationInterface;

class ReportController extends Controller

{
    protected $report;
    public function __construct(ReportGenerationInterface $report) {
    $this->report = $report;
    }

    public function getSales(){
        
        $reportData = $this->report->generateSalesReport([]);

        return response()->json($reportData);
    }
    
}
