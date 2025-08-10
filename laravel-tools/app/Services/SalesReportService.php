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
        if ($request->input('search')['value']) {
            $length = $request->input('length', 10);  // default 10 per page
            $start = $request->input('start', 0);
            $totalData = DB::table('orders')->count();
            $filteredQuery = Order::search($request->input('search')['value']);

            $page = intval($start / $length) + 1;
            $results = $filteredQuery->paginate($length, 'page', $page);
            $resultsWithActions = collect($results->items())->map(function ($row) {
            $row->actions = 
            '
            <a href="/orders/' . $row->id . '/edit" class="btn btn-sm btn-primary">Edit</a>
            <a href="/orders/' . $row->id . '/delete" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
           ';
           return $row;
            });
           return response([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $results->total(), // total filtered records
                'data' => $results->items(),
            ]);
            //    return $this->reportTable->initiateDataTableResponse($totalData,$query,$request);

        }


        $length = $request->input('length') ?? 10; // 
        $start = $request->input('start') ?? 0; //$offset = ($page - 1) * $length==start
        $totalData = DB::table('orders')->count();
        $query = DB::table('orders')
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($row) {
                $row->actions = '
                <a href="/orders/' . $row->id . '/edit" class="btn btn-sm btn-primary">Edit</a>
                <a href="/orders/' . $row->id . '/delete" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
            ';
                return $row;
            });

        // dd(count($query));

        // $filtered_query = array_slice($query, $start, $length);
        // ->map(fn($row) => (array) $row)
        // ->toArray();

        return $this->reportTable->initiateDataTableResponse($totalData, $query, $request);
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
