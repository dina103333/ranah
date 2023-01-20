<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function keeper(){
        return $this->belongsTo(Admin::class,'created_by');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'receipts_products','product_id','receipt_id');
    }
}
