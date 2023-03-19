<?php

namespace App\Http\Resources\Api\Driver;

use App\Http\Resources\Api\ProductDiscountResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "id"=> $this->id,
            "name"=> $this->name,
            "wholesale_type"=> $this->wholesale_type,
            "item_type"=> $this->item_type,
            "wholesale_quantity_units"=> $this->wholesale_quantity_units,
            "status"=> $this->status,
            'image_url' => url('/storage/'.$this->image) ,
            "current_unit_quantity"=> $this->pivot->current_unit_quantity,
            "current_wholesale_quantity"=> $this->pivot->current_wholesale_quantity,
            "unit_price"=> $this->pivot->unit_price,
            "wholesale_price"=> $this->pivot->wholesale_price,
            "total"=> $this->pivot->total,
            'discounts' => ProductDiscountResource::collection($this->discounts)
        ];
    }
}
