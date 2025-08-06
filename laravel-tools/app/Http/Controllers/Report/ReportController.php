<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reports\ReportGenerationInterface;
use App\Services\ReportManager;
use App\DataTables\ReportDataTable;



class ReportController extends Controller

{

    protected $reportManager;
    protected $datatable;
    public function __construct(ReportManager $reportManager, ReportDataTable $datatable)
    {

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

        $headers = ['ID', 'Date', 'Customer', 'Total', 'Status'];
        $columnKeys = ['id', 'date', 'customer_name', 'total_amount', 'payment_status'];
        $html = view('datatables.sales-datatable', compact('headers'))->render();

        return [
            'columnKeys' => $columnKeys,
            'html' => $html
        ];
    }

    public function viewSales()
    {
        return view('reports.sales.view-sales');
    }

    public function getSales()
    {
        $reportInstance =  $this->getReportInstance(0); // Assuming 1 is the report type for sales

        $reportData = $reportInstance->generateSalesReport();
        return $reportData;
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
