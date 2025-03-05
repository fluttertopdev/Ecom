<?php



use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

$defaultCode = Language::where('is_default', '1')->value('code');

$categories = Category::with(['subcategories', 'translations', 'subcategories.translations'])
->where('status', 1)
->get();

$currentLanguage = Session::get('website_locale', App::getLocale());

// Update categories and subcategories with translations
$categories->each(function ($category) use ($currentLanguage) {
// Translate category name
$category->name = $category->translations
->where('language_code', $currentLanguage)
->first()?->name ?? $category->name;

// Translate subcategories' names
$category->subcategories->each(function ($subcategory) use ($currentLanguage) {
$subcategory->name = $subcategory->translations
->where('language_code', $currentLanguage)
->first()?->name ?? $subcategory->name;
});
});
$user_id = Auth::guard('customer')->id();


$headlines = Setting::where('key', 'headline')->get();
$wishlistcount = Wishlist::where('userid', $user_id)->count();


$cartcount = Cart::where('user_id', $user_id)->count();
?>

<body>
<div id="preloader-active">
<div class="preloader d-flex align-items-center justify-content-center">
<div class="preloader-inner position-relative">
<div class="text-center"><img class="mb-10" src="{{asset('front_assets/imgs/template/favicon.svg')}}" alt="Ecom">
<div class="preloader-dots"></div>
</div>
</div>
</div>
</div>
<div class="topbar top-brand-2">
<div class="container-topbar">
<div class="menu-topbar-left d-none d-xl-block">
<ul class="nav-small">

<li><a class="font-xs" style="color:white;" href="{{url('seller-register')}}">{{__('lang.become_a_seller')}}</a></li>
</ul>
</div>
<div class="info-topbar text-center d-none d-xl-block">
<marquee>
@foreach($headlines as $headline)
<a  class="headline-item">
<span class="font-xs color-brand-3">{{ $headline->value }}</span>
</a>
@endforeach
</marquee>
</div>
<?php
$langList = \Helpers::getAllLangList();
$languageCode = Session::get('website_locale', App::getLocale());

if (Session()->has('admin_locale')) {
$langCode = Session()->get('webiste_locale');


}
else {
$langCode = config('app.fallback_locale');
}
?>
<div class="menu-topbar-right"><span class="font-xs color-brand-3">{{__('lang.Need_help_?_Cal_ Us')}}:</span><span class="font-sm-bold color-success"> {{ setting('helpline') }}</span>


@if(setting('multilanguage') == 1)
<div class="dropdown dropdown-language">
<button class="btn dropdown-toggle" id="dropdownPage" type="button" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static"><span class="dropdown-right font-xs color-brand-3">{{ strtoupper($languageCode) }}</span></button>
<ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdownPage" data-bs-popper="static" id="languageDropdown">
@if(count($langList) > 0)
@foreach($langList as $langRow)
<li>
<a class="dropdown-item" data-lang-code="{{ $langRow->code }}" href="javascript:void(0)">
{{ $langRow->name }}
</a>
</li>
@endforeach
@endif
</ul>
</div>
@endif

</div>
</div>
</div>
<header class="header header-container sticky-bar">
<div class="container">
<div class="main-header">
<div class="header-left">
<div class="header-logo"><a href="{{url('/')}}"><img alt="Ecom" src="{{url('uploads/setting/'.setting('logo'))}}"></a></div>
<div class="header-search">
<div class="box-header-search">
<form class="form-search" method="get" action="{{url('search-product')}}">

<div class="box-keysearch">
<input class="form-control font-xs" type="text" name="name" value="{{ request('name') }}" placeholder=" {{__('lang.Search_for_items')}}">
</div>
</form>
</div>
</div>
  <div class="header-nav text-start">
             
              <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
            </div>
<div class="header-shop">
<div class="d-inline-block box-dropdown-cart"><span class="font-lg icon-list icon-account"><span>Account</span></span>
<div class="dropdown-account">
<?php
$user_id = Auth::guard('customer')->user();
?>
<ul>
@if ($user_id)
<li><a href="{{ url('my-account') }}">{{__('lang.Myaccount')}}</a></li>

<li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('lang.Signout')}}</a></li>
<form id="logout-form" action="{{url('user-logout') }}" method="POST" style="display: none;">
@csrf
</form>
@else
<li><a href="{{ url('user-register') }}">{{__('lang.Register')}}</a></li>
<li><a href="{{ url('user-login') }}">{{__('lang.Login')}}</a></li>

@endif
</ul>
</div>
</div>
<a class="font-lg icon-list icon-wishlist" href="{{ url('my-account') }}">
    <span>Wishlist</span>
    @if($wishlistcount > 0)
        <span class="number-item font-xs wishlistCount">{{ $wishlistcount }}</span>
    @else
        <span class="number-item font-xs wishlistCount" style="display: none;">{{ $wishlistcount }}</span>
    @endif
</a>
<a href="{{url('cart-details')}}"><div class="d-inline-block box-dropdown-cart"><span class="font-lg icon-list icon-cart"><span>Cart</span><span class="number-item font-xs cartcount">0</span></span>



</div></a>
</div>
</div>
</div>
</div>
<div class="header-bottom">
<div class="container">


<div class="header-nav d-inline-block">
<nav class="nav-main-menu d-none d-xl-block">
@foreach($categories as $category)
<ul class="main-menu">
<li class="has-children">
<a href="{{ url('product-list/'.$category->slug) }}">
{{ $category->name }}
</a>
@if($category->subcategories->isNotEmpty())
<ul class="sub-menu">
@foreach($category->subcategories as $subcategory)
<li>
<a href="{{ url('product-list-subcategory/'.$subcategory->slug)}}">
{{ $subcategory->name }}
</a>
</li>
@endforeach
</ul>
@endif
</li>
</ul>
@endforeach
</nav>
</div>


</div>
</div>
</header>
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
<div class="mobile-header-wrapper-inner">
<div class="mobile-header-content-area">
<div class="mobile-logo"><a class="d-flex" href="{{url('/')}}"><img alt="Ecom" src="{{url('uploads/setting/'.setting('logo'))}}"></a></div>
<div class="perfect-scroll">
<div class="mobile-menu-wrap mobile-header-border">
    <nav class="mt-15">
        <ul class="mobile-menu font-heading">
            @foreach($categories as $category)
                <li class="has-children">
                    <a href="{{ url('product-list/'.$category->slug) }}">{{ $category->name }}</a>
                    @if($category->subcategories->isNotEmpty())
                        <ul class="sub-menu">
                            @foreach($category->subcategories as $subcategory)
                                <li>
                                    <a href="{{ url('product-list-subcategory/'.$subcategory->slug) }}">
                                        {{ $subcategory->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
</div>

<div class="mobile-account">
<div class="mobile-header-top">
<div class="user-account"><a href="{{url('/')}}"><img src="{{url('uploads/setting/'.setting('logo'))}}" alt="Ecom"></a>
<div class="content">


</div>
</div>
</div>
<ul class="mobile-menu">
    @if(Auth::guard('customer')->check())
        <li><a href="{{ url('my-account') }}">{{__('lang.Myaccount')}}</a></li>
        <li><a onclick="event.preventDefault(); document.getElementById('logout-mobileform').submit();">{{__('lang.Signout')}}</a></li>
        <form id="logout-mobileform" action="{{url('user-logout') }}" method="POST" style="display: none;">
       @csrf
</form>
    @else
        <li><a href="{{ url('user-register') }}">{{__('lang.Register')}}</a></li>
        <li><a href="{{ url('user-login') }}">{{__('lang.Login')}}</a></li>
    @endif
</ul>
</div>

</div>
</div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
// Add event listener to all dropdown items
const dropdownItems = document.querySelectorAll('#languageDropdown .dropdown-item');

dropdownItems.forEach(item => {
item.addEventListener('click', function () {
const langCode = this.getAttribute('data-lang-code');
const targetUrl = `/websitesetlang?lang=${langCode}`;

// Navigate to the constructed URL
window.location.href = targetUrl;
});
});
});
</script>
