<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $table = 'transfers';
    protected $guarded=[];

    public function products(){
        return $this->belongsToMany(Product::class,'transfers_products','transfers_id','product_id')
        ->withPivot('wholesale_quantity','unit_quantity','production_date','expiry_date','buy_price');
    }

    public function stores(){
        return $this->hasMany(Store::class,'id','from_store_id');
    }
}
