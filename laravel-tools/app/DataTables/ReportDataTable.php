<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ReportDataTable
{

    public function initializeHeaders($request)
    {
        $reportType = $this->reportType(0);

        $columnKeys = [];
        $filter_type = $request->filter;
        if($filter_type == 'All') {
            $headers = config("report_headers.$reportType.all.columns");
            $columnKeys = config("report_columnkeys.$reportType.all.columnkeys");
            // dd($columnKeys);
           
        } elseif ($filter_type == 'weekly') {
            $headers = config("report_headers.$reportType.weekly.columns");
            $columnKeys = config("report_columnkeys.$reportType.weekly.columnkeys");
        } elseif ($filter_type == 'monthly') {
            $headers = config("report_headers.$reportType.monthly.columns");
            $columnKeys = config("report_columnkeys.$reportType.monthly.columnkeys");
        } elseif ($filter_type == 'yearly') {
            $headers = config("report_headers.$reportType.yearly.columns");
            $columnKeys = config("report_columnkeys.$reportType.yearly.columnkeys");
        } else {
            // Default case or error handling
            $headers = [];
            $columnKeys = [];
        }
        // $headers = config("report_headers.$reportType.weekly.columns");
        
        // $columnKeys = config("report_columnkeys.$reportType.weekly.columnkeys");
        
        $html = view('datatables.sales-datatable', compact('headers'))->render();

        return [
            'columnKeys' => $columnKeys,
            'html' => $html
        ];
        // return $this->dataTables->queryBuilder($query);
    }

    

   

    public function  initiateDataTableResponse($totalData,$query, $request)
    {
        
         return response([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $query,
        ]);
    }
    
    public function getSalesSummary($request){
        $length = $request->input('length') ?? 10; // 
        $start = $request->input('start') ?? 0; //$offset = ($page - 1) * $length==start
        // $totalData = DB::table('orders')->count();

        $query = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select('orders.id', 'orders.order_number','orders.subtotal', 'orders.payment_status', 'orders.created_at')
            ->groupBy('orders.order_number')
            ->offset($start)
            ->limit($length)
            ->get();

        return $this->initiateDataTableResponse($query->count(), $query, $request);
           
    }

    

    public function reportType($type){
        
        $getReportType = config("report.report-type.$type");
        
        return $getReportType; 
    }
}
