<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceReports extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'source',
        'amount',
        'description',
        'transaction_date',
        'total',
    ];
}
