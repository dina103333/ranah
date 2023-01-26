<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    // public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_name' => $this->company->name,
            'category_name' => $this->category->name,
            'wholesale_quantity' => $this->stores[0]->pivot->wholesale_quantity,
            'unit_quantity' => $this->stores[0]->pivot->unit_quantity,
            'wholesale_type' => $this->wholesale_type,
            'item_type' => $this->item_type,
            'reorder_limit' => $this->stores[0]->pivot->reorder_limit,
            'buy_price' => $this->stores[0]->pivot->buy_price,
            'sell_item_price' => $this->stores[0]->pivot->sell_item_price,
            'sell_wholesale_price' => $this->stores[0]->pivot->sell_wholesale_price,
            'production_date' => $this->stores[0]->pivot->production_date,
            'expiry_date' => $this->stores[0]->pivot->expiry_date,
        ];
    }
}
