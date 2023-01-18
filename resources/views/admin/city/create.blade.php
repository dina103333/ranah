@extends('layouts.app')
@section('title') @lang('data.create City')@endsection
@section('back_button')
    <div class="container-fluid">
        <a onclick="Previous()" class="btn btn_primary" style="border-color: darkgreen;background-color: white;"><i class="fas {{(app()->getLocale() == 'en') ? 'fa-arrow-left' : 'fa-arrow-right' }} " style="color: darkgreen;"></i></a>
    </div> 
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">@lang('data.create City')</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cities.store') }}" method="post" enctype="multipart/form-data">
                        @include('admin.city.form')
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
        function Previous() {
            location.replace(document.referrer);
        }
    </script>
@endsection
