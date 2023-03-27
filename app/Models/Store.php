<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function admins(){
        return $this->hasMany(Admin::class);
    }
    public function keeper(){
        return $this->belongsTo(Admin::class,'store_keeper_id');
    }
    public function finance_manager(){
        return $this->belongsTo(Admin::class,'store_finance_manager_id');
    }

    public function areas(){
        return $this->hasMany(Area::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'stores_products','store_id','product_id')
        ->withPivot('sell_wholesale_price','sell_item_price','wholesale_quantity','unit_quantity','lower_limit',
                    'max_limit','reorder_limit','buy_price','unit_gain_ratio','wholesale_gain_ratio','wholesale_gain_value','unit_gain_value',
                     'loss','production_date','expiry_date');
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
