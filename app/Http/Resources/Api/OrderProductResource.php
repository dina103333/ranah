<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'id'                            => $this->id,
            'name'                          => $this->name,
            'image_url'                     => url('/storage/'.$this->image) ,
            'wholesale_type'                => $this->wholesale_type,
            'item_type'                     => $this->item_type,
            'selling_type'                  => $this->selling_type,
            'wholesale_quantity_units'      => $this->wholesale_quantity_units,
            'wholesale_quantity'            => $this->orders[0]->pivot->current_wholesale_quantity,
            'unit_quantity'                 => $this->orders[0]->pivot->current_unit_quantity,
            'wholesale_price'               => $this->orders[0]->pivot->wholesale_price,
            'unit_price'                    => $this->orders[0]->pivot->unit_price,
            'total'                         => $this->orders[0]->pivot->total,
        ];
    }
}
