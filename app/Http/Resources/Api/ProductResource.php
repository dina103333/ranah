<?php

namespace App\Http\Resources\Api;

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
        return[
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => url('/storage/'.$this->image) ,
            'selling_type' =>$this->selling_type == 'جمله وقطاعى' ? 2 : 1 ,
            'wholesale_type' =>$this->wholesale_type ,
            'item_type' =>$this->item_type ,
            'wholesale_quantity_units' =>$this->wholesale_quantity_units ,
            'wholesale_buy_price' =>$this->stores != '[]'?$this->stores[0]->pivot->sell_wholesale_price: 0.00 ,
            'item_buy_price' =>$this->stores != '[]'?$this->stores[0]->pivot->sell_item_price * $this->wholesale_quantity_units: 0.00 ,
            'available_in_store' =>$this->stores != '[]'?($this->stores[0]->pivot->wholesale_quantity > 0 || $this->stores[0]->pivot->unit_quantity > 0 ? true : false):false,
            'is_available_for_order' =>$this->is_available_for_order == true ? true :false,
        ];
    }
}
