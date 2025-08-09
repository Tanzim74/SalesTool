<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ReportDataTable
{

    public function initializeHeaders()
    {
        $reportType = $this->reportType(0);
        
        
        $headers = config("report_headers.$reportType.weekly.columns");
        
        $columnKeys = config("report_columnkeys.$reportType.weekly.columnkeys");
        
        $html = view('datatables.sales-datatable', compact('headers'))->render();

        return [
            'columnKeys' => $columnKeys,
            'html' => $html
        ];
        // return $this->dataTables->queryBuilder($query);
    }

    

    public function loadDataset($request)
    {

        $length = $request->input('length');
        $start = $request->input('start');
       
        $data = [];
      
      
        $customers = ['Tanzim', 'Alex', 'Sarah', 'Michael', 'Jessica', 'David', 'Emily', 'Robert', 'Olivia', 'William'];
        $statuses = ['paid', 'pending', 'failed'];
        $products = ['Laptop', 'Phone', 'Tablet', 'Monitor', 'Keyboard', 'Mouse', 'Printer', 'Headphones'];

        $startDate = strtotime('2020-01-01');
        $endDate = strtotime('2023-12-31');

        for ($i = 1; $i <= 100000; $i++) {
            $randomDays = rand(0, $endDate - $startDate);
            $date = date('Y-m-d', $startDate + $randomDays);

            $data[] = [
                'id' => $i,
                'date' => $date,
                'customer_name' => $customers[array_rand($customers)] . ' ' . rand(1000, 9999),
                'total_amount' => 0, // Will calculate below
                'payment_status' => $statuses[array_rand($statuses)],

            ];

        }
        $sliced = array_slice($data, $start, $length);
        
        return response([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
            'data' => $sliced,
        ]);
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
}
