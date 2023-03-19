<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDiscountResource extends JsonResource
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
            "active"=> isset($this->active) ? ($this->active == true ? true : false) : ($this->type == 'فورى' ? true : false),
            "discount_item_value"=> $this->item_value == null ? 0 : $this->item_value,
            "discount_item_ratio"=> $this->item_ratio == null ? 0 : $this->item_ratio,
            "discount_wholesale_value"=> $this->wholesale_value == null ? 0 : $this->wholesale_value,
            "discount_wholesale_ratio"=> $this->wholesale_ratio == null ? 0 : $this->wholesale_ratio,
        ];
    }
}
