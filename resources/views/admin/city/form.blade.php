@csrf
<div class="form-group">
    <label for="code" class="col-sm-12">@lang('data.Country')</label>
    <select class="form-control" name="country">
        @foreach($countries as $country)
            @if(isset($city) && $city->country_id == $country->id )
                <option value="{{$country->id}}" selected >{{$country->name}}</option>
            @else
                <option value="{{$country->id}}"  >{{$country->name}}</option>
            @endif
        @endforeach

    </select>
</div>

@if ($errors->has('country'))
    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('country') }}</span>
@endif

<div class="form-group">
    <label for="code" class="col-sm-12">@lang('data.arabic_name')</label>
    <input type="text" class="form-control"  name="name_ar" value="{{isset($city)?$city->getTranslation('name','ar') :old('name_ar') }}">
</div>

@if ($errors->has('name_ar'))
    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name_ar') }}</span>
@endif

<div class="form-group">
    <label for="code" class="col-sm-12">@lang('data.english_name')</label>
    <input type="text" class="form-control"  name="name_en" value="{{isset($city)?$city->getTranslation('name','en') : old('name_en') }}">
</div>

@if ($errors->has('name_en'))
    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name_en') }}</span>
@endif

<div class="form-group">
    <label for="code" class="col-sm-12">@lang('data.Status')</label>
    <select class="form-control" name="status">
        @foreach($status as $state)
            @if(isset($city) && $city->status == $state )
                <option value="{{$state}}" selected >{{$state}}</option>
            @else
                <option value="{{$state}}"  >{{$state}}</option>
            @endif
        @endforeach
    </select>
</div>

@if ($errors->has('status'))
    <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
@endif

<button class="btn btn-success">{{isset($city)? trans('data.Edit') : trans('data.Save') }}</button>
