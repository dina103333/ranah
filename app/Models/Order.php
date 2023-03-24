<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function driver(){
        return $this->belongsTo(Driver::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function promo(){
        return $this->belongsTo(PromoCode::class , 'promo_code_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class,'orders_products','order_id','product_id')
        ->withPivot('current_unit_quantity','current_wholesale_quantity','unit_price','wholesale_price','total','past_unit_quantity',
        'past_wholesale_quantity','unit_returned_quantity','wholesale_returned_quantity','item_discount','wholesale_discount');
    }

    public function returns(){
        return $this->hasMany(OrderReturn::class ,'order_id');
    }

    public function custodies(){
        return $this->hasMany(OrderReturn::class ,'order_id');
    }

    public function discounts(){
        return $this->hasMany(OrderDiscount::class);
    }


    public static function getEnumValues($table, $column) {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            $enum[] = $v;
        }
        return $enum;
    }
}
