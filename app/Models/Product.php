<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category', 'price', 'cost_price', 'stock', 'unit', 'image'];

    protected $appends = ['average_rating', 'reviews_count'];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function reviewByCustomer($customerId)
    {
        return $this->reviews()->where('customer_id', $customerId)->first();
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // Optional: rata-rata rating
    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    // Optional: jumlah review
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
