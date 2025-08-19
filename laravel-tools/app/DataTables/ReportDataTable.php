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
              // return $this->dataTables->queryBuilder($query);
        return $data=[
            'columnKeys' => $columnKeys,
            'html' => $html,

        ];
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
    
   

    
    public function reportType($type){
        
        $getReportType = config("report.report-type.$type");
        
        return $getReportType; 
    }

    public function getWeeklySearch($request){

        $total = DB::table('orders')->count();

            $query = DB::table('orders')
                ->selectRaw("
        
                YEARWEEK(created_at,0) as week_number,
                MIN(DATE(created_at)) as from_date,
                MAX(DATE(created_at)) as to_date,
                SUM(amount) as total_sales
            ")
                ->whereBetween('created_at', [
                    $request->input('start_date'),
                    $request->input('end_date')
                ])

                ->groupByRaw("YEARWEEK(created_at, 0)")
                ->whereRaw("DATE_FORMAT(created_at, '%M %Y') LIKE ?", ['%' . $request->input('search')['value'] . '%'])
                ->get();

            return response([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $total,
                'recordsFiltered' => $query->count(),
                'data' => $query,
            ]);
    }

    public function getMonthlySearch($request){

          $total = DB::table('orders')->count();

            $query = DB::table('orders')
                ->selectRaw("
        
                DATE_FORMAT(created_at, '%M %Y') as month_name,
                MIN(DATE(created_at)) as from_date,
                MAX(DATE(created_at)) as to_date,
                SUM(amount) as total_sales
            ")
                ->whereBetween('created_at', [
                    $request->input('start_date'),
                    $request->input('end_date')
                ])

                ->groupByRaw("DATE_FORMAT(created_at, '%M %Y')")
                ->whereRaw("DATE_FORMAT(created_at, '%M %Y') LIKE ?", ['%' . $request->input('search')['value'] . '%'])
                ->get();

            return response([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $total,
                'recordsFiltered' => $query->count(),
                'data' => $query,
            ]);
    }
}
