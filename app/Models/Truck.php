<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'type',
        'capacity',
        'status',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function trackings()
    {
        return $this->hasMany(TruckTracking::class);
    }

    public function latestTracking()
    {
        return $this->hasOne(TruckTracking::class)->latestOfMany();
    }
}
