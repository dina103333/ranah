
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
    </div>
</div>

<div class="menu-item">
    <a class="menu-link  {{ Route::currentRouteName() == 'admin.categories.index'? 'active' : (
        Route::currentRouteName() == 'admin.categories.create' ? 'active' :'') }}"
         href="{{route('admin.categories.index')}}">
        <span class="menu-icon">
            <i class="bi bi-grid fs-3"></i>
        </span>
        <span class="menu-title">الفئات </span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link  {{ Route::currentRouteName() == 'admin.companies.index'? 'active' : '' }}"
         href="{{route('admin.companies.index')}}">
        <span class="menu-icon">
            <i class="bi bi-grid fs-3"></i>
        </span>
        <span class="menu-title">الشركات </span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link  {{ Route::currentRouteName() == 'admin.products.index'? 'active' : '' }}"
         href="{{route('admin.products.index')}}">
        <span class="menu-icon">
            <i class="bi bi-grid fs-3"></i>
        </span>
        <span class="menu-title">المنتجات </span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link "
         href="#">
        <span class="menu-icon">
            <i class="bi bi-grid fs-3"></i>
        </span>
        <span class="menu-title">المخازن </span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link "
         href="#">
        <span class="menu-icon">
            <i class="bi bi-grid fs-3"></i>
        </span>
        <span class="menu-title">السائقين </span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link "
         href="#">
        <span class="menu-icon">
            <i class="bi bi-grid fs-3"></i>
        </span>
        <span class="menu-title">المبيعات </span>
    </a>
</div>
<div class="menu-item">
    <a class="menu-link "
         href="#">
        <span class="menu-icon">
            <i class="bi bi-grid fs-3"></i>
        </span>
        <span class="menu-title">الطلبات </span>
    </a>
</div>


