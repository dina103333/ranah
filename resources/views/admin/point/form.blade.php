@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">عدد النقاط</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="point" value="{{isset($point) ? $point->point :'' }}" />
    </div>
    @if ($errors->has('point'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('point') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">من قيمه</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="from" value="{{isset($point) ? $point->from :'' }}" />
    </div>
    @if ($errors->has('from'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('from') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">الى قيمه</span>
        </label>
        <input class="form-control form-control-solid" type="text" name="to" value="{{isset($point) ? $point->to :'' }}" />
    </div>
    @if ($errors->has('to'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('to') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="fs-6 fw-bold mb-2">
            <span class="required">الحاله</span>
        </label>
        <select name="status" aria-label="Select a Country" data-placeholder="اختر الحاله" data-control="select2"  class="form-select form-select-solid fw-bolder companies">
            <option value="">اختر الحاله </option>
            @foreach ($status as $status)
                <option value="{{$status}}" {{isset($point) ?( $status == $point->status ?'selected' : '') : ''}}>{{$status}}</option>
            @endforeach
        </select>
    </div>
    @if ($errors->has('status'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
    @endif
</div>

<div class="modal-footer flex-center">
    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
        <span class="indicator-label">{{isset($point) ? 'تعديل' : 'حفظ'}}</span>
    </button>
</div>
