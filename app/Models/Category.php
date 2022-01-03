<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory, HasRecursiveRelationships, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'cpu_id'
    ];

    public static function booted()
    {
        parent::booted();

        static::deleted(function ($category) {
            $category->products()->delete();
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
