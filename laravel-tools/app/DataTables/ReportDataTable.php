<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ReportDataTable
{



    public function initializeHeaders()
    {
        $headers = ['ID', 'Date', 'Customer', 'Total', 'Status'];
        $columnKeys = ['id', 'date', 'customer_name', 'total_amount', 'payment_status'];
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
        // dd($length , $start);

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
}
