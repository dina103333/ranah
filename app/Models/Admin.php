<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Admin extends Authenticatable
{
    protected $guard = 'admins';
    use HasFactory;
    protected $guarded=[];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role(){
        return $this->belongsTo(Role::class)->withDefault([
            'name' => 'No Role'
        ]);
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
