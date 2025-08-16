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
use Carbon\CarbonPeriod;
use Carbon\Carbon;
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

    public function getWeeklySalesReport()
    {
        $start_date = $this->request->input('start_date');
        $end_date = $this->request->input('end_date');
        
        $period = CarbonPeriod::create($start_date, '1 week', $end_date);
    
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $weeklySales = [];

        foreach ($period as $key => $weekstart){
            $week_end = $weekstart->copy()->addDays(6);
           $total_amount =  DB::table('orders')
                ->whereBetween('created_at', [$weekstart, $week_end])
                ->sum('total');
            $weeklySales[] = [
                'week_number' => $key + 1,
                'from' => $weekstart->format('Y-m-d'),
                'to' => $week_end->format('Y-m-d'),
                'total_sales' => $total_amount,
            ];

        }
      
        $paginated_weeks = array_slice($weeklySales, $start, $length); 
       return $this->reportTable->initiateDataTableResponse(count($weeklySales), $paginated_weeks, $this->request);
        // Example pagination, adjust as needed
    }

    public function filterType (){

        $filter_type = $this->request->input('filter');
        if ($filter_type == 'All') {
            return 'all';
        } elseif ($filter_type == 'weekly') {

           return $this->getWeeklySalesReport();

        } elseif ($filter_type == 'monthly') {
            return 'monthly';
        } elseif ($filter_type == 'yearly') {
            return 'yearly';
        } else {
            // Default case or error handling
            return null;
        }
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
