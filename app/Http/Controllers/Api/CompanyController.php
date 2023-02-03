<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CompanyResource;
use App\Models\Company;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use ApiResponse;

    public function getCompanies(){
        $companies = Company::where('status','تفعيل')->select('id','name','image')
                            ->get();
        return $this->successSingle('تم بنجاح',CompanyResource::collection($companies),200);
    }
}
