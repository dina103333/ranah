@csrf
<div class="modal-body py-10 px-lg-17" >
    <div class="fv-row mb-7">
        <label class="required fs-6 fw-bold mb-2">الاسم</label>
        <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{isset($role) ? $role->name :' '}}" />
    </div>
    @if ($errors->has('name'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('name') }}</span>
    @endif

    <div id="kt_modal_add_customer_billing_info" class="collapse show">
        <div class="d-flex flex-column mb-7 fv-row">
            <label class="fs-6 fw-bold mb-2">
                <span class="required">الحاله</span>
            </label>
            <select name="status" aria-label="Select a Country" data-placeholder="اختر الحاله" data-control="select2"  class="form-select form-select-solid fw-bolder">
                <option value="">اختر الحاله </option>
                @foreach ($status as $status)
                    <option value="{{$status}}" {{isset($role) ?( $status == $role->status ?'selected' : '') : ''}}>{{$status}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($errors->has('status'))
        <span style="color: red;margin-bottom: 17px;display: block;">{{ $errors->first('status') }}</span>
    @endif
    <div class="fv-row mb-7" >
        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr class="text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">المجموعه</th>
                    <th class="min-w-125px"> اسم الصلاحيه</th>
                </tr>
            </thead>
            <tbody class="fw-bold text-gray-600">
                <tr>
                    <td></td>
                    <td>
                        <input style="margin-right: 10px;" type="checkbox" onclick="CheckAll('check',this)" name="check" class="check_all">  اخيار الكل
                    </td>
                </tr>
                @foreach($groups as $group)
                    <tr>
                        <td>
                            {{$group->group}}
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-12">
                                    @foreach ($permissions as $permission)
                                        @if($group->id == $permission->group_id)

                                            <span >
                                                <input style="margin-right: 10px;" type="checkbox"
                                                {{isset($role) ? (in_array($permission->id,$role_permissions) ? 'checked' : 'not in') : ''}}
                                                 name="permissions[]" value="{{$permission->id}}"
                                                 class="check">  {{$permission->dispaly_name_ar}}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer flex-center">
    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
        <span class="indicator-label">{{isset($role) ? 'تعديل' : 'حفظ'}}</span>
    </button>
</div>

