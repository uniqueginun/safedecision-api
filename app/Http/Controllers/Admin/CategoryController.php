<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryIndexResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategorySimpleResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->has('index')) {
            return CategoryIndexResource::collection(
                Category::tree()->paginate(100)
            );
        }

        if (request()->has('simple')) {
            return CategorySimpleResource::collection(
                Category::tree()->get()->toTree()
            );
        }

        return CategoryResource::collection(
            Category::tree()->get()->toTree()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create(
            $request->validate([
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|integer',
                'cpu_id' => 'nullable|integer',
            ])
        );

        $request->collect('children')->each(function ($child) use ($category) {
            $child = $category->children()->create([
                'name' => $child['name']
            ]);
        });

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategorySimpleResource($category->load('children'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $category->update(
            $request->validate([
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|integer',
                'cpu_id' => 'nullable|integer',
            ])
        );

        $idsList = [];

        $request->collect('children')->each(function ($child) use ($category, &$idsList) {
            $child = $category->children()->updateOrCreate(
                ['id' => $child['id']],
                ['name' => $child['name']]
            );

            $idsList[] = $child->id;
        });

        $category->children()->whereNotIn('id', $idsList)->delete();

        return new CategoryResource($category->load('children'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
