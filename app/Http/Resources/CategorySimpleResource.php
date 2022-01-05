<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategorySimpleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->name,
            'parent_id' => $this->parent_id,
            'slug' => $this->slug,
            'products_count' => $this->products_count,
            'children' => CategorySimpleResource::collection($this->whenLoaded('children')),
        ];
    }
}
