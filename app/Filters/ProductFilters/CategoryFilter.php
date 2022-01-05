<?php

namespace App\Filters\ProductFilters;

use Closure;
use App\Filters\Filter;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements Filter
{
   public function handle(Builder $builder, Closure $next)
   {
      $condition = request('category') ?? false;

      $builder->when($condition, function (Builder $query, $cats) {
         $query->whereHas('category', function ($sql) use ($cats) {
            
            $categories = Category::with('descendants')->where('id', $cats)->get()->transform(function ($category) use ($cats) {
               return $category->descendantsAndSelf()->pluck('id');
           })->flatten();

            $sql->whereIn('categories.id', $categories->toArray());
        })->get();
      });

      return $next($builder);
   }
}