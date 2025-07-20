<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'status',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordersAsWorker()
    {
        return $this->belongsToMany(Order::class, 'order_worker', 'worker_id', 'order_id');
    }

    public function activeOrder()
    {
        return $this->hasOne(Order::class, 'driver_id')->where('status', 'pengiriman');
    }
}
