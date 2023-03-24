@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">السبب</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="propose" value="{{isset($expenses) ?$expenses->propose :old('propose')}}" />
    </div>
    @if ($errors->has('propose'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('propose') }}</span>
    @endif
    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">المبلغ</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="price" value="{{isset($expenses) ?$expenses->price :old('price')}}" />
    </div>
    @if ($errors->has('price'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('price') }}</span>
    @endif
    <input type="hidden" name="store_id" value="{{$store_id}}"/>

</div>
<div class="modal-footer flex-center">
    <button type="submit"  class="btn btn-primary">
        <span class="indicator-label">{{isset($expenses) ? 'تعديل  ' : 'حفظ'}}</span>
    </button>
</div>

