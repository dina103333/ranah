<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartProductRequest;
use App\Http\Resources\Api\CartProductResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\Shop;
use App\Models\StoreProduct;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class CartController extends Controller
{
    use ApiResponse;
    public function addCartProducts(CartProductRequest $request){
        $cart = Cart::where('shop_id',$request->user()->shop_id)->first();
        $product_price = StoreProduct::where('store_id',$request->user()->store_id)
                            ->where('product_id',$request->product_id)->where(function($q){
                                $q->where('wholesale_quantity','>',0)->
                                orWhere('unit_quantity','>',0);
                            })->first();
        if(!$product_price){
            return $this->error('عذرا هذا المنتج غير موجود بالمخزن',422);
        }
        
        if($product_price->max_limit !=0 ){
            if($product_price->lower_limit > $request->wholesale_quantity || $product_price->max_limit < $request->wholesale_quantity ){
                return $this->error('لا يمكن الطلب بهذه الكميه علما بأن اقصى كميه متاحه واقل كميه هى'.$product_price->lower_limit .'و'.$product_price->max_limit );
            }
        }

        if($request->wholesale_quantity > $product_price->wholesale_quantity || $request->unit_quantity > $product_price->unit_quantity){
            return $this->error('عذرا لا يوجد هذه الكميه بالمخزن',422);
        }
        if($cart){
            $cart_products = CartProduct::where('cart_id',$cart->id)->pluck('product_id')->toArray();
            if(in_array($request->product_id,$cart_products)){
                $cart_product = CartProduct::where('cart_id',$cart->id)->where('product_id',$request->product_id)->first();
                $cart_product->update([
                    'wholesale_quantity' => $request->wholesale_quantity,
                    'unit_quantity' => $request->unit_quantity ? $request->unit_quantity : 0,
                    'wholesale_total' => $product_price->sell_wholesale_price * $request->wholesale_quantity,
                    'unit_total' => $request->unit_quantity ? $product_price->sell_item_price * $request->unit_quantity : 0,
                    'unit_price' => $request->unit_quantity ? $product_price->sell_item_price : 0,
                    'wholesale_price' => $product_price->sell_wholesale_price,
                ]);
                $cart->update(['sub_total'=>$cart_product->wholesale_total + $cart_product->unit_total]);
            }else{
                $cart_product = CartProduct::create([
                    'cart_id'=> $cart->id,
                    'product_id' => $request->product_id,
                    'wholesale_quantity' => $request->wholesale_quantity,
                    'unit_quantity' => $request->unit_quantity ? $request->unit_quantity : 0,
                    'wholesale_price' => $product_price->sell_wholesale_price,
                    'unit_price' => $request->unit_quantity ? $product_price->sell_item_price : 0,
                    'wholesale_total' => $product_price->sell_wholesale_price * $request->wholesale_quantity,
                    'unit_total' => $request->unit_quantity ? $product_price->sell_item_price * $request->unit_quantity : 0
                ]);
                $cart->update(['sub_total'=>$cart_product->wholesale_total + $cart_product->unit_total]);
            }
        }else{
            $cart = Cart::create([
                'shop_id' => $request->user()->shop_id,
                'store_id' => $request->user()->store_id,
                'sub_total' => 0,
                'total' => 0,
            ]);
            $cart_product =CartProduct::create([
                'cart_id'=> $cart->id,
                'product_id' => $request->product_id,
                'wholesale_quantity' => $request->wholesale_quantity,
                'unit_quantity' => $request->unit_quantity ? $request->unit_quantity : 0,
                'wholesale_price' => $product_price->sell_wholesale_price,
                'unit_price' => $request->unit_quantity ? $product_price->sell_item_price : 0,
                'wholesale_total' => $product_price->sell_wholesale_price * $request->wholesale_quantity,
                'unit_total' => $request->unit_quantity ? $product_price->sell_item_price * $request->unit_quantity : 0
            ]);
            $cart->update(['sub_total'=>$cart_product->wholesale_total + $cart_product->unit_total]);
        }
        return $this->successSingle('تم اضافه المنتج للسله بنجاح',[],200);
    }
    public function getCartProducts(Request $request){
        $cart = Cart::where('shop_id',$request->user()->shop_id)->first();
        $wallet = Wallet::where('user_id',$request->user()->id)->first();
        if(!$cart){
            return $this->successSingle('لا يوجد منتجات فى السله',[],200);
        }
        $products = Product::whereHas('carts',function($q) use($cart){
            $q->where('cart_products.cart_id',$cart->id);
        })->with(['carts'=>function($q) use($cart){
            $q->where('cart_products.cart_id',$cart->id);
        }])->paginate(6);
        $products = CartProductResource::collection($products)->response()->getData(true);
        return $this->success('تم بنجاح',['cart_total'=>$cart->sub_total,'cach_back'=>$wallet->value,'products'=>$products],200);
    }

    public function removeCartProduct(Request $request){
        $cart = Cart::where('shop_id',$request->user()->shop_id)->first();
        $product = CartProduct::where('cart_id',$cart->id)->where('product_id',$request->product_id)->first();
        if(!$product)
            return $this->error('هذا المنتج غير موجود فى السله ',422);
        $cart->update(['sub_total'=>$cart->sub_total - ($product->wholesale_total + $product->unit_total)]);
        $product->delete();
        return $this->success('تم حذف المنتج من السله بنجاح',[],200);
    }


}
