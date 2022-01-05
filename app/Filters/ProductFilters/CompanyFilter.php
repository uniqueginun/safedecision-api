<?php

namespace App\Filters\ProductFilters;

use Closure;
use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CompanyFilter implements Filter
{
   public function handle(Builder $builder, Closure $next)
   {
      $builder->when(
         request('company') ?? false, 
         fn ($q, $companies) => $q->whereIn('company_id', $companies)
      );

      return $next($builder);
   }
}