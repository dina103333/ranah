@extends('layouts.app')
@section('title') @lang('data.Cities')@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@lang('data.Cities')</h3>
                        </div><!-- /.col -->
                        <div class="col-sm-6 d-flex justify-content-end">
                            <a class="btn btn-success" href="{{route('admin.cities.create')}}">@lang('data.Add')</a>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
                <div id="tag_container">
                    <div class="table-responsive">
                        <table class="table align-items-center text-center table-flush table-data">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('data.Country Name')</th>
                                <th scope="col">@lang('data.Name')</th>
                                <th scope="col">@lang('data.Status')</th>
                                <th scope="col">@lang('data.Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cities as $key=>$city)
                                <tr>
                                    <td style="width:150px">{{++$key}}</td>
                                    <td style="width:150px">{{$city->country->name}}</td>
                                    <td style="width:150px">
                                        {{$city->name}}
                                    </td>
                                    <td style="width:150px">
                                        {{$city->status}}
                                    </td>
                                    <td style="width:150px">
                                        <a href="{{route('admin.cities.edit',$city)}}" class="btn btn-secondary" >@lang('data.Edit') <i class="fas fa-edit"></i></a>
                                        <button data-url="{{ route('admin.delete_cities', $city) }}" class="btn btn-danger delete">@lang('data.Delete') <i class="fas fa-trash-alt"></i></button>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {!! $cities->links("pagination::bootstrap-4") !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        let lang= '{{app()->getLocale()}}'
        setTimeout(function() {
            $('.flash').fadeOut('fast');
        }, 3000);
        $(document).on('click', '.delete', function (e) {
            if(lang == 'en') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(this).data('url'),
                            type: 'Get',
                            data: {
                                _method : 'DELETE',
                                _token : '{{ csrf_token() }}'
                            },
                            success: function (res) {
                                if (result.value) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    );
                                    getAllcities();
                                }
                            }
                        });
                    }
                })
            }else{
                Swal.fire({
                    title: 'هل انت متأكد؟',
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم احذفها!',
                    cancelButtonText: 'الغاء',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(this).data('url'),
                            type: 'Get',
                            data: {
                                _method : 'DELETE',
                                _token : '{{ csrf_token() }}'
                            },
                            success: function (res) {
                                if (result.value) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'تم الحذف',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    getAllcities();
                                }
                            }
                        });
                    }
                })
            }
            function getAllcities() {
                $.ajax({
                    url: '{{ route('admin.get-city') }}',
                    type: 'GET',
                    success: function (res) {
                        $('.table-data tbody').html(res);
                    }
                })
            }
        });
        $(document).on('click', '.page-link', function (e) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getAllcities2(page)
        });
        function getAllcities2(page = 1) {
            $.ajax({
                url: '{{ route('admin.get-city') }}?page=' + page,
                type: 'GET',
                success: function (res) {
                    $("#tag_container").empty().html(res);
                }
            })
        }

    </script>
@endsection

