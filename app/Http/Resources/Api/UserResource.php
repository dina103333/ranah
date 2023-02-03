<?php

namespace App\Http\Resources\Api;

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
            'name' =>$this->name,
            'mobile_number' => $this->mobile_number,
            'seconde_mobile_number' => $this->seconde_mobile_number == null ? '' : $this->seconde_mobile_number,
            'status'=> $this->status,
            'change_location'=> $this->change_location == true ? true : false,
            'shop_name' => $this->shop->name,
            'shop_address' => $this->shop->address,
            'shop_longitude' => $this->shop->longitude,
            'shop_latitude' => $this->shop->latitude,
            'shop_from' => $this->shop->from? $this->shop->from: '',
            'shop_to' => $this->shop->to? $this->shop->to: '',
            'shop_image' => url('/storage/'.$this->shop->image),
            'shop_type' => $this->shop->type->name,
            'shop_car' => $this->shop->car ? $this->shop->car->name : '',
            'shop_area' => $this->shop->area ? $this->shop->area->name : '',
        ];
    }
}
