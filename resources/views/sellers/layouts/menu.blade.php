<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
<div class="app-brand demo">
<a href="{{url('seller-dashboard')}}" class="app-brand-link">
<span class="app-brand-logo demo">
<svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">


<path
fill-rule="evenodd"
clip-rule="evenodd"
d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
fill="#7367F0" />
<path
opacity="0.06"
fill-rule="evenodd"
clip-rule="evenodd"
d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
fill="#161616" />
<path
opacity="0.06"
fill-rule="evenodd"
clip-rule="evenodd"
d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
fill="#161616" />
<path
fill-rule="evenodd"
clip-rule="evenodd"
d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
fill="#7367F0" />
</svg>
</span>
<span class="app-brand-text demo menu-text fw-bold">{{Auth::user()->name}}</span>
</a>

<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
<i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
<i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
</a>
</div>

<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">
<!-- Dashboards -->
<li class="menu-item {{ Request::url() == url('seller-dashboard') ? 'active' : '' }}">
<a href="{{url('seller-dashboard')}}" class="menu-link">
<i class="menu-icon tf-icons ti ti-smart-home"></i>
<div data-i18n="{{__('lang.admin_menu_dashboard')}}">{{__('lang.admin_menu_dashboard')}}</div>
</a>
</li>

<li class="menu-header small text-uppercase">
<span class="menu-header-text" data-i18n="Products">Products</span>
</li>


<li class="menu-item {{ Request::url() == url('sellersproducts') ? 'active' : '' }}" style="">
<a href="javascript:void(0);" class="menu-link menu-toggle">
<i class="tf-icons ti ti-box"></i>
<div data-i18n="Products"> Products</div>
<div class="badge bg-primary rounded-pill ms-auto">2</div>
</a>
<ul class="menu-sub">
<!--order -->
@if (in_array('product', \Helpers::sellergetAssignedPermissions()))
<li class="menu-item {{ Request::url() == url('sellersproducts') ? 'active' : '' }}">
<a href="{{url('sellersproducts')}}" class="menu-link">
<div data-i18n="All Product">All Product</div>
</a>
</li>
@endif
  @if (in_array('coupon', \Helpers::sellergetAssignedPermissions()))
<li class="menu-item {{ Request::url() == url('sellers-coupon') ? 'active' : '' }}">
<a href="{{url('sellers-coupon')}}" class="menu-link">
<div data-i18n="Coupon">Coupons</div>
</a>
</li>
@endif

</ul>
</li>



<li class="menu-header small text-uppercase">
<span class="menu-header-text" data-i18n="Orders">Orders</span>
</li>
 @if (in_array('order', \Helpers::sellergetAssignedPermissions()))
<!--Order -->
<li class="menu-item {{ Request::url() == url('seller-allorders') ? 'active' : '' }}" style="">
<a href="javascript:void(0);" class="menu-link menu-toggle">
<i class="menu-icon tf-icons ti ti-shopping-cart"></i>
<div data-i18n="Orders"> Orders</div>
<div class="badge bg-primary rounded-pill ms-auto">2</div>
</a>
<ul class="menu-sub">
<!--order -->

<li class="menu-item {{ Request::url() == url('seller-allorders') ? 'active' : '' }}">
<a href="{{url('seller-allorders')}}" class="menu-link">
<div data-i18n="All Orders">All Orders</div>
</a>
</li>

<li class="menu-item {{ Request::url() == url('seller-delivered-order') ? 'active' : '' }}">
<a href="{{url('seller-delivered-order')}}" class="menu-link">
<div data-i18n="Delivered Orders">Delivered Orders</div>
</a>
</li>







</ul>
</li>
@endif


<li class="menu-header small text-uppercase">
<span class="menu-header-text" data-i18n="Refund Management">Refund Management</span>
</li>

<!-- Push Notification -->
<li class="menu-item {{ Request::url() == url('seller-refund-request') ? 'active' : '' }}">
<a href="{{url('seller-refund-request')}}" class="menu-link">
<i class="tf-icons ti ti-refresh"></i>
<div data-i18n="Refund Request">Refund Request </div>
</a>
</li>



<li class="menu-header small text-uppercase">
<span class="menu-header-text" data-i18n="Income Management">Income Management</span>
</li>


 @if (in_array('income-management ', \Helpers::sellergetAssignedPermissions()))
<li class="menu-item {{ Request::url() == url('my-income') ? 'active' : '' }}">
<a href="{{url('my-income')}}" class="menu-link">
<i class="menu-icon tf-icons ti ti-wallet"></i>
<div data-i18n="My Income">My Income</div>
</a>
</li>
@endif

<!-- <li class="menu-item {{ Request::url() == url('sellers-withdraw-requests') ? 'active' : '' }}">
<a href="{{url('sellers-withdraw-requests')}}" class="menu-link">
<i class="menu-icon tf-icons ti ti-wallet"></i>
<div data-i18n="Commission History">Commission History</div>
</a>
</li> -->










<li class="menu-header small text-uppercase">
<span class="menu-header-text" data-i18n="Setup ans configuration">Setup ans configuration</span>
</li>

<li class="menu-item {{ Request::url() == url('seller-setting')? 'active' : '' }}" style="">
<a href="javascript:void(0);" class="menu-link menu-toggle">
<i class="menu-icon tf-icons ti ti-settings"></i>
<div data-i18n="{{__('lang.admin_setting')}}">{{__('lang.admin_setting')}}</div>
<div class="badge bg-primary rounded-pill ms-auto">2</div>
</a>
<ul class="menu-sub">
<!-- payment methods -->
@if (in_array('settings', \Helpers::sellergetAssignedPermissions()))
<li class="menu-item {{ Request::url() == url('seller-setting')? 'active' : '' }}">
<a href="{{url('seller-setting')}}" class="menu-link">
<div data-i18n="{{__('lang.admin_all_settings')}}">{{__('lang.admin_all_settings')}}</div>
</a>
</li>
@endif


@if (in_array('shipping-setting', \Helpers::sellergetAssignedPermissions()))
<li class="menu-item {{ Request::url() == url('sellers-shipping-rate-type')? 'active' : '' }}">
<a href="{{url('sellers-shipping-rate-type')}}" class="menu-link">
<div data-i18n="Shipping Setting">Shipping Setting</div>
</a>
</li>
@endif
</ul>
</li>






































</ul>
</aside>
<!-- / Menu -->