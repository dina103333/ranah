@extends('admin.layouts.app')
@section('title') البائعين @endsection
@section('list')
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">لوحه التجكم</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-200 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">qr</li>
    </ul>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-role-table-toolbar="base">
                            <a href="#" class="btn btn-success btnprn">print</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="card-body pt-0" style="direction: rtl">
                    <img style="width: 60%;padding: 20px;" src="{{$qr_code_url}}" class="img img-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
     $(document).ready(function(){
        $('.btnprn').click(function(){
            window.print();
        });

    });
</script>
@endsection


