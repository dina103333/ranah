<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array(18,permissions())){
            abort(403);
        }
        $complaints = Complaint::with('user:id,name,store_id','user.store:id,name')->orderBy('id','desc')->paginate(10);
        return view('admin.complaint.index',compact('complaints'));
    }

    public function getComplaints(){
        $complaints =Complaint::with('user:id,name,store_id','user.store:id,name')->orderBy('id','desc')->get();
        return datatables($complaints)->make(true);
    }

    public function productComplaint()
    {
        if(!in_array(14,permissions())){
            abort(403);
        }
        $complaints = ProductComment::with('product:id,name','user:id,name,store_id','user.store:id,name')->orderBy('products_comments.id','desc')->paginate(10);
        return view('admin.product_complaint.index',compact('complaints'));
    }

    public function getProductComplaints(){
        $complaints = ProductComment::with('product:id,name','user:id,name,store_id','user.store:id,name')->orderBy('products_comments.id','desc');
        return datatables($complaints)->make(true);
    }
}
