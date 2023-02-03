<?php

namespace App\Http\Resources\Api;

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
            'sub_total' =>$this->sub_total,
            'total' =>$this->total,
            'status' =>$this->status,
            'distance' =>$this->distance,
            'fee' =>$this->fee,
            'created_at' =>$this->created_at,
        ];
    }
}
