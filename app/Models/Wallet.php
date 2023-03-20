<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $table = 'wallets';
    protected $guarded=[];

    public function values(){
        return $this->hasMany(WalletValue::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
