<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custody extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $guarded=[];
    protected $table = 'driver_custodies';

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
