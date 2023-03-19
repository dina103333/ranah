<?php

namespace App\Http\Resources\Api\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferProductResource extends JsonResource
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
            'id'                        =>  $this->id,
            'name'                      =>  $this->name,
            'wholesale_quantity'        =>  $this->pivot->wholesale_quantity,
            'unit_quantity'             =>  $this->pivot->unit_quantity,
            'wholesale_type'            =>  $this->pivot->wholesale_type,
            'item_type'                 =>  $this->pivot->item_type,
        ];
    }
}
