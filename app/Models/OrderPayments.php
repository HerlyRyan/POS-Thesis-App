<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'employee_id',
        'role',
        'amount',
        'invoice_number',
        'paid_at',
    ];

    protected $dates = ['paid_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public function isPaid()
    {
        return !is_null($this->paid_at);
    }
}
