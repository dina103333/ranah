<?php

namespace App\Http\Resources\Api\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class CustodyProductResource extends JsonResource
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
            'image_url' => url('/storage/'.$this->image) ,
            "returns_wholesale_quantity"=> $this->returns_sum_order_returnswholesale_quantity,
            "returns_unit_quantity"=> $this->returns_sum_order_returnsunit_quantity
        ];
    }
}
