<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'user_id',
        'total_price',
        'payment_method',
        'payment_status',
        'transaction_date',
        'snap_url',
        'note'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // kasir
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }

    public function orders()
    {
        return $this->hasOne(Order::class, 'sale_id');
    }
}
