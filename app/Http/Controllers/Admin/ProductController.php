<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductStoreRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return ProductResource::collection(
            Product::with('category', 'company')->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        return new ProductResource(
            Product::create(
                array_merge($request->validated(), [
                    'user_id' => $request->user()->id,
                ])
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return new ProductResource(
            $product->load('category', 'company')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductStoreRequest $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductStoreRequest $request, Product $product)
    {
        $product->update($request->validated());

        return new ProductResource(
            $product->load('category', 'company')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
