<div class="table-responsive">
    <table class="table align-items-center table-flush table-data table-bordered text-center" >
        <thead class="thead-light">
            <tr>
                <td valign="middle" height="20" colspan="4" align="center" style="width:200px;background-color: #EBF1DE;">يجب اخيار رقم الشركه ورقم الفئه من هذا الجدول</td>
            </tr>
        <tr>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">رقم الفئه</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">اسم الفئه</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">رقم الشركه</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">اسم الشركه</th>
        </tr>
        </thead>
        <tbody class="thead-light">
            @foreach ($categories as $category)
                @foreach ($category->companies as $company)

                @endforeach
                <tr>
                    <td align="center" >{{$category->id}}</td>
                    <td align="center" >{{$category->name}}</td>
                    <td align="center" >{{$company->id}}</td>
                    <td align="center" >{{$company->name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<tr></tr>
<tr>

</tr>
<tr></tr>
<div class="table-responsive">
    <table class="table align-items-center table-flush table-data table-bordered text-center" >
        <thead class="thead-light">
            <tr>
                <td valign="middle" height="20" colspan="11" align="center" style="width:200px;background-color: #EBF1DE;">يجب التأكد من القيم الى تقوم بأدخالها مع عدم ترك اى قيمه فارغه</td>
            </tr>
            <tr>
                <td valign="middle" height="20" colspan="11" align="center" style="width:200px;background-color: #EBF1DE;">مع مراعاه ان قيم طريقه البيع هى جمله وقطاعى او جمله فقط</td>
            </tr>
            <tr>
                <td valign="middle" height="20" colspan="11" align="center" style="width:200px;background-color: #EBF1DE;">  و قيم حاله المنتج هى تفعيل او حظر</td>
            </tr>
            <tr>
                <td valign="middle" height="20" colspan="11" align="center" style="width:200px;background-color: #EBF1DE;">وان قيم وضع المنتج في قائمه الانتظار  و تفعيل الطلب على المنتج هى نعم او لا</td>
            </tr>
        <tr>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">رقم الشركه</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">رقم الفئه</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">اسم المنتج</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">نوع الوحدة</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">كمية الوحده</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">نوع القطعه الواحده</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">التفاصيل</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">طريقة البيع</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">وضع المنتج في قائمه الانتظار</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;"> حاله المنتج</th>
            <th align="center"  style="width:150px;background-color:#10106f; color: #ffffff;">؟ تفعيل الطلب على المنتج</th>
        </tr>
        </thead>
        <tbody class="thead-light">
        </tbody>
    </table>
</div>
