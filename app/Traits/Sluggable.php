<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
   public static function boot()
   {
       parent::boot();

       static::creating(function ($category) {
           $category->slug = Str::slug($category->name);
       });
   }
}