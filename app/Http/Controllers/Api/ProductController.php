<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductCommentRequest;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\ShowProductResource;
use App\Models\Area;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\Shop;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;
    public function getProducts(Request $request){
        if(!$request->user()){
            $store = Store::where('status','تفعيل')->select('id')->first();
            if(!$store){
                return  $this->error('غير متوفر الان',422);
            }
        }else{
            $shop = Shop::where('id',$request->user()->shop_id)->select('area_id')->first();
            if(!$shop){
                return  $this->error('هذا المستخدم لم يكمل بيانات المحل الخاص به',422);
            }
            $area = Area::find($shop->area_id);
            $store = Store::where('status','تفعيل')->where('id',$area->store_id)->select('id')->first();
            if(!$store){
                return  $this->error('لا يوجد مخزن فى هذه المنطقه او قد يكون المخزن غير مفعل',422);
            }
        }
        $products = Product::where('company_id',$request->company_id)
        ->whereHas('stores',function($q) use($store){
            $q->where('stores_products.store_id',$store->id)
            ->where('stores_products.sell_wholesale_price','!=',null);
        })->with(['store_discounts'=>function($q) use ($store){
            $q->where('discount_products.store_id',$store->id)->where('status','تفعيل');
        },'stores'=>function($q) use($store){
            $q->where('stores_products.store_id',$store->id)
            ->where('stores_products.sell_wholesale_price','!=',null);
        }])->where('products.status','تفعيل')->paginate(6);
        return  $this->successSingle('تم بنجاح',ProductResource::collection($products)->response()->getData(true),200);

    }

    public function showProduct(Request $request){
        if(!$request->user()){
            $store = Store::where('status','تفعيل')->select('id')->first();
            if(!$store){
                return  $this->error('غير متوفر الان',422);
            }
        }else{
            $shop = Shop::where('id',$request->user()->shop_id)->select('area_id')->first();
            if(!$shop){
                return  $this->error('هذا المستخدم لم يكمل بيانات المحل الخاص به',422);
            }
            $area = Area::find($shop->area_id);
            $store = Store::where('status','تفعيل')->where('id',$area->store_id)->select('id')->first();
            if(!$store){
                return  $this->error('لا يوجد مخزن فى هذه المنطقه او قد يكون المخزن غير مفعل',422);
            }
        }
        $products = Product::where('id',$request->product_id)
        ->whereHas('stores',function($q) use($store){
            $q->where('stores_products.store_id',$store->id)
            ->where('stores_products.sell_wholesale_price','!=',null);
        })->with(['store_discounts'=>function($q) use ($store){
            $q->where('discount_products.store_id',$store->id);
        },'stores'=>function($q) use($store){
            $q->where('stores_products.store_id',$store->id)
            ->where('stores_products.sell_wholesale_price','!=',null);
        },'carts'=>function($q) use($request){
            if($request->user()){
                $q->where('carts.shop_id',$request->user()->shop_id);
            }
        }])->first();
        if($products){
            return $this->successSingle('تم بنجاح',ShowProductResource::make($products),200);
        }else{
            return $this->successSingle('هذا المنتج غير موجود على مخزن',[],422);
        }

    }


    public function SearchProducts(Request $request){
        if(!$request->user()){
            $store = Store::where('status','تفعيل')->select('id')->first();
            if(!$store){
                return  $this->error('غير متوفر الان',422);
            }
        }else{
            $shop = Shop::where('id',$request->user()->shop_id)->select('area_id')->first();
            if(!$shop){
                return  $this->error('هذا المستخدم لم يكمل بيانات المحل الخاص به',422);
            }
            $area = Area::find($shop->area_id);
            $store = Store::where('status','تفعيل')->where('id',$area->store_id)->select('id')->first();
            if(!$store){
                return  $this->error('لا يوجد مخزن فى هذه المنطقه او قد يكون المخزن غير مفعل',422);
            }
        }
        $products = Product::where(function($q) use($request){
            if($request->search){
                $q->where('name', 'LIKE', '%'.$request->search.'%');
            }
        })
        ->whereHas('stores',function($q) use($store){
            $q->where('stores_products.store_id',$store->id)
            ->where('stores_products.sell_wholesale_price','!=',null);
        })->with(['store_discounts'=>function($q) use ($store){
            $q->where('discount_products.store_id',$store->id)->where('status','تفعيل');
        },'stores'=>function($q) use($store){
            $q->where('stores_products.store_id',$store->id)
            ->where('stores_products.sell_wholesale_price','!=',null);
        }])->paginate(6);
        return  $this->successSingle('تم بنجاح',ProductResource::collection($products)->response()->getData(true),200);
    }

    public function addComment(ProductCommentRequest $request){
        ProductComment::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user()->id,
            'comment' => $request->comment,
        ]);
        return $this->successSingle('تم اضافه التعليق بنجاح',[],200);
    }


    public function bestSellingProducts(Request $request){
        if(!$request->user()){
            $store = Store::where('status','تفعيل')->select('id')->first();
            if(!$store){
                return  $this->error('غير متوفر الان',422);
            }
        }else{
            $shop = Shop::where('id',$request->user()->shop_id)->select('area_id')->first();
            $area = Area::find($shop->area_id);
            $store = Store::where('status','تفعيل')->where('id',$area->store_id)->select('id')->first();
        }
        $bestSellers = Product::withCount('totalSold')
                        ->whereHas('stores',function($q) use($store){
                            $q->where('stores_products.store_id',$store->id)
                            ->where('stores_products.sell_wholesale_price','!=',null);
                        })->with(['store_discounts'=>function($q) use ($store){
                            $q->where('discount_products.store_id',$store->id);
                        },'stores'=>function($q) use($store){
                            $q->where('stores_products.store_id',$store->id)
                            ->where('stores_products.sell_wholesale_price','!=',null);
                        }])->orderByDesc('total_sold_count')->take(5)->get();
        return  $this->successSingle('تم بنجاح',ProductResource::collection($bestSellers)->response()->getData(true),200);
    }

    public function getDiscountsOfPorducts(Request $request){
        if(!$request->user()){
            $store = Store::where('status','تفعيل')->select('id')->first();
            if(!$store){
                return  $this->error('غير متوفر الان',422);
            }
        }else{
            $shop = Shop::where('id',$request->user()->shop_id)->select('area_id')->first();
            if(!$shop){
                return  $this->error('هذا المستخدم لم يكمل بيانات المحل الخاص به',422);
            }
            $area = Area::find($shop->area_id);
            $store = Store::where('status','تفعيل')->where('id',$area->store_id)->select('id')->first();
            if(!$store){
                return  $this->error('لا يوجد مخزن فى هذه المنطقه او قد يكون المخزن غير مفعل',422);
            }
        }
        $products = Product::where('company_id',$request->company_id)
        ->whereHas('stores',function($q) use($store){
            $q->where('stores_products.store_id',$store->id)
            ->where('stores_products.sell_wholesale_price','!=',null);
        })->whereHas('store_discounts',function($q) use ($store){
            $q->where('discount_products.store_id',$store->id)->where('status','تفعيل');
        })->with(['store_discounts'=>function($q) use ($store){
            $q->where('discount_products.store_id',$store->id);
        },'stores'=>function($q) use($store){
            $q->where('stores_products.store_id',$store->id)
            ->where('stores_products.sell_wholesale_price','!=',null);
        }])->paginate(6);
        return  $this->successSingle('تم بنجاح',ProductResource::collection($products)->response()->getData(true),200);
    }
}
