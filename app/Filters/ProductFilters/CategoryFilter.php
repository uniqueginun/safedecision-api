<?php

namespace App\Filters\ProductFilters;

use Closure;
use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements Filter
{
   public function handle(Builder $builder, Closure $next)
   {
      $condition = request('category') ?? false;

      $builder->when($condition, function (Builder $q, $cats) {
         $q->whereRelation('category', function (Builder $catQuery) use ($cats) {
            $catQuery->whereRelation('descendantsAndSelf', fn (Builder $q) => $q->whereIn('id', $cats)); 
         });
      });

      return $next($builder);
   }
}