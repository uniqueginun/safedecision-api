<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory, HasRecursiveRelationships;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'cpu_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function getRouteKeyName() 
    {
        return 'slug';
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
