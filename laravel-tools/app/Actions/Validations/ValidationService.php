<?php
namespace App\Actions\Validations;
use Illuminate\Support\Facades\Validator;
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
                'data' => $validator
            ];
        }
        
        
        
    }
}





?>