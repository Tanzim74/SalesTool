<?php
namespace App\Services;
use App\Reports\ReportGenerationInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
// use App\Actions\SalesSummary\SalesSummary;
use App\Services\ReportManager;
class SalesReportService implements ReportGenerationInterface
{
    
    protected $reportManager;
     public function __construct(  ReportManager $reportManager  ) {
       
    // $this->report = $report;
    $this->reportManager = $reportManager;
    }
    public function generateSalesReport(array $filters): array
    {
        // Logic to generate sales report based on filters
        return Product::all()->toArray(); // Example logic, replace with actual filtering logic
        
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
                            ->leftjoin('order_items' , 'orders.id' , '=' , 'order_items.order_id') // Placeholder return, replace with actual logic
                            ->where('orders.status','delivered')
                            ->where('orders.created_at', '>=', $filters['start_date'])
                            ->where('orders.created_at', '<=', $filters['end_date'])
                            ->groupBy('orders.order_number')
                            ->get()
                            ->toArray();

        return $salesReportByDate; // Example logic, replace with actual filtering logic
    }

    public function performanceSummary($reportType){

     $totalSales = $this->reportManager->getReportInstance($reportType)->totalSales();
     
     return $totalSales; // Example logic, replace with actual summary logic   
        

    }



    
}