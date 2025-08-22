<?php
namespace App\Actions\Validations;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class ValidationService
{
    public function validateSalesRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => $validator,
                'type' => 'date_validation'
            ];
        }



    }

    public function checkWeeklySalesRequest($request)
    {

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        if ($startDate->diffInDays($endDate) < 7) {
            return response()->json([
                'status' => 422,
                'data' => 'The date range has to be at least 7 days',
                'type' => 'week_validation'
            ]);
        }
    }

    public function monthlySalesRequest($request){
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        if ($startDate->diffInDays($endDate) < 30) {
            return response()->json([
                'status' => 422,
                'data' => 'The date range has to be at least 30 days',
                'type' => 'month_validation'
            ]);
        }   

    }
}





?>