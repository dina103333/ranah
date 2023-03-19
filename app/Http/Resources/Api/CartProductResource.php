<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
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
            'name'  => $this->name,
            'image_url' => url('/storage/'.$this->image) ,
            'wholesale_type'  => $this->wholesale_type,
            'item_type'  => $this->item_type,
            'selling_type'  => $this->selling_type,
            'selling_type'  => $this->selling_type,
            'wholesale_quantity'  => $this->carts[0]->pivot->wholesale_quantity,
            'unit_quantity'  => $this->carts[0]->pivot->unit_quantity,
            'wholesale_price'  => $this->carts[0]->pivot->wholesale_price,
            'unit_price'  => $this->carts[0]->pivot->unit_price,
            'wholesale_total'  => $this->carts[0]->pivot->wholesale_total,
            'unit_total'  => $this->carts[0]->pivot->unit_total,
            'discount_wholesale' =>'0',
            'discount_item' =>'0',
        ];
    }
}
