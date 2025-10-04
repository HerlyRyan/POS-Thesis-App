<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount_percentage',
        'payment_method',
        'start_date',
        'end_date',
        'expected_increase'
    ];

    public function sales()
    {
        return $this->hasMany(Sales::class, 'promotion_id');
    }
}
