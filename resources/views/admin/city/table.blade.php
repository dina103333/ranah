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
