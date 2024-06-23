<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">

            <a @if(Session::get('page')=="dashboard" ) style="background:#4B49AC !important;color:#fff !important;" @endif class="nav-link" href="{{ url('admin/dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @if(Auth::guard('admin')->user()->type=="vendor")
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-vendor" aria-expanded="false" aria-controls="ui-vendor">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Vendor Details</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-vendor">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/update-vendor-details/personal')}}">Personal Details</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/update-vendor-details/business')}}">Business Details</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/update-vendor-details/bank')}}">Bank Details</a></li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="sections" || Session::get('page')=="categories" || Session::get('page')=="brands" || Session::get('page')=="products" || Session::get('page')=="filters" || Session::get('page')=="filters-values" ) style="background:#1411c0e7 !important;color:#fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Catalogue Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu" style="background: #8a0d0d73!important; color:#4B49AC!important;">
                    {{-- <li class="nav-item"> <a @if(Session::get('page')=="sections" ) style="background:#18000ae7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/sections')}}">Sections</a>
        </li>
        <li class="nav-item"> <a @if(Session::get('page')=="categories" ) style="background:#c70757e7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/categories')}}">Categories</a></li>
        <li class="nav-item"> <a @if(Session::get('page')=="brands" ) style="background:#550927e7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/brands')}}">Brands</a></li> --}}
        {{-- <li class="nav-item"> <a @if(Session::get('page')=="filters" ) style="background:#fd0a6ce7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/filters')}}">Filters</a></li>
        <li class="nav-item"> <a @if(Session::get('page')=="filters-values" ) style="background:#4b4547e7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/filters-values')}}">Filter Value</a></li> --}}
        <li class="nav-item"> <a @if(Session::get('page')=="products" ) style="background:#502637e7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/products')}}">Products</a></li>
        <li class="nav-item"> <a @if(Session::get('page')=="coupons" ) style="background:#e70f57e7 !important;color:rgb(40, 20, 128) !important;" @endif class="nav-link" href="{{url('admin/coupons')}}">Coupon</a></li>
    </ul>
    </div>
    </li>
    <li class="nav-item">
        <a @if(Session::get('page')=="orders"  ) style="background:#3d3739e7 !important;color:#fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Order Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-orders">
            <ul class="nav flex-column sub-menu" style="background:rgb(207, 181, 30) !important;color:rgb(224, 238, 27) !important; ">
                <li class="nav-item"> <a @if(Session::get('page')=="banners" ) style="background:#eb2b55e7 !important;color:rgb(224, 238, 27)!important;" @endif class="nav-link" href="{{url('admin/orders')}}">Order</a></li>
</ul>
</div>
</li>
    @else
    <li class="nav-item">
        <a @if(Session::get('page')=="update_admin_password" || Session::get('page')=="update_admin_details" ) style="background:#18000ae7 !important;color:#fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-setting" aria-expanded="false" aria-controls="ui-setting">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Setting</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-setting">
            <ul class="nav flex-column sub-menu" style="background:rgb(207, 181, 30) !important;color:rgb(224, 238, 27) !important; ">
                <li class="nav-item"> <a @if(Session::get('page')=="update_admin_password" ) style="background:#eb2b55e7 !important;color:rgb(224, 238, 27)!important;" @endif class="nav-link" href="{{url('admin/update-admin-password')}}">AdminUP Password</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="update_admin_details" ) style="background:#eb2b55e7 !important;color:rgb(224, 238, 27) !important;" @endif class="nav-link" href="{{url('admin/update-admin-details')}}">AdminUP Details</a></li>

            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a @if(Session::get('page')=="view_admins" || Session::get('page')=="view_subadmins" || Session::get('page')=="view_vendors" || Session::get('page')=="view_all" ) style="background:#4e484be7 !important;color:#fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-admin" aria-expanded="false" aria-controls="ui-admin">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Admin Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-admin">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a @if(Session::get('page')=="view_admins" ) style="background:#18000ae7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/admins/admin')}}">Admins</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="view_subadmins" ) style="background:#e0156ae7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/admins/subadmin')}}">Subadmins</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="view_vendors" ) style="background:#1d1dbbe7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/admins/vendor')}}">Vendor</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="view_all" ) style="background:#88073de7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/admins')}}">All</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a @if(Session::get('page')=="sections" || Session::get('page')=="categories" || Session::get('page')=="brands" || Session::get('page')=="products" || Session::get('page')=="filters" || Session::get('page')=="filters-values" || Session::get('page')=="coupons" ) style="background:#1411c0e7 !important;color:#fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Catalogue Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-catalogue">
            <ul class="nav flex-column sub-menu" style="background: #8a0d0d73!important; color:#4B49AC!important;">
                <li class="nav-item"> <a @if(Session::get('page')=="sections" ) style="background:#18000ae7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/sections')}}">Sections</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="categories" ) style="background:#c70757e7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/categories')}}">Categories</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="brands" ) style="background:#550927e7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/brands')}}">Brands</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="products" ) style="background:#502637e7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/products')}}">Products</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="filters" ) style="background:#fd0a6ce7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/filters')}}">Filters</a></li>
                {{-- <li class="nav-item"> <a @if(Session::get('page')=="filters-values" ) style="background:#4b4547e7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/filters-values')}}">Filter Value</a>
    </li> --}}
    <li class="nav-item"> <a @if(Session::get('page')=="coupons" ) style="background:#e70f57e7 !important;color:rgb(40, 20, 128) !important;" @endif class="nav-link" href="{{url('admin/coupons')}}">Coupon</a></li>
    </ul>
    </div>
    </li>

    <li class="nav-item">
        <a @if(Session::get('page')=="banners" ) style="background:#3d3739e7 !important;color:#fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-banners" aria-expanded="false" aria-controls="ui-banners">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Banner</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-banners">
            <ul class="nav flex-column sub-menu" style="background:rgb(207, 181, 30) !important;color:rgb(224, 238, 27) !important; ">
                <li class="nav-item"> <a @if(Session::get('page')=="banners" ) style="background:#eb2b55e7 !important;color:rgb(224, 238, 27)!important;" @endif class="nav-link" href="{{url('admin/banners')}}">Home Page Banner</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a @if(Session::get('page')=="orders" ) style="background:#3d3739e7 !important;color:#fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Order Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-orders">
            <ul class="nav flex-column sub-menu" style="background:rgb(207, 181, 30) !important;color:rgb(224, 238, 27) !important; ">
                <li class="nav-item"> <a @if(Session::get('page')=="banners" ) style="background:#eb2b55e7 !important;color:rgb(224, 238, 27)!important;" @endif class="nav-link" href="{{url('admin/orders')}}">Order</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-user" aria-expanded="false" aria-controls="ui-user">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">User Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-user">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a @if(Session::get('page')=="" ) style="background:#18000ae7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/users')}}">Users</a></li>
                <li class="nav-item"> <a @if(Session::get('page')=="" ) style="background:#18000ae7 !important;color:#fff !important;" @endif class="nav-link" href="{{url('admin/subscribers')}}">Subscribers</a></li>

            </ul>
        </div>
    </li>
    {{-- <div class="collapse" id="brand">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href=" {{url('admin/brands')}}">Brands</a></li>
    </ul>
    </div>
    </li> --}}
    @endif


    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
            <i class="icon-columns menu-icon"></i>
            <span class="menu-title">Form elements</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
            <i class="icon-bar-graph menu-icon"></i>
            <span class="menu-title">Charts</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="charts">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
            <i class="icon-grid-2 menu-icon"></i>
            <span class="menu-title">Tables</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="tables">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
            <i class="icon-contract menu-icon"></i>
            <span class="menu-title">Icons</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="icons">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="icon-head menu-icon"></i>
            <span class="menu-title">User Pages</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
            <i class="icon-ban menu-icon"></i>
            <span class="menu-title">Error pages</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="error">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="pages/documentation/documentation.html">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Documentation</span>
        </a>
    </li>
    </ul>
</nav>
