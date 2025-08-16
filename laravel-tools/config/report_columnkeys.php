<?php
return [
    'sales' => [

        'weekly' =>[

            'columnkeys' => [
                
                0 => 'week_number',
                1 => 'from',
                2 => 'to',
                3 => 'total_sales',
               
            ],
        ],
        'monthly' => [
            
            'columnkeys' => [
                
                0 => 'month_number',
                1 => 'from',
                2 => 'to',
                3 => 'total_sales',
            ],
            
        ],
        'all' => [
            'columnkeys' => [
                0 => 'id',
                1 => 'order_number',
                2 => 'subtotal',
                3 => 'payment_status',
                4 => 'created_at'
            ],
        ],
     
     
        ]
    ];

    