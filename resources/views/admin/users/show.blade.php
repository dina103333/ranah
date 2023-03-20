@extends('admin.layouts.app')
@section('title') العملاء @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted"> العملاء</li>
    </ul>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0" style="direction: rtl">
                        <div class="modal-header" id="kt_modal_add_role_header">
                            <h2 class="fw-bolder">{{$user->name}}</h2>
                            <div>
                                <a href="{{route('admin.user-wallet',$user->id)}}" class="btn btn-light" title="محفظه العميل"> <i class="fas fa-wallet"></i></a>
                                <a href="#" class="btn btn-light" title="نقط العميل"><i class="fas fa-hand-point-up"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="fw-bolder mt-5">رقم الهاتف</div>
                                <div class="text-gray-600">{{$user->mobile_number}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">الرقم البديل</div>
                                <div class="text-gray-600">{{$user->seconde_mobile_number == null ? 'لا يوجد رقم اخر' :$user->seconde_mobile_number}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">نوع الحساب</div>
                                <div class="text-gray-600">{{$user->type}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">حاله الحساب</div>
                                <div class="text-gray-600">{{$user->status}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">مضاف بواسطه مندوب مبيعات</div>
                                <div class="text-gray-600">{{$user->seller ? $user->seller->name : '__'}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">مضاف بواسطه مسؤول</div>
                                <div class="text-gray-600">{{$user->addedBy ? $user->addedBy->name : ''}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">اسم المحل</div>
                                <div class="text-gray-600">{{$user->shop ? $user->shop->name : ''}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">عنوان المحل</div>
                                <div class="text-gray-600">
                                    <a href="https://maps.google.com?q={{$user->shop->latitude}},{{$user->shop->longitude}}" TARGET="_blank">
                                        {{$user->shop ? $user->shop->address : ''}}
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">مواعيد العمل</div>
                                <div class="text-gray-600">{{$user->shop ? $user->shop->from  : ''}} - {{$user->shop ? $user->shop->to  : ''}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">نوع المحل</div>
                                <div class="text-gray-600">{{$user->shop ? $user->shop->type->name  : ''}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">السياره</div>
                                <div class="text-gray-600">{{$user->shop ? $user->shop->car->name  : ''}}</div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bolder mt-5">المنطقه</div>
                                <div class="text-gray-600">{{$user->shop ? $user->shop->area->name  : ''}}</div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script src="/assets/js/custom/apps/categories/list/list.js"></script>
@endsection


