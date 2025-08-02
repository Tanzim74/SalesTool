<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reports\ReportGenerationInterface;
use App\Services\ReportManager;

class ReportController extends Controller

{
    
    protected $reportManager;
    public function __construct( ReportManager $reportManager  ) {
       
    // $this->report = $report;
    $this->reportManager = $reportManager;
    }

    public function getReportInstance($reportType) {
        // Logic to get report instance based on type
        $reportInstance = $this->reportManager->getReportInstance($reportType);
        return $reportInstance;
    }

    public function getSales()
    {
       
        $reportInstance =  $this->getReportInstance(0); // Assuming 1 is the report type for sales
        
        $reportData = $reportInstance->generateSalesReport([]);


        return response()->json($reportData);
    }

    public function getReportCategory($reportType){

        // Logic to get report categories
        $categories = ['sales', 'customer'];
        return $categories[$reportType];
        
        
    }
    
}
