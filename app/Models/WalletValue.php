<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletValue extends Model
{
    use HasFactory;
    protected $table = 'wallet_value';
    protected $guarded=[];
}
