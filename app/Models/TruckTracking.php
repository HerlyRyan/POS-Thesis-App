<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckTracking extends Model
{
    use HasFactory;

    protected $fillable = ['truck_id', 'latitude', 'longitude', 'status'];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
}
