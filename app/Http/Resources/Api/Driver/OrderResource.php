<?php

namespace App\Http\Resources\Api\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' =>$this->id,
            'total' =>$this->total,
            'status' =>$this->status,
            'distance' =>$this->distance,
            'fee' =>$this->fee,
            'created_at' =>$this->created_at,
            'delivered_to_driver' =>$this->delivered_to_driver == true ? true : false,
            'user_name' => $this->user->name,
            'user_mobile_number' => $this->user->mobile_number,
            'user_seconde_mobile_number' => $this->user->seconde_mobile_number,
            'shop_name' => $this->user->shop->name,
            'shop_address' => $this->user->shop->address,
            'shop_longitude' => $this->user->shop->longitude,
            'shop_latitude' => $this->user->shop->latitude,
            'shop_from' => $this->user->shop->from,
            'shop_to' => $this->user->shop->to,
            'shop_car' => $this->user->shop->car->name,
        ];
    }
}
