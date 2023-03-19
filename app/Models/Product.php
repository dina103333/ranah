<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];


    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function stores(){
        return $this->belongsToMany(Store::class,'stores_products','product_id','store_id')
        ->withPivot('sell_wholesale_price','sell_item_price','wholesale_quantity','unit_quantity','lower_limit',
                    'max_limit','reorder_limit','buy_price','unit_gain_ratio','wholesale_gain_ratio','wholesale_gain_value','unit_gain_value',
                     'loss','production_date','expiry_date');
    }
    public function carts(){
        return $this->belongsToMany(Cart::class,'cart_products','product_id','cart_id')
        ->withPivot('wholesale_quantity','unit_quantity','wholesale_price','unit_price','wholesale_total','unit_total');
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'orders_products','product_id','order_id')
        ->withPivot('current_unit_quantity','current_wholesale_quantity','unit_price','wholesale_price','total');
    }

    public function sliders(){
        return $this->belongsToMany(Slider::class,'slider_products','product_id','slider_id');
    }

    public function transfers(){
        return $this->belongsToMany(Transfer::class,'transfers_products','product_id','transfers_id')
        ->withPivot('wholesale_quantity','unit_quantity','production_date','expiry_date','buy_price');
    }
    public function returns(){
        return $this->hasMany(OrderReturn::class);
    }

    public function discounts(){
        return $this->hasMany(OrderDiscount::class);
    }
    public function store_discounts(){
        return $this->hasMany(DiscountProduct::class);
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function totalSold()
    {
        return $this->hasMany(OrderProduct::class)->selectRaw('product_id, sum(quantity) as total_sold')->groupBy('product_id');
    }

}
