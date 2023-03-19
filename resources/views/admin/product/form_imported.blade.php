@csrf
<div class="d-flex" style="justify-content: center;margin-top: 16px;">
    <div class="custom-file text-left" style="margin-left:10px">
        <input type="file" name="excel_file" class="form-control" id="customFile">
    </div>
<a href="{{route('admin.export-template')}}" class="btn btn-success">export</a>
</div>
<div class="modal-footer flex-center">
    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
        <span class="indicator-label">{{isset($product) ? 'تعديل' : 'حفظ'}}</span>
    </button>
</div>
