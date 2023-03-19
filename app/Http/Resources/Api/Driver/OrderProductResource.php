<?php

namespace App\Http\Resources\Api\Driver;

use App\Http\Resources\Api\Driver\ProductResource;
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
        if($this->discount_price != null){
            if($this->discounts_sum_value != null){
                $discount_price = $this->total - $this->discount_price - $this->discounts_sum_value ;
            }else{
                $discount_price = $this->total - $this->discount_price ;
            }
        }else{
            if($this->discounts_sum_value != null){
                $discount_price = $this->total -  $this->discounts_sum_value ;
            }else{
                $discount_price = $this->total ;
            }
        }
        return [
            "id"=> $this->id,
            "sub_total"=> $this->sub_total,
            "total"=> $this->total == 0 ? $this->sub_total + ($this->distance * $this->fee) : $this->total,
            "distance"=> $this->distance,
            "fee"=> $this->fee,
            "status"=> $this->status,
            'discount' =>$this->discount_price == null ? 0.00 : $this->discount_price,
            'product_discount' =>$this->discounts_sum_value == null ? 0.00 : $this->discounts_sum_value,
            'promo_code_discount' =>$this->promo == null ? 0.00 : $this->promo->value,
            'total_after_discount' => $this->promo == null ? $discount_price : $discount_price - $this->promo->value,
            'payment_method' =>$this->total == 0 ? 'تم الدفع باستخدام المحفظه' : ($this->discount_price == null ? 'يتم تحصيل قيمه الطلب كاش من العميل' : 'يتم تحصيل باقى قيمه الطلب كاش من العميل'),
            "created_at"=> $this->created_at,
            'delivered_to_driver' =>$this->delivered_to_driver == true ? true : false,
            'is_completed' =>$this->status == 'تم التسليم'? true : false,
            'user' => UserResource::make($this->user),
            'products' => ProductResource::collection($this->products),
        ];
    }
}
