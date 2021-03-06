<?php

namespace App\Http\Resources;


class CategoryResource extends CategoryIndexResource
{

    public static $wrap = 'categories';
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request) + [
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'cpu_id' => $this->cpu_id,
            'parent' => $this->parent,
            'children' => CategoryResource::collection($this->children),
            'products_count' => $this->products_count,
        ];
    }
}
