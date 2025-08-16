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

        foreach ($period as $key => $weekstart) {
            $week_end = $weekstart->copy()->addDays(6);
            $total_amount =  DB::table('orders')
                ->whereBetween('created_at', [$weekstart, $week_end])
                ->sum('amount');
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
    public function getMonthlySalesReport()
    {
        if ($this->request->input('search')['value']) {
            $total = DB::table('orders')->count();

            $query = DB::table('orders')
                ->selectRaw("
        
                DATE_FORMAT(created_at, '%M %Y') as month_name,
                MIN(DATE(created_at)) as from_date,
                MAX(DATE(created_at)) as to_date,
                SUM(amount) as total_sales
            ")
                ->whereBetween('created_at', [
                    $this->request->input('start_date'),
                    $this->request->input('end_date')
                ])
                
                ->groupByRaw("DATE_FORMAT(created_at, '%M %Y')")
                ->whereRaw("DATE_FORMAT(created_at, '%M %Y') LIKE ?", ['%' . $this->request->input('search')['value'] . '%'])
                ->get();

            return response([
                'draw' => intval($this->request->input('draw')),
                'recordsTotal' => $total,
                'recordsFiltered' => $query->count(),
                'data' => $query,
            ]);
        }
        $start_date = $this->request->input('start_date');
        $end_date = $this->request->input('end_date');

        $period = CarbonPeriod::create($start_date, '1 month', $end_date);

        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $monthlySales = [];

        foreach ($period as $key => $monthstart) {
            $month_end = $monthstart->copy()->addDays(29);
            $total_amount =  DB::table('orders')
                ->whereBetween('created_at', [$monthstart, $month_end])
                ->sum('amount');
            $monthlySales[] = [
                'month_name' => $monthstart->format('F Y'),
                'from_date' => $monthstart->format('Y-m-d'),
                'to_date' => $month_end->format('Y-m-d'),
                'total_sales' => $total_amount,
            ];
        }

        // $monthlySales = DB::table('orders') for premium
        // ->selectRaw("
        //     DATE_FORMAT(created_at, '%Y-%m') as month,
        //     MIN(DATE(created_at)) as from_date,
        //     MAX(DATE(created_at)) as to_date,
        //     SUM(amount) as total_sales
        // ")
        // ->whereBetween('created_at', [$start_date, $end_date])
        // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
        // ->orderBy('month', 'asc')
        // ->get();

        $paginated_months = array_slice($monthlySales, $start, $length);
        return $this->reportTable->initiateDataTableResponse(count($monthlySales), $paginated_months, $this->request);
    }

    public function filterType()
    {

        $filter_type = $this->request->input('filter');
        if ($filter_type == 'All') {
            return 'all';
        } elseif ($filter_type == 'weekly') {

            return $this->getWeeklySalesReport();
        } elseif ($filter_type == 'monthly') {
            return $this->getMonthlySalesReport();
        } elseif ($filter_type == 'yearly') {
            return 'yearly';
        } else {
            // Default case or error handling
            return null;
        }
    }





    public function performanceSummary($reportType)
    {

        $totalSales = $this->reportManager->getReportInstance($reportType)->totalSales();

        return $totalSales; // Example logic, replace with actual summary logic   


    }
}
