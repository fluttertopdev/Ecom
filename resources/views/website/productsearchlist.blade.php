

@extends('website.layout.app')
@section('content')

<?php

$segment1 =  Request::segment(2);



$segment2 =  Request::segment(3); 

$Symbol = \Helpers::getActiveCurrencySymbol();
?>
<style>
/* Active page background color */
.pagination .page-item.active .page-link {
background-color: #FD9636; /* Active page background */
}

/* Pagination link background color on hover */
.pagination .page-item .page-link:hover {
background-color: #FD9636; /* Hover background color */
}

/* Custom styles for the price slider */
#price-range-slider {
width: 100%;
height: 10px;
background-color: #f1f1f1;
border-radius: 10px; /* Rounded edges for the slider track */
}

#price-range-slider .ui-slider-range {
background-color: #FD9636; /* Slider color */
border-radius: 10px; /* Rounded edges for the slider range */
}

#price-range-slider .ui-slider-handle {
background-color: #FD9636;
border: 2px solid #ffffff; /* White border for visibility */
width: 25px; /* Increased handle size */
height: 25px; /* Increased handle size */
border-radius: 50%; /* Circular shape for the handle */
cursor: pointer; /* Change cursor to pointer */
}

/* Hover effect to make slider handle more visible */
#price-range-slider .ui-slider-handle:hover {
background-color: #FF8000;
border-color: #ffffff;
}

/* Slider value labels */
.min-value-money, .max-value-money {
font-size: 16px;
font-weight: bold;
}
.activeheart {
background: #ffffff url("{{ url('/') }}/front_assets/imgs/template/icons/wishlist-hover.svg") no-repeat center !important;
}
</style>

<main class="main">

<div class="section-box shop-template mt-30">
<div class="container">

<div class="row">
<div class="col-lg-9 order-last order-lg-last">

<div class="box-filters mt-0 pb-5 border-bottom">
<div class="row">
<div class="col-xl-12 col-lg-12 mb-10 text-lg-end text-center">

<div class="d-inline-flex align-items-center">
<div class="d-inline-block me-2">
<span class="font-sm color-gray-500 font-medium">Sort by:</span>
<div class="dropdown-sort border-1-right">
<form id="" method="GET" action="{{ url('search-product/'.$segment1.'/'.$segment2) }}"> 
<!-- Include other filters as needed -->
<select class="form-select font-sm color-gray-900 font-medium" id="sortOptions" name="sort">
	   <option value="">Select</option>
<option value="latest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'latest') ? 'selected' : '' ?>>Latest products</option>
<option value="oldest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : '' ?>>Oldest products</option>
<option value="low-high" <?= (isset($_GET['sort']) && $_GET['sort'] === 'low-high') ? 'selected' : '' ?>>Price: Low to High</option>
<option value="high-low" <?= (isset($_GET['sort']) && $_GET['sort'] === 'high-low') ? 'selected' : '' ?>>Price: High to Low</option>
</select>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

</div>
</div>


<!-- Smaller buttons for applying and resetting filters -->
<div class="d-inline-block">
<button style="background-color: #FD9636;" class="btn btn-primary btn-sm font-sm  font-medium" id="applyFilter" type="submit">Apply</button>
</div>
<div class="d-inline-block ms-2">
</form>
<a href="{{ url('search-product/'.$segment1.'/'.$segment2) }}"> <button class="btn btn-outline-secondary btn-sm font-sm color-gray-900 font-medium" id="resetFilter" type="submit">Reset</button> </a>
</div>

</div>
</div>
</div>
</div>

<div class="row mt-20">
@if($productlist->isEmpty())
<!-- No products found message -->
<div class="col-12">
<p class="text-center">No products found</p>
</div>
@else
@foreach ($productlist as $each)
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
<div class="card-grid-style-3">
<div class="card-grid-inner">


{{-- Check if product has any active variant --}}
@php
$activeVariant = $each->productVariants->where('status', 1)->first();
$imageArray = $activeVariant && $activeVariant->images ? explode(',', $activeVariant->images) : [];
$firstImage = count($imageArray) > 0 ? $imageArray[0] : null;

$productImage = $firstImage ? url('uploads/' . $firstImage) : url('uploads/product/' . $each->product_image);
$productPrice = $activeVariant ? $activeVariant->price : $each->price;
$discontPrice = $activeVariant ? $activeVariant->price : $each->price + $each->discount;
$discontcount =  $each->discount;
$variantproductid = $activeVariant ? $activeVariant->id : null;
$rating = $each->averageRating;
$reviewCount = $each->reviewCount ?? 0;


$productdiscountamount = $productPrice * ($each->discount / 100);
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
if ($cartItem->product_id == $each->id && $cartItem->variants_id == $variantproductid) {
$isInCart = true;
break;
}
}
}
@endphp
@php
$isInWishlist = $mywishlistproduct->contains('product_id', $each->id);
@endphp

<div class="tools">
<a class="btn btn-wishlist mb-10 addwishlist {{ $isInWishlist ? 'activeheart' : '' }}"  
data-productvariant_id="{{ $variantproductid }}" 
data-productid="{{ $each->id }}" 
href="#">

</a>
</div>
<div class="image-box">
<a href="{{ url('product-details/'.$each->slug.'/'.$each->id) }}">
<img src="{{ $productImage }}" alt="Ecom">
</a>
</div>

<div class="info-right">
<a class="font-xs color-gray-500" href="{{ url('product-details/'.$each->slug.'/'.$each->id) }}">{{$each->brand->name}}</a><br>
<a class="color-brand-3 font-sm-bold" href="{{ url('product-details/'.$each->slug.'/'.$each->id) }}">

{{ Str::words($each->name, 5, '...') }}
</a>

<div class="rating">
@for ($i = 1; $i <= 5; $i++)
<i class="fa fa-star" style="color: {{ $i <= $rating ? '#FD9636' : '#d3d3d3' }};"></i>
@endfor
<span class="font-xs color-gray-500">({{ $reviewCount }})</span> <!-- Rating number -->
</div>

<div class="price-info">
<strong class="font-lg-bold color-brand-3 price-main">{{$Symbol}}{{ number_format($finalPriceWithTax, 2, '.', ',') }}</strong>
@if(!is_null($discontcount) && $discontcount != 0)
<span class="color-gray-500 price-line">{{$Symbol}}{{ number_format($discountpricewithtax, 2, '.', ',') }}</span>
<span style="color:#FD9636;">{{round($each->discount)}}% off</span>
@endif
</div>
<input class="" type="hidden"value="{{$finalPriceWithTax }}"name="" id="product-price-{{ $each->id }}">
<input class="" type="hidden"value="{{$discountpricewithtax }}"name="" id="product-discount-{{ $each->id }}">
<input class="" type="hidden"value="{{$totalTax }}"name="" id="product-tax-{{ $each->id }}">
<input class="" type="hidden"value="{{$each->created_by }}"name="" id="created_by-{{ $each->id }}">

<div class="mt-20 box-btn-cart">
<a class="btn btn-cart addtocart {{ $isInCart ? 'disabled' : '' }}" 
data-variantproductid="{{ $variantproductid }}" 
data-product_id="{{ $each->id }}" 
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
</div>
@endforeach
@endif
</div>                 



@if ($productlist->total() > 0)
<div class="d-flex justify-content-center">
<nav>
<ul class="pagination">
{{-- Previous Page Link --}}
@if ($productlist->onFirstPage())
<li class="page-item disabled">
<a class="page-link page-prev" href="#" tabindex="-1" aria-disabled="true"></a>
</li>
@else
<li class="page-item">
<a class="page-link page-prev" href="{{ $productlist->previousPageUrl() }}"></a>
</li>
@endif

{{-- Page Number Links --}}
@foreach ($productlist->getUrlRange(1, $productlist->lastPage()) as $page => $url)
<li class="page-item {{ $page == $productlist->currentPage() ? 'active' : '' }}">
<a class="page-link" href="{{ $url }}">{{ $page }}</a>
</li>
@endforeach

{{-- Next Page Link --}}
@if ($productlist->hasMorePages())
<li class="page-item">
<a class="page-link page-next" href="{{ $productlist->nextPageUrl() }}"></a>
</li>
@else
<li class="page-item disabled">
<a class="page-link page-next" href="#" tabindex="-1" aria-disabled="true"></a>
</li>
@endif
</ul>
</nav>
</div>
@endif
</div>
<div class="col-lg-3 order-first order-lg-first">
<div class="sidebar-border mb-0">
<div class="sidebar-head">
<h6 class="color-gray-900">Product Categories</h6>
</div>
<div class="sidebar-content">
<ul class="list-nav-arrow">
@foreach ($categories as $each)
<li>
<a href="{{ url('search-product') }}?categoryid={{$each->id}}&name=">
{{$each->name}}
</a>
</li>

@endforeach

</ul>
<div>
<!-- <div class="collapse" id="moreMenu">
<ul class="list-nav-arrow">
<li><a href="shop-grid.html">Home theater<span class="number">98</span></a></li>
<li><a href="shop-grid.html">Cameras & drones<span class="number">124</span></a></li>
<li><a href="shop-grid.html">PC gaming<span class="number">56</span></a></li>
<li><a href="shop-grid.html">Smart home<span class="number">87</span></a></li>
<li><a href="shop-grid.html">Networking<span class="number">36</span></a></li>
</ul>
</div> -->
<!-- <a class="link-see-more mt-5" data-bs-toggle="collapse" href="#moreMenu" role="button" aria-expanded="false" aria-controls="moreMenu">See More</a> -->
</div>
</div>
</div>
<div class="sidebar-border mb-40">
<div class="sidebar-head">
<h6 class="color-gray-900">{{__('lang.Products_Filter')}}</h6>
</div>
<div class="sidebar-content">
<!-- Price Range Filter -->
<h6 class="color-gray-900 mt-10 mb-10">Price range</h6>
<div class="box-slider-range mt-20 mb-15">
<div class="row mb-20">
<div class="col-sm-12">
<!-- Price Range Slider -->
<div id="price-range-slider"></div> 
</div>
</div>
<div class="row">
<div class="col-lg-12">
<span class="min-value-money font-sm color-gray-1000" id="min-price-label"></span> - 
<span class="max-value-money font-sm font-medium color-gray-1000" id="max-price-label"></span>
</div>
<div class="col-lg-12">
<!-- Hidden inputs to store min and max price -->
<input class="form-control min-value" type="hidden" name="min-value" id="min-price" value="{{ isset($_GET['min-value']) ? $_GET['min-value'] : 0 }}">
<input class="form-control max-value" type="hidden" name="max-value" id="max-price" value="{{ isset($_GET['max-value']) ? $_GET['max-value'] : 150000 }}">
</div>
</div>
</div>

<!-- Brand Filter -->
<h6 class="color-gray-900 mt-20 mb-10">{{__('lang.Brands')}}</h6>
<form action="{{ url('search-product/'.$segment1.'/'.$segment2) }}" method="get" id="filter-form">
<!-- Brand dropdown -->
<select class="form-select font-sm color-gray-900 font-medium" id="brand_id" name="brand_id">
<option value="">Select Brand</option>
@foreach ($brand as $each)
<option value="{{ $each->id }}" {{ request('brand_id') == $each->id ? 'selected' : '' }}>
{{ $each->name }}
</option>
@endforeach
</select>

<!-- Price Range (Hidden Inputs) -->
<input type="hidden" name="min-value" id="min-price-hidden" value="{{ isset($_GET['min-value']) ? $_GET['min-value'] : 0 }}">
<input type="hidden" name="max-value" id="max-price-hidden" value="{{ isset($_GET['max-value']) ? $_GET['max-value'] : 150000 }}">

<!-- Buttons (Apply and Reset) -->
<div class="d-flex justify-content-start mt-4">
<!-- Apply Filter Button -->
<button type="submit" class="btn btn-warning" style="background-color:#FD9636; width: auto; margin-right: 10px; color: white;">Apply</button>

<!-- Reset Button -->
<a href="{{ url('search-product') }}">

<button class="btn btn-outline-secondary btn-sm font-sm color-gray-900 font-medium" id="" type="button">Reset</button>
</a>
</div>
</form>
</div>
</div>





</div>
</div>
</div>
</div>




</main>
<script>
// Set default min and max prices from the hidden inputs or from the query parameters
var minPrice = {{ isset($_GET['min-value']) ? $_GET['min-value'] : 0 }};
var maxPrice = {{ isset($_GET['max-value']) ? $_GET['max-value'] : 150000 }}; // Dynamically setting max price
var currencySymbol = "{{ $Symbol }}";  // Get the currency symbol dynamically from PHP

// Initialize the price range slider
$("#price-range-slider").slider({
range: true,
min: 0,
max: 150000,  // Set max price dynamically
values: [minPrice, maxPrice],
slide: function (event, ui) {
$("#min-price-label").text(currencySymbol + ui.values[0]);
$("#max-price-label").text(currencySymbol + ui.values[1]);
$("#min-price").val(ui.values[0]); // Update hidden input for min price
$("#max-price").val(ui.values[1]); // Update hidden input for max price
}
});

// Set initial price values based on the current slider values
$("#min-price-label").text(currencySymbol + minPrice);
$("#max-price-label").text(currencySymbol + maxPrice);

// Update hidden inputs before form submission
$("form").submit(function() {
// This ensures that the form submission includes the correct price range values
$("#min-price-hidden").val($("#min-price").val());
$("#max-price-hidden").val($("#max-price").val());
});

// Ensure the price slider is properly initialized after page load (when the page is refreshed with filter applied)
$(document).ready(function() {
// Manually trigger the slide event to update the labels and hidden input fields
$("#price-range-slider").slider("value", [minPrice, maxPrice]);
});
</script>


@endsection















