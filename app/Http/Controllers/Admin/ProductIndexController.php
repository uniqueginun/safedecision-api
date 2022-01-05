<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;

class ProductIndexController extends Controller
{
    public function __invoke()
    {
        $products = app(Pipeline::class)
                        ->send(Product::query())
                        ->through(Product::$filters)
                        ->thenReturn()
                        ->get();

        return ProductIndexResource::collection($products);
    }
}
