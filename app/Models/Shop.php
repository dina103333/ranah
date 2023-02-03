<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'shopes';
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function area(){
        return $this->belongsTo(Area::class,'area_id');
    }
    public function type(){
        return $this->belongsTo(ShopType::class,'shop_types_id');
    }
    public function car(){
        return $this->belongsTo(Car::class,'car_id');
    }
}
