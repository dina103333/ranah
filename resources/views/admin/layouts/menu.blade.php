<div class="menu-item">
    <div class="menu-content pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Dashboard</span>
    </div>
</div>
<div class="menu-item">
    <a class="menu-link {{ Route::currentRouteName() == 'admin.dashboard'? 'active' : '' }}"
         href="{{route('admin.dashboard')}}">
        <span class="menu-icon">
            <i class="bi bi-grid fs-3"></i>
        </span>
        <span class="menu-title">لوحه التحكم</span>
    </a>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion
            {{ Route::currentRouteName() == 'admin.officials.index' ? 'hover show' : (
                Route::currentRouteName() == 'admin.create-role' ? 'hover show' : (
         Route::currentRouteName() == 'admin.create-admin' ? 'hover show' : (
            Route::currentRouteName() == 'admin.roles.index'? 'hover show' :'')))}} ">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-archive fs-3"></i>
        </span>
        <span class="menu-title"> المسؤولين</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg
    {{ Route::currentRouteName() == 'admin.officials.index' ? 'show' : (
         Route::currentRouteName() == 'admin.create-role' ? 'show' : (
         Route::currentRouteName() == 'admin.create-admin' ? 'show' : (
            Route::currentRouteName() == 'admin.roles.index'? 'show' :'')))}} ">
        @if(in_array(2,permissions()))
            <div class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.officials.index'? 'active' : (
                    Route::currentRouteName() == 'admin.officials.create' ? 'active' :'') }}"
                    href="{{route('admin.officials.index')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">المسؤولين</span>
                </a>
            </div>
        @endif
        @if(in_array(198,permissions()))
            <div class="menu-item ">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.roles.index'? 'active' :(
                Route::currentRouteName() == 'admin.create-role' ? 'active' : '' )}}"
                href="{{route('admin.roles.index')}}">
                    <span class="menu-icon">
                        <i class="bi bi-person fs-2"></i>
                    </span>
                    <span class="menu-title"> الادوار</span>
                </a>
            </div>
        @endif
    </div>
</div>


<div data-kt-menu-trigger="click" class="menu-item menu-accordion
            {{ Route::currentRouteName() == 'admin.categories.index' ? 'hover show' : (
                Route::currentRouteName() == 'admin.categories.create' ? 'hover show' : (
         Route::currentRouteName() == 'admin.subcategories.index' ? 'hover show' : (
            Route::currentRouteName() == 'admin.subcategories.create'? 'hover show' :'')))}} ">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-archive fs-3"></i>
        </span>
        <span class="menu-title"> الفئات</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg
    {{ Route::currentRouteName() == 'admin.categories.index' ? 'show' : (
         Route::currentRouteName() == 'admin.categories.create' ? 'show' : (
         Route::currentRouteName() == 'admin.subcategories.index' ? 'show' : (
            Route::currentRouteName() == 'admin.subcategories.create'? 'show' :'')))}} ">
        @if(in_array(6,permissions()))
            <div class="menu-item">
                <a class="menu-link  {{ Route::currentRouteName() == 'admin.categories.index'? 'active' : (
                    Route::currentRouteName() == 'admin.categories.create' ? 'active' :'') }}"
                    href="{{route('admin.categories.index')}}">
                    <span class="menu-icon">
                        <i class="bi bi-grid fs-3"></i>
                    </span>
                    <span class="menu-title">الفئات الرئيسيه </span>
                </a>
            </div>
        @endif
        @if(in_array(6,permissions()))
            <div class="menu-item">
                <a class="menu-link  {{ Route::currentRouteName() == 'admin.subcategories.index'? 'active' : (
                    Route::currentRouteName() == 'admin.subcategories.create' ? 'active' :'') }}"
                    href="{{route('admin.subcategories.index')}}">
                    <span class="menu-icon">
                        <i class="bi bi-grid fs-3"></i>
                    </span>
                    <span class="menu-title">الفئات الفرعيه </span>
                </a>
            </div>
        @endif

    </div>
</div>

@if(in_array(10,permissions()))
    <div class="menu-item">
        <a class="menu-link  {{ Route::currentRouteName() == 'admin.companies.index'? 'active' : '' }}"
            href="{{route('admin.companies.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">الشركات </span>
        </a>
    </div>
@endif
@if(in_array(74,permissions()))
    <div class="menu-item">
        <a class="menu-link  {{ Route::currentRouteName() == 'admin.products.index'? 'active' : '' }}"
            href="{{route('admin.products.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">المنتجات </span>
        </a>
    </div>
@endif
@if(in_array(194,permissions()))
    <div class="menu-item">
        <a class="menu-link  {{ Route::currentRouteName() == 'admin.suppliers.index'? 'active' : '' }}"
            href="{{route('admin.suppliers.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">الموردين </span>
        </a>
    </div>
@endif
@if(in_array(79,permissions()))
    <div class="menu-item">
        <a class="menu-link {{ Route::currentRouteName() == 'admin.receipts.index'? 'active' : '' }}"
            href="{{route('admin.receipts.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">فواتير الشراء </span>
        </a>
    </div>
@endif
@if(in_array(91,permissions()))
    <div class="menu-item">
        <a class="menu-link {{ Route::currentRouteName() == 'admin.stores.index'? 'active' : '' }}"
            href="{{route('admin.stores.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">المخازن </span>
        </a>
    </div>
@endif
@if(in_array(34,permissions()))
    <div class="menu-item">
        <a class="menu-link "
            href="{{route('admin.drivers.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">السائقين </span>
        </a>
    </div>
@endif
@if(in_array(187,permissions()))
    <div class="menu-item">
        <a class="menu-link "
            href="{{route('admin.sellers.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">المبيعات </span>
        </a>
    </div>
@endif
@if(in_array(70,permissions()))
    <div class="menu-item">
        <a class="menu-link {{ Route::currentRouteName() == 'admin.areas.index'? 'active' : '' }} "
            href="{{route('admin.areas.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">المناطق </span>
        </a>
    </div>
@endif
@if(in_array(159,permissions()))
    <div class="menu-item">
        <a class="menu-link {{ Route::currentRouteName() == 'admin.shops.index'? 'active' : '' }} "
            href="{{route('admin.shops.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">انواع المحلات </span>
        </a>
    </div>
@endif
@if(in_array(99,permissions()))
    <div class="menu-item">
        <a class="menu-link {{ Route::currentRouteName() == 'admin.users.index'? 'active' : '' }} "
            href="{{route('admin.users.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">العملاء</span>
        </a>
    </div>
@endif
@if(in_array(62,permissions()))
    <div class="menu-item">
        <a class="menu-link {{ Route::currentRouteName() == 'admin.orders.index'? 'active' : '' }} "
            href="{{route('admin.orders.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">الطلبات </span>
        </a>
    </div>
@endif
@if(in_array(119,permissions()))
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion
                {{ Route::currentRouteName() == 'admin.discountproducts.index' ? 'hover show' : (
                    Route::currentRouteName() == 'admin.discountproducts.create' ? 'hover show' : (
            Route::currentRouteName() == 'admin.promos.index' ? 'hover show' : (
            Route::currentRouteName() == 'admin.points.index' ? 'hover show' : (
                Route::currentRouteName() == 'admin.promos.create'? 'hover show' :''))))}} ">
        <span class="menu-link">
            <span class="menu-icon">
                <i class="bi bi-archive fs-3"></i>
            </span>
            <span class="menu-title"> الخصومات</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg
            {{ Route::currentRouteName() == 'admin.discountproducts.index' ? 'show' : (
                Route::currentRouteName() == 'admin.discountproducts.create' ? 'show' : (
                Route::currentRouteName() == 'admin.promos.index' ? 'show' : (
                Route::currentRouteName() == 'admin.points.index' ? 'show' : (
                Route::currentRouteName() == 'admin.promos.create'? 'show' :''))))}} ">
            {{-- <div class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.discounts.index'? 'active' : (
                    Route::currentRouteName() == 'admin.discounts.create' ? 'active' :'') }}"
                    href="{{route('admin.discounts.index')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">خصومات الفواتير</span>
                </a>
            </div> --}}
            <div class="menu-item ">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.discountproducts.index'? 'active' :(
                Route::currentRouteName() == 'admin.discountproducts.index' ? 'active' : '' )}}"
                href="{{route('admin.discountproducts.index')}}">
                    <span class="menu-icon">
                        <i class="bi bi-person fs-2"></i>
                    </span>
                    <span class="menu-title"> خصومات المنتجات</span>
                </a>
            </div>
            <div class="menu-item ">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.promos.index'? 'active' :(
                Route::currentRouteName() == 'admin.promos.index' ? 'active' : '' )}}"
                href="{{route('admin.promos.index')}}">
                    <span class="menu-icon">
                        <i class="bi bi-person fs-2"></i>
                    </span>
                    <span class="menu-title">كوبونات الخصم</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.points.index'? 'active' : '' }} "
                    href="{{route('admin.points.index')}}">
                    <span class="menu-icon">
                        <i class="bi bi-grid fs-3"></i>
                    </span>
                    <span class="menu-title">النقاط </span>
                </a>
            </div>
        </div>
    </div>
@endif
@if(in_array(54,permissions()))
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion
                {{ Route::currentRouteName() == 'admin.notifications.index' ? 'hover show' : (
                    Route::currentRouteName() == 'admin.notifications.create' ? 'hover show' : (
            Route::currentRouteName() == 'admin.sms.index' ? 'hover show' : (
            Route::currentRouteName() == 'admin.sms.create' ? 'hover show' : '')))}} ">
        <span class="menu-link">
            <span class="menu-icon">
                <i class="bi bi-archive fs-3"></i>
            </span>
            <span class="menu-title"> الاشعارات</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg
            {{ Route::currentRouteName() == 'admin.notifications.index' ? 'show' : (
                Route::currentRouteName() == 'admin.discountproducts.create' ? 'show' : (
                Route::currentRouteName() == 'admin.sms.index' ? 'show' : (
                Route::currentRouteName() == 'admin.sms.create' ? 'show' : '')))}} ">

            <div class="menu-item {{ Route::currentRouteName() == 'admin.notifications.index'? 'active' : '' }}">
                <a class="menu-link"
                    href="{{route('admin.notifications.index')}}">
                    <span class="menu-icon">
                        <i class="bi bi-grid fs-3"></i>
                    </span>
                    <span class="menu-title">الاشعارات </span>
                </a>
            </div>
            <div class="menu-item {{ Route::currentRouteName() == 'admin.sms.index'? 'active' : '' }}">
                <a class="menu-link"
                    href="{{route('admin.sms.index')}}">
                    <span class="menu-icon">
                        <i class="bi bi-grid fs-3"></i>
                    </span>
                    <span class="menu-title">الرسائل النصيه </span>
                </a>
            </div>
        </div>
    </div>
@endif

@if(in_array(87,permissions()))
    <div class="menu-item">
        <a class="menu-link {{ Route::currentRouteName() == 'admin.sliders.index'? 'active' : '' }} "
            href="{{route('admin.sliders.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">اسليدرز </span>
        </a>
    </div>
@endif

<div data-kt-menu-trigger="click" class="menu-item menu-accordion
            {{ Route::currentRouteName() == 'admin.complaints.index' ? 'hover show' : (
                Route::currentRouteName() == 'admin.product-complaints' ? 'hover show' :'')}} ">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-archive fs-3"></i>
        </span>
        <span class="menu-title"> الشكاوى</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg
        {{ Route::currentRouteName() == 'admin.complaints.index' ? 'show' : (
            Route::currentRouteName() == 'admin.product-complaints' ? 'show' :'')}} ">
        @if(in_array(18,permissions()))
            <div class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.complaints.index'? 'active' : (
                    Route::currentRouteName() == 'admin.complaints.create' ? 'active' :'') }}"
                    href="{{route('admin.complaints.index')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">الشكاوى العامه</span>
                </a>
            </div>
        @endif
        @if(in_array(14,permissions()))
            <div class="menu-item ">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.product-complaints'? 'active' :(
                Route::currentRouteName() == 'admin.product-complaints' ? 'active' : '' )}}"
                href="{{route('admin.product-complaints')}}">
                    <span class="menu-icon">
                        <i class="bi bi-person fs-2"></i>
                    </span>
                    <span class="menu-title"> شكاوى المنتجات</span>
                </a>
            </div>
        @endif
    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion
            {{ Route::currentRouteName() == 'admin.best-selling' ? 'hover show' : (
                Route::currentRouteName() == 'admin.best-selling' ? 'hover show' : (
                Route::currentRouteName() == 'admin.product-products' ? 'hover show' :''))}} ">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="bi bi-archive fs-3"></i>
        </span>
        <span class="menu-title"> التقارير</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg
        {{ Route::currentRouteName() == 'admin.best-selling' ? 'show' : (
            Route::currentRouteName() == 'admin.product-products' ? 'show' :'')}} ">
            <div class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.best-selling'? 'active' : (
                    Route::currentRouteName() == 'best-selling' ? 'active' :'') }}"
                    href="{{route('admin.best-selling')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">المنتجات الاكثر مبيعا</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.product-products'? 'active' : (
                    Route::currentRouteName() == 'admin.product-products' ? 'active' :'') }}"
                    href="{{route('admin.product-products')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">اجمالى الطلبات ع المنتجات</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.earning-store'? 'active' : (
                    Route::currentRouteName() == 'admin.earning-store' ? 'active' :'') }}"
                    href="{{route('admin.earning-store')}}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">صافى ارباح المخازن</span>
                </a>
            </div>
    </div>
</div>


@if(auth()->user()->type == 'المسؤول العام')
    <div class="menu-item">
        <a class="menu-link {{ Route::currentRouteName() == 'admin.contacts.index'? 'active' : '' }} "
            href="{{route('admin.contacts.index')}}">
            <span class="menu-icon">
                <i class="bi bi-grid fs-3"></i>
            </span>
            <span class="menu-title">ارقام التواصل </span>
        </a>
    </div>
@endif

