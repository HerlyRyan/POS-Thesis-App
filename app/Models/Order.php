<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'worker_id',
        'driver_id',
        'truck_id',
        'shipping_date',
        'status',
    ];

    public function sale()
    {
        return $this->belongsTo(Sales::class);
    }

    public function workers()
    {
        return $this->belongsToMany(Employees::class, 'order_worker', 'order_id', 'worker_id');
    }

    public function driver()
    {
        return $this->belongsTo(Employees::class, 'driver_id');
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
