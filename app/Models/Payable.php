<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payable extends Model
{
    use HasFactory;

    protected $fillable = [
        'lender_name',
        'description',
        'total_amount',
        'installment_amount',
        'remaining_amount',
        'status',
        'due_date',
    ];
}
