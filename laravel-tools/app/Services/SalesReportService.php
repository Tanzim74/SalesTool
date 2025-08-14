<?php

namespace App\Services;

use App\Reports\ReportGenerationInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
// use App\Actions\SalesSummary\SalesSummary;

use App\DataTables\ReportDataTable;
use App\Services\ReportManager;
use Illuminate\Http\Request;

use App\Models\Order;

class SalesReportService
{

    protected $request;
    protected $reportTable;
    protected $reportManager;
    public function __construct(ReportManager $reportManager, ReportDataTable $reportTable, Request $request)
    {
        // $this->report = $report;
        $this->reportManager = $reportManager;
        $this->reportTable = $reportTable;
        $this->request = $request;
    }
    public function generateSalesReport(Request $request)
    {
        
       return  $this->reportTable->getSalesSummary($this->request);

    }


    public function getMonthlySalesReport(array $filters): array
    {
        // Logic to generate monthly sales report based on filters
        return []; // Example logic, replace with actual filtering logic
    }

    public function getSalesReportByDate(array $filters): array
    {
        $this->reportTable->getSalesSummary();
        

         // Example logic, replace with actual filtering logic
    }

    public function performanceSummary($reportType)
    {

        $totalSales = $this->reportManager->getReportInstance($reportType)->totalSales();

        return $totalSales; // Example logic, replace with actual summary logic   


    }
}
