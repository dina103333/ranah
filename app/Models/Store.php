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

    public function area(){
        return $this->belongsTo(Area::class);
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
