<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class Order extends Model
{
    use Searchable;
    use HasFactory;

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'customer_name' =>$this->customer_name,
            'total_amount' => $this->total_amount,
            'payment_status' => $this->payment_status,
            'actions' => $this->actions

        ];
    }
}
