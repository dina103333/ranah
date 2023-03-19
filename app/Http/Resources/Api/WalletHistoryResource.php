<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletHistoryResource extends JsonResource
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
            'value' => $this->type == 'دفع فاتوره' ?'-'. $this->value : '+'. $this->value,
            'type' => $this->type == 'خصم' ? 'اضافه من خصم' : ($this->type == 'دفع فاتوره' ? 'دفع فاتوره طلب': 'باقى من طلب'),
        ];
    }
}
