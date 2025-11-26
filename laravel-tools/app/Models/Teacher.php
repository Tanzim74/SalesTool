<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{

    use HasFactory;
    protected $fillable = [
    'email',
    'national_id_image',
    'education',
    'last_qualification',
    'age',
    'phone_number',
    'account_no',
    'user_id'
    
];

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
