<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ComplaintController extends Controller
{
    use ApiResponse;
    public function addComplaint(Request $request){
        Complaint::create([
            'user_id' => $request->user()->id,
            'messages' => $request->message,
        ]);
        return $this->successSingle('تم اضافه التعليق بنجاح',[],200);
    }
}
