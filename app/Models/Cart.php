<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function products(){
        return $this->belongsToMany(Product::class,'cart_products','cart_id','product_id')
        ->withPivot('wholesale_quantity','unit_quantity','wholesale_price','unit_price','wholesale_total','unit_total');
    }
}
