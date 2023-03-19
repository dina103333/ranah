<?php

namespace App\Http\Resources\Api\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "id"                        => $this->id,
            "name"                      => $this->name,
            "mobile_number"             => $this->mobileNumber,
            "seconde_mobile_number"     => $this->seconde_mobile_number,
            "shop_name"                 => $this->shop->name,
            "shop_address"              => $this->shop->address,
            "shop_longitude"            =>  $this->shop->longitude,
            "shop_latitude"             => $this->shop->latitude,
            "shop_from"                 => $this->shop->from,
            "shop_to"                   => $this->shop->to,
            'shop_image'                => url('/storage/'.$this->shop->image),
            'shop_car'                  => $this->shop->car ? $this->shop->car->name : '',
        ];
    }
}
