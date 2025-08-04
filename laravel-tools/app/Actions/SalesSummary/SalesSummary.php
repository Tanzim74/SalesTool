<?php
namespace App\Actions\SalesSummary;

use Illuminate\Support\Facades\DB;

class SalesSummary
{
    

    public function totalSales(){
         $totalSales = DB::table('orders')
            ->join('order_items','orders.id' , '=' , 'order_items.order_id')
            ->where('orders.status','delivered')
            ->sum(DB::raw('order_items.unit_price*order_items.quantity'));
            
        return $totalSales;

    }

  
   

   
}

?>