<?php

namespace App\Services;

use App\Reports\ReportGenerationInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
// use App\Actions\SalesSummary\SalesSummary;
use Yajra\DataTables\DataTables;
use App\DataTables\ReportDataTable;
use App\Services\ReportManager;

class SalesReportService
{
    protected $reportTable;
    protected $reportManager;
    public function __construct(ReportManager $reportManager, ReportDataTable $reportTable)
    {

        // $this->report = $report;
        $this->reportManager = $reportManager;
        $this->reportTable = $reportTable;
    }
    public function generateSalesReport()
    
    {
    $data = [];
    $customers = ['Tanzim', 'Alex', 'Sarah', 'Michael', 'Jessica', 'David', 'Emily', 'Robert', 'Olivia', 'William'];
    $statuses = ['paid', 'pending', 'failed'];
    $products = ['Laptop', 'Phone', 'Tablet', 'Monitor', 'Keyboard', 'Mouse', 'Printer', 'Headphones'];
    
    $startDate = strtotime('2020-01-01');
    $endDate = strtotime('2023-12-31');
    
    for ($i = 1; $i <= 50000 ;$i++) {
        $randomDays = rand(0, $endDate - $startDate);
        $date = date('Y-m-d', $startDate + $randomDays);
        
        $data[] = [
            'id' => $i,
            'date' => $date,
            'customer_name' => $customers[array_rand($customers)] . ' ' . rand(1000, 9999),
            'total_amount' => 0, // Will calculate below
            'payment_status' => $statuses[array_rand($statuses)],

        ];

        $query = $data;
     
    }
    return DataTables::of(collect($query))->make(true);
}


    public function getMonthlySalesReport(array $filters): array
    {
        // Logic to generate monthly sales report based on filters
        return []; // Example logic, replace with actual filtering logic
    }

    public function getSalesReportByDate(array $filters): array
    {
        // Logic to generate sales report by date based on filter
        $salesReportByDate = DB::table('orders')
            ->select('orders.order_number', DB::raw('SUM(order_items.unit_price * order_items.quantity) as total_sales'))
            ->leftjoin('order_items', 'orders.id', '=', 'order_items.order_id') // Placeholder return, replace with actual logic
            ->where('orders.status', 'delivered')
            ->where('orders.created_at', '>=', $filters['start_date'])
            ->where('orders.created_at', '<=', $filters['end_date'])
            ->groupBy('orders.order_number')
            ->get()
            ->toArray();

        return $salesReportByDate; // Example logic, replace with actual filtering logic
    }

    public function performanceSummary($reportType)
    {

        $totalSales = $this->reportManager->getReportInstance($reportType)->totalSales();

        return $totalSales; // Example logic, replace with actual summary logic   


    }
}
