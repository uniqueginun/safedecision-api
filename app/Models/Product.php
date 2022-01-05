<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Filters\ProductFilters\CompanyFilter;
use App\Filters\ProductFilters\CategoryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'category_id',
        'company_id',
        'user_id'
    ];

    public static $filters = [
        CompanyFilter::class,
        CategoryFilter::class,
    ];

    public function formattedPrice()
    {
        return 'SAR ' . number_format($this->price, 2);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
