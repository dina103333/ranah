<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletValue;
use Facade\FlareClient\View;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function DisplayUserWallet($user_id){
        if(!in_array(209,permissions())){
            abort(403);
        }
        $wallet = Wallet::with('user:id,name')->where('user_id', $user_id)->first();
        $wallet_history = WalletValue::where('wallet_id', $wallet->id)->orderBy('id','desc')->paginate(10);
        return View('admin.wallet.show',compact('wallet','wallet_history'));
    }

    public function getUserWallet($wallet_id){
        $wallet_history = WalletValue::where('wallet_id', $wallet_id)->orderBy('id','desc')->get();
        return datatables($wallet_history)->make(true);
    }

    public function edit($wallet_id){
        if(!in_array(210,permissions())){
            abort(403);
        }
        return view('admin.wallet.edit', compact('wallet_id'));
    }

    public function update(Request $request,$wallet_id){
        $wallet = Wallet::where('id',$wallet_id)->first();
        $wallet ->update([
            'value' => $wallet->value + $request->value
        ]);

        WalletValue::create([
            'wallet_id' => $wallet->id,
            'value' =>  $request->value,
            'type' => 'باقى',
            'active' => false,
        ]);
        return redirect()->route('admin.user-wallet',$wallet->user_id)->with('success','تم التعديل ع المحفظه بنجاح');
    }
}
