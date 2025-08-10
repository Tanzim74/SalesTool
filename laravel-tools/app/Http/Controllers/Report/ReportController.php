<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reports\ReportGenerationInterface;
use App\Services\ReportManager;
use App\DataTables\ReportDataTable;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller

{

    protected $reportManager;
    protected $datatable;
    protected $request;
    public function __construct(ReportManager $reportManager, ReportDataTable $datatable, Request $request)
    {
        $this->request = $request;
        $this->datatable = $datatable;
        $this->reportManager = $reportManager;
    }

   

    public function getReportInstance($reportType)
    {

        // Logic to get report instance based on type
        $reportInstance = $this->reportManager->getReportInstance($reportType);
        return $reportInstance;
    }

    public function getColumns()
    {
        

        
     

        return $this->datatable->initializeHeaders();
    }

    public function viewSales()
    {
        return view('reports.sales.view-sales');
    }

    public function getSales(Request $request)

    {
        // dd($request->input('search'));
      

        $reportInstance =  $this->getReportInstance(0); // Assuming 0 is the report type for sales
        
        $reportData = $reportInstance->generateSalesReport( $request);
        


        return $reportData;
        // return $reportData;
        // return response()->json($reportData);

    }

    public function salesByDate(Request $request)
    {
        $reportInstance =  $this->getReportInstance(0); // Assuming 1 is the report type for sales

        $reportData = $reportInstance->getSalesReportByDate([]);
        return response()->json($reportData);
    }

    public function getSalesSummary()
    {

        $reportInstance =  $this->getReportInstance(0); // Assuming 5 is the report type for summary

        $reportData = $reportInstance->performanceSummary(5);

        return response()->json($reportData);
    }

    public function getReportCategory($reportType)
    {

        // Logic to get report categories
        $categories = ['sales', 'customer'];
        return $categories[$reportType];
    }
}
