

@extends('website.layout.app')
@section('content')

<?php
$Symbol = \Helpers::getActiveCurrencySymbol();
?>


<style type="text/css">
.activeheart {
background: #ffffff url("{{ url('/') }}/front_assets/imgs/template/icons/wishlist-hover.svg") no-repeat center !important;


}
.viewbtn {
color: white;
background-color: #FD9636;
transition: background-color 0.3s ease-in-out; /* Smooth transition */
}

.viewbtn:hover {
background-color: #E07F2E; /* Slightly darker shade for hover effect */
}
</style>
<main class="main">
<section class="section-box d-block">
<div class="banner-hero banner-home5 pt-0 pb-0">
<div class="box-swiper">
<div class="swiper-container swiper-group-1">
<div class="swiper-wrapper">
@foreach ($homepagebanners as $bannerlist)
<div class="swiper-slide">

<div class="banner-slide" style="background: url('{{ url('uploads/banner/website_banner/' . $bannerlist->image) }}') no-repeat top center;">
<div class="banner-desc">

<!--<h1 class="color-gray-1000 mb-10">{{$bannerlist->name}}</h1>-->

</div>
</div>

</div>
@endforeach            
</div>
<div class="swiper-pagination swiper-pagination-1"></div>
</div>
</div>
</div>
</section>

<section class="section-box bg-gray-50 mb-50">
<div class="container">
<ul class="list-col-5 list-no-border">
@foreach ($iconsdata as $item)
<li>
<div class="item-list">
<div class="icon-left"><img src="{{ url('uploads/banner/icon/'.$item->icon) }}" alt="Ecom"></div>
<div class="info-right">
<h5 class="font-lg-bold color-gray-100">{{$item->textfield1}}</h5>
<p class="font-sm color-gray-500">{{$item->textfield2}}</p>
</div>
</div>
</li>
@endforeach




</ul>
</div>
</section>
<section class="section-box mt-10">
<div class="container">
<div class="pb-0 head-main text-center border-none">
<h4 class="color-gray-900">{{__('lang.Most_Popular_Categories')}}</h4>
</div>
<div class="mt-10">
<ul class="list-9-col">
@foreach ($categories as $item)
<li class="wow animate__animated animate__fadeIn" data-wow-delay=".0s">
<div class="box-category hover-up">
<!-- Category or Subcategory Image -->
<div class="image">
<!-- Check if the item is a category or subcategory and adjust URL -->
<a href="{{ url((isset($item->category_id) ? 'product-list-subcategory' : 'product-list') . '/' . $item->slug) }}">
<img src="{{ url('uploads/category/'.$item->image) }}" alt="Ecom">
</a>
</div>
<div class="text-info">
<a class="font-sm color-gray-900 font-bold" href="{{ url((isset($item->category_id) ? 'product-list-subcategory' : 'product-list') . '/' . $item->slug) }}">
{{ $item->name }}
</a>
</div>
</div>
</li>
@endforeach
</ul>
</div>       </div>
</section>


@foreach ($Homepagedata as $eachdata)
<!-- First Section for Single Banner -->
@if(!empty($eachdata->single_bannerimg))
<div class="section-box mt-30">
<a href="{{ $eachdata->single_banner_link ?? '#' }}">
<div class="container text-center">
<img class="ads1 wow animate__animated animate__fadeInUp" 
src="{{ url('uploads/banner/website_banner/'.$eachdata->single_bannerimg) }}" 
alt="Genz">
</div>
</a>
</div>
@endif

<!-- Second Section for Multiple Banners -->
@if(!empty($eachdata->combo_bannerimg1) || !empty($eachdata->combo_bannerimg2))
<div class="section-box mt-50">
<div class="container">
<div class="row">
@if(!empty($eachdata->combo_bannerimg1))
<div class="col-lg-6 wow animate__animated animate__fadeInUp">
<a href="{{ $eachdata->combo_banner_link1 ?? '#' }}">
<img class="w-100 hover-up" 
src="{{ url('uploads/banner/website_banner/'.$eachdata->combo_bannerimg1) }}" 
alt="Ecom">
</a>
</div>
@endif
@if(!empty($eachdata->combo_bannerimg2))
<div class="col-lg-6 wow animate__animated animate__fadeInUp">
<a href="{{ $eachdata->combo_banner_link2 ?? '#' }}">
<img class="w-100 hover-up" 
src="{{ url('uploads/banner/website_banner/'.$eachdata->combo_bannerimg2) }}" 
alt="Ecom">
</a>
</div>
@endif
</div>
</div>
</div>
@endif

<!-- Only display the product section if there is no banner information -->
@if(empty($eachdata->single_bannerimg) && empty($eachdata->combo_bannerimg1) && empty($eachdata->combo_bannerimg2))
<section class="section-box mt-30">
<div class="container">
<!-- Loop through each banner -->
<div class="head-main bd-gray-200">
<div class="row">
<div class="col-xl-12 col-lg-12">
<ul class="nav nav-tabs text-start" role="tablist">
<li class="pl-0">

@if($eachdata->section_type == 'Visibilities')
<a href="{{ url('productlist/'.$eachdata->slug) }}"class="active pl-0">
<h4>{{$eachdata->translations->isNotEmpty() ? $eachdata->translations->first()->name : $eachdata->title }}</h4> <!-- Display the tag name (from the banner) -->
</a>
@elseif($eachdata->section_type == 'category')
<a href="{{ url('product-list/'.$eachdata->slug) }}"class="active pl-0">
<h4>{{$eachdata->translations->isNotEmpty() ? $eachdata->translations->first()->name : $eachdata->title }}</h4> <!-- Display the tag name (from the banner) -->
</a>
@endif
</li>
</ul>

<!-- Button slider-->
@if($eachdata->section_type == 'Visibilities')
<div class="box-button-slider">
<div class="button-slider-nav" id="">
<div class="box-button-slider mt-3">
<a href="{{ url('productlist/'.$eachdata->slug) }}">
<button type="button"  class="btn btn-warning viewbtn">View</button>
</a>
</div>
</div>
</div>
@elseif($eachdata->section_type == 'category')
<div class="box-button-slider">
<div class="button-slider-nav" id="">
<div class="box-button-slider mt-3">
<a href="{{ url('product-list/'.$eachdata->categoryslug) }}">
<button type="button" class="btn btn-warning viewbtn">View</button>
</a>
</div>
</div>
</div>
@endif
</div>
</div>
</div>

<!-- Product Section - Only shown if no banner -->
<div class="tab-content tab-content-slider">
<div class="tab-pane fade active show" id="" role="tabpanel" aria-labelledby="">
<div class="box-swiper">
<div class="swiper-container swiper-tab">
<div class="pt-5">
<div class="swiper-slide">
<div class="list-products-5 list-style-brand-2">
@php
// Get visibility, category, and subcategory from the current data
$visibilityId = $eachdata->visibilitieid;
$categoryId = $eachdata->categoryid;  // Assuming categoryid is available
$subcategoryId = $eachdata->subcategoryid;  // Assuming subcategoryid is available

// Get products based on visibility, category, and subcategory
$products = \Helpers::getProducts($visibilityId, $categoryId, $subcategoryId);
@endphp

@foreach($products as $product)

@php
$activeVariant = $product->productVariants->where('status', 1)->first();
$imageArray = $activeVariant && $activeVariant->images ? explode(',', $activeVariant->images) : [];
$firstImage = count($imageArray) > 0 ? $imageArray[0] : null;

$productImage = $firstImage ? url('uploads/' . $firstImage) : url('uploads/product/' . $product->product_image);


$productPrice = $activeVariant ? $activeVariant->price : $product->price;
$discontPrice = $activeVariant ? $activeVariant->price : $product->discount;
$discontcount =  $product->discount;
$variantproductid = $activeVariant ? $activeVariant->id : null;
$rating = $product->averageRating;
$reviewCount = $product->reviewCount ?? 0;

$productdiscountamount = $productPrice * ($product->discount / 100);
$priceafterdiscount=$productPrice- $productdiscountamount;
$totalTax = $each->producttaxprice ?? 0;
@endphp
@php
if (setting('including_tax') == 0) {
$finalPriceWithTax = $priceafterdiscount + $totalTax;
$discountpricewithtax=$productPrice + $totalTax;
} else {
$finalPriceWithTax = $priceafterdiscount;
$discountpricewithtax=$productPrice;
}






@endphp


@php
$isInCart = false;
if (!empty($cartdata)) {
foreach ($cartdata as $cartItem) {
if ($cartItem->product_id == $product->id && $cartItem->variants_id == $variantproductid) {
$isInCart = true;
break;
}
}
}
@endphp


<div class="card-grid-style-3">
<div class="card-grid-inner">
<div class="tools"></div>
<div class="tools">

@php
$isInWishlist = $mywishlistproduct->contains('product_id', $product->id);
@endphp

<div class="tools">
<a class="btn btn-wishlist mb-10 addwishlist {{ $isInWishlist ? 'activeheart' : '' }}"  
data-productvariant_id="{{ $variantproductid }}" 
data-productid="{{ $product->id }}" 
href="#">

</a>
</div>


</div>
<div class="image-box">
<a href="{{ url('product-details/'.$product->slug) }}">
<img width="170px" height="150px;" style="object-fit: contain;" src="{{ $productImage }}" alt="{{ $product->name }}">
</a>
</div>

<div class="info-right">
<a class="font-xs color-gray-500" href="{{ url('product-details/'.$product->slug) }}">{{ $product->brand && $product->brand->translations->isNotEmpty() ? $product->brand->translations->first()->name : $product->brand->name }}</a><br>

<a href="{{ url('product-details/'.$product->slug) }}" class="color-brand-3 font-sm-bold">
    {{ Str::words($product->translations->isNotEmpty() ? $product->translations->first()->name : $product->name, 2, '...') }}
</a>

<div class="rating">
@for ($i = 1; $i <= 5; $i++)
<i class="fa fa-star" style="color: {{ $i <= $rating ? '#FD9636' : '#d3d3d3' }};"></i>
@endfor
<span class="font-xs color-gray-500">({{ $reviewCount }})</span> <!-- Rating number -->
</div>
<div class="price-info">
<strong class="font-lg-bold color-brand-3 price-main" style="margin-right: 1px;">{{$Symbol}}{{ number_format($finalPriceWithTax, 0, '.', ',') }}</strong>
@if(!is_null($discontcount) && $discontcount != 0)
<span class="color-gray-500 price-line">{{$Symbol}}{{ number_format($discountpricewithtax, 0, '.', ',') }}</span> 

<span style="color:#FD9636;">{{round($product->discount)}}%off</span>
@endif
</div>

@if((setting('including_tax') == 0))
<span>Tax Inclusive</span>
@else

<span>Tax Exclusive</span>
@endif

<input class="" type="hidden"value="{{$finalPriceWithTax }}"name="" id="product-price-{{ $product->id }}">
<input class="" type="hidden"value="{{$discountpricewithtax }}"name="" id="product-discount-{{ $product->id }}">
<input class="" type="hidden"value="{{$totalTax }}"name="" id="product-tax-{{ $product->id }}">
<input class="" type="hidden"value="{{$product->created_by }}"name="" id="created_by-{{ $product->id }}">
<div class="mt-20 box-btn-cart">
<a class="btn btn-cart addtocart {{ $isInCart ? 'disabled' : '' }}" 
data-variantproductid="{{ $variantproductid }}" 
data-product_id="{{ $product->id }}" 
data-qty="1" 
href="#" 
@if($isInCart) disabled @endif
style="{{ $isInCart ? 'background-color: #425A8B; color: white; border: none;' : '' }}">
{{ $isInCart ? 'Added to Cart' : 'Add to Cart' }}
</a>
</div>
</div>
</div>
</div>
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
@endif
@endforeach







</main>


@endsection



