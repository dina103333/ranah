<?php

namespace App\Http\Resources\Api\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
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
            'id'                            =>  $this->id,
            'name'                          =>  $this->name,
            'address'                       =>  $this->address,
            'longitude'                     =>  $this->longitude,
            'latitude'                      =>  $this->latitude,
            'received_from_driver'          =>  $this->received_from_driver == true ? true : false,
            'received_from_store'           =>  $this->received_from_store == true ? true : false,
            'products'                      =>  TransferProductResource::collection($this->products)
        ];
    }
}
