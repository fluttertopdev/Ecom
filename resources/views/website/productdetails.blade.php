    
@extends('website.layout.app')
@section('content')
<?php
$baseUrl = url()->current();
$Symbol = \Helpers::getActiveCurrencySymbol();
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<style>
    .color-box {
        width: 40px; /* Adjust as needed */
        height: 40px; /* Adjust as needed */
        display: inline-block;
        margin: 5px;
        border: 2px solid transparent; /* Default border */
        cursor: pointer;
        transition: border 0.3s ease;
    }


    .color-box.active {
        border: 5px solid blue; /* Border for active color */
    }
      .item-thumb {
        cursor: pointer; /* This will change the cursor to a pointer when hovering */
    }
    
    .star-rating .star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s;
    }
    .star-rating .star.selected,
    .star-rating .star:hover,
    .star-rating .star:hover ~ .star {
        color: #f39c12;
    }
    #addreview {
    transition: all 0.3s ease;
}

  .seller-rate {
        position: relative;
        font-size: 1rem;
        line-height: 1;
    }

    .seller-rate .seller-rating {
        height: 1rem;
        width: 100%;
     
        background-size: 100% 100%;
        background-clip: content-box;
        overflow: hidden;
        position: absolute;
        top: 0;
        left: 0;
        white-space: nowrap;
        color: #ffc107;
    }

    .seller-rate:before {
        content: '★★★★★';
        font-family: 'Font Awesome 5 Free'; /* Ensure Font Awesome is loaded */
        font-weight: 900;
          color: #e4e5e9;
        color: #e4e5e9;
    }

    .seller-rate .seller-rating:before {
        content: '★★★★★';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: #ffc107;
    }


    .product-image-slider {
    display: flex;
    align-items: center;  /* Center image vertically */
    justify-content: center; /* Center image horizontally */
    min-height: 400px; /* Ensures the gallery height remains fixed */
    max-height: 400px;
    overflow: hidden;
}

.product-image-slider figure {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%; /* Ensures full height usage */
}

.product-image-slider figure img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain; /* Ensures image remains within box without cropping */
}

  .product-image-slider {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        max-height: 400px;
        overflow: hidden;
        position: relative;
    }
    .product-image-slider figure {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        position: relative;
    }
    .product-image-slider figure img {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
        transition: transform 0.3s ease-in-out;
    }
    .product-image-slider figure img:hover {
        transform: scale(1.5); /* Zoom effect */
        cursor: zoom-in;
    }
   
    .item-thumb img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.3s;
    }
    .item-thumb img:hover, .item-thumb.active img {
/*        border-color: #000;*/
    }
  .activeheart {
    background: #ffffff url("{{ url('/') }}/front_assets/imgs/template/icons/wishlist-hover.svg") no-repeat center !important;
}
</style>
    <main class="main">
      <div class="section-box">
        <div class="breadcrumbs-div">
          <div class="container">
            <ul class="breadcrumb">
              <li><a class="font-xs color-gray-1000" href="{{'/'}}">Home</a></li>
           <li><a class="font-xs color-gray-500" href="{{ url('/') }}">{{ ucwords(str_replace('-', ' ', $productDetails->category->name)) }}</a></li>
        
            
              <li><a class="font-xs color-gray-500" href="{{ url('/') }}">{{ ucwords(str_replace('-', ' ', $productDetails->subcategory->name)) }}</a></li>
            
            </ul>
          </div>
        </div>
      </div>
      <section class="section-box shop-template">
        <div class="container  mb-40 mt-40" style="min-height:550px;">
          <div class="row">
            <div class="col-lg-5">
              <div class="gallery-image">

            
                <?php
if ($product_variantsid !== null && $productDetails->id == $product_variantsid->product_id) {
?>
    <div class="galleries">
        <div class="detail-gallery">
            
            <div class="product-image-slider">
                @foreach ($variantimages as $image)
                    <figure class="border-radius-10"><img src="{{ url('uploads/'. trim($image)) }}" style="width:200px;" alt="product image"></figure>
                @endforeach
            </div>
        </div>
        <div class="slider-nav-thumbnails">
            @foreach ($variantimages as $image)
                <div>
                    <div class="item-thumb"><img src="{{ url('uploads/'. trim($image)) }}" alt="product image"></div>
                </div>
            @endforeach
        </div>
    </div>

<?php
} else {
?>
    <div class="galleries">
        <div class="detail-gallery">
            
            <div class="product-image-slider">
                @foreach ($product_images as $images)
                    <figure class="border-radius-10"><img src="{{ url('uploads/product/'.$images->image) }}" alt="product image"></figure>
                @endforeach
            </div>
        </div>
        <div class="slider-nav-thumbnails">
            @foreach ($product_images as $images)
                <div>
                    <div class="item-thumb"><img src="{{ url('uploads/product/'.$images->image) }}" alt="product image"></div>
                </div>
            @endforeach
        </div>
    </div>
<?php
}
?>


                


              </div>
            </div>
            <div class="col-lg-7">
              <h3 class="color-brand-3 mb-25">{{$productDetails->name}}</h3>
                 <div class="row align-items-center">
                <div class="col-lg-4 col-md-4 col-sm-3 mb-mobile"><span class="bytext color-gray-500 font-xs font-medium">Brand</span><a class="byAUthor color-gray-900 font-xs font-medium">: {{$productDetails->brand->name}}</a>
                  <div class="rating mt-5">
                        @for($i = 1; $i <= 5; $i++)
                       <i class="fas fa-star" style="color: {{ $i <= floor($averageRating) ? '#FD9636;' : 'gray' }}"></i>
                         @endfor
                   
                      <span class="font-xs color-gray-500 font-medium">({{$totalReviews}} reviews)</span>
                      </div>
                </div>
@php
$isInWishlist = $mywishlistproduct->contains('product_id', $productDetails->id);
@endphp
   @php
$isInWishlist = $mywishlistproduct->contains('product_id', $productDetails->id);
@endphp

<div class="col-lg-8 col-md-8 col-sm-9 text-start text-sm-end">
    <a class="mr-20">
        <span class="btn btn-wishlist addwishlist mr-5 opacity-100 transform-none {{ $isInWishlist ? 'activeheart' : '' }}"  
              data-productvariant_id="{{ $activevariants ? $activevariants->id : '' }}" 
              data-productid="{{ $productDetails->id }}">
        </span>

        
    </a>
</div>

              </div>
              
              
   <input type="hidden" value="{{$productDetails->id}}" name="product_id">
              <div class="border-bottom pt-10 mb-20"></div>
              <div class="box-product-price">
<?php
if ($product_variantsid !== null && $productDetails->id == $product_variantsid->product_id) {
                            $productdiscountamount = $activevariants->price * ($productDetails->discount / 100);
                           $priceafterdiscount=$activevariants->price - $productdiscountamount;
                   
                             $totalTax = $productDetails->producttaxprice ?? 0;
                            
                            
                            if((setting('including_tax') == 0)){
                                $finalPriceWithTax = $priceafterdiscount + $totalTax;  
                                 $discountpricewithtax=$activevariants->price + $totalTax;
                            }else{
                                $finalPriceWithTax = $priceafterdiscount;  
                                 $discountpricewithtax=$activevariants->price;
                            }
                             
     
    echo '<h3 class="color-brand-3 d-inline-block mr-10" id="product-price-' . $productDetails->id . '" >' . $Symbol . number_format((float)$finalPriceWithTax, 2, '.', ',') . '</h3>';

    
    
} else {
    
                           $taxRates = $productDetails->taxRates;
                            $priceafterdiscount=$productDetails->price - $productDetails->discountamount;
                            
                         
                             
                              $totalTax = $productDetails->producttaxprice ?? 0;

                            
                             
                        if((setting('including_tax') == 0)){
                     $finalPriceWithTax = $priceafterdiscount + $totalTax;
                      $discountpricewithtax=$productDetails->price + $totalTax;
                     }else{
                    $finalPriceWithTax =$priceafterdiscount;  
                    $discountpricewithtax=$productDetails->price;
                     }
                     
                      
   echo '<h3 class="color-brand-3 d-inline-block mr-10" id="product-price-' . $productDetails->id . '" >' . $Symbol . number_format((float)$finalPriceWithTax, 2, '.', ',') . '</h3>';


}
?>
               
<?php
if ($product_variantsid !== null && $productDetails->id == $product_variantsid->product_id) {
 
 if (!empty($productDetails->discount) && $productDetails->discount > 0) {
       echo '<span style=" font-size: 20px;" class="color-gray-500 price-line price-main font-xl line-througt ">'.$Symbol.'' . number_format((float) $discountpricewithtax, 0, '.', ',') . '</span>';
               echo '<span class="" style="color:#FD9636; font-size: 20px; margin-left: 5px;">' .$productDetails->discount . '% off</span>';
}

      echo '<input type="hidden" class="product-discount" value="' . $discountpricewithtax . '">'; 
      
  


     
} else {
    if ($productDetails->discount !== null && $productDetails->discount != 0) {
          $finalPricewithdiscount = $productDetails->discountamount + $priceafterdiscount;
        echo '<span class="color-gray-500 price-line price-main font-xl line-througt ">'.$Symbol.'' . number_format((float) $discountpricewithtax, 0, '.', ',') .  '</span>';
          echo '<input type="hidden" class="product-discount" value="' . round((float)$discountpricewithtax) . '">'; 
             echo '<span class="" style="color:#FD9636; font-size: 20px; margin-left: 5px;">' .$productDetails->discount . '% off</span>';
    }
}
?>


               

              </div>
              <div class="product-description mt-20 color-gray-900">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <ul class="list-dot">
                      <?php echo $productDetails->short_des ?>
                    </ul>
                
                </div>
              </div>
       @if ($product_variantsid && $productDetails->id == $product_variantsid->product_id)
       <input type="hidden" class="variant_id productvariantid" value="{{$activevariants->id}}" name="">
    <div class="box-product-color mt-20">
        <p class="font-sm color-gray-900">
            <span class="color-brand-2 nameStyle">
                @php
                    $seenNames = [];
                @endphp
                @foreach ($product_variantscolor as $each)
                    @if (!in_array($each->name, $seenNames))
                        {{ $each->name }}@php $seenNames[] = $each->name; @endphp
                        @if (!$loop->last && count($seenNames) < count($product_variantscolor)), @endif
                    @endif
                @endforeach
            </span>
        </p>

        <ul class="list-colors">
            @foreach ($product_variantscolor as $index => $each)
                <li class="color-box {{ $index === 0 ? 'active' : '' }}" 
                    style="background-color: {{ $each->color_inputs }};" 
                    data-text="{{ $each->text_inputs }}">
                </li>
            @endforeach
        </ul>
    </div>        

    <div class="box-product-style-size mt-20">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-20">
                <p class="font-sm color-gray-900">
                    <span class="color-brand-2 ">
                        @php
                            $seenNames = [];
                        @endphp
                        @foreach ($product_variantsother as $each)
                            @if (!in_array($each->name, $seenNames))
                                {{ $each->name }}@php $seenNames[] = $each->name; @endphp
                                @if (!$loop->last && count($seenNames) < count($product_variantsother)), @endif
                            @endif
                        @endforeach
                    </span>
                </p>
                <ul class="list-styles">
                    @foreach ($product_variantsother as $index => $each)
                        <li class="style-option {{ $index === 0 ? 'active' : '' }}" 
                            title="{{ $each->text_inputs }}" 
                            data-text="{{ $each->text_inputs }}">
                            {{ $each->text_inputs }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

 <input class="" type="hidden"value="{{$totalTax }}"name="" id="product-tax-{{ $productDetails->id }}">
              <div class="buy-product mt-30">
                <p class="font-sm mb-20">Quantity</p>
                <div class="box-quantity">
                  <div class="input-quantity">
                    <input class="font-xl color-brand-3 qty" type="text"  value="1"><span class="minus-cart"></span><span class="plus-cart"></span>
                  
                  </div>
                  <div class="button-buy"><a class="btn btn-cart add_to_cart"data-product_id="{{$productDetails->id}}"  data-created_by="{{$productDetails->created_by}}" href="#">Add to cart</a>
                  
                  <a id="buyNowBtn" class="btn btn-buy " href="{{ url('checkout/'.$productDetails->slug).'?productid='.$productDetails->id }}">Buy now</a>
                  </div>
                </div>
              </div>
              <div class="info-product mt-40">
                <div class="row align-items-end">
                  <div class="col-lg-4 col-md-4 mb-20">
                     <!--<span class="font-sm font-medium color-gray-900">Brand:-->

                     <!-- <span class="color-gray-500 ">{{$productDetails->brand->name}}</span> -->


                    <!--<br>Category:<span class="color-gray-500">{{$productDetails->subcategory->name}}</span>-->

                  </div>
                  <!-- <div class="col-lg-4 col-md-4 mb-20"><span class="font-sm font-medium color-gray-900">Free Delivery<br><span class="color-gray-500">Available for all locations.</span><br><span class="color-gray-500">Delivery Options & Info</span></span></div> -->
                  <div class="col-lg-4 col-md-4 mb-20 text-start text-md-end">
                    <div class="d-inline-block">
    <div class="share-link">
        <span class="font-md-bold color-brand-3 mr-15">Share</span>
        <a class="facebook hover-up" href="https://www.facebook.com/sharer/sharer.php?u={{$baseUrl}}" target="_blank"></a>
        <a class="twitter hover-up" href="https://twitter.com/intent/tweet?url={{$baseUrl}}" target="_blank" target="_blank"></a>
        <a class="instagram hover-up" href="https://www.instagram.com/?url={{$baseUrl}}" target="_blank"></a>
    </div>
</div>

                  </div>
                </div>
              </div>
            </div>
          </div>
            
        </div>
      </section>
      <section class="section-box shop-template">
        <div class="container">
          <div class="pt-30 mb-10">
            <ul class="nav nav-tabs nav-tabs-product" role="tablist">
              <li><a class="active" href="#tab-description" data-bs-toggle="tab" role="tab" aria-controls="tab-description" aria-selected="true">Description</a></li>
              <li><a href="#tab-specification" data-bs-toggle="tab" role="tab" aria-controls="tab-specification" aria-selected="true">Specification</a></li>
              
              <li><a href="#tab-reviews" data-bs-toggle="tab" role="tab" aria-controls="tab-reviews" aria-selected="true">Reviews ({{$totalReviews}})</a></li>
              <li><a href="#tab-vendor" data-bs-toggle="tab" role="tab" aria-controls="tab-vendor" aria-selected="true">Vendor</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade active show" id="tab-description" role="tabpanel" aria-labelledby="tab-description">
                <div class="display-text-short">
                  <p><?php echo $productDetails->description?></p>
               </div>
                 <?php if (str_word_count(strip_tags($productDetails->description)) > 240): ?>
        <div class="mt-20 text-center">
            <a class="btn btn-border font-sm-bold pl-80 pr-80 btn-expand-more">More Details</a>
        </div>
    <?php endif; ?>
              </div>
              <div class="tab-pane fade" id="tab-specification" role="tabpanel" aria-labelledby="tab-specification">
                <h5 class="mb-25">Specification</h5>
                <div class="table-responsive">
                  <table class="table table-striped" style="max-width:500px;">
                      @foreach ($attributesdata as $each)
                    <tr>
                      <td>{{$each->name}}</td>
                      <td>{{$each->attributes_value}}</td>
                    </tr>
                    @endforeach
                    
                  

                  </table>
                </div>
              </div>
              
              <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews">
                <div class="comments-area">
                  <div class="row">
                    <div class="col-lg-8">
                      <h4 class="mb-30 title-question">Customer Reviews</h4>
<div class="comment-list">
    @foreach ($reviewsDetails as $each)
        <div class="single-comment justify-content-between d-flex mb-30 hover-up">
            <div class="user justify-content-between d-flex">
                <div class="thumb text-center">
                    <a class="font-heading text-brand" href="#">{{$each->user->name}}</a>
                </div>
                <div class="desc">
                    <div class="d-flex justify-content-between mb-10">
                        <div class="d-flex align-items-center">
                            <span class="font-xs color-gray-700">{{$each->created_at->format('d F Y')}}</span>
                        </div>
                        <div class="rating">
                            @php
                                $rating = $each->rating ?? 0; // Fallback to 0 if rating is null
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating)
                                    <i class="fas fa-star" style="color: #FD9636;"></i>  <!-- Filled star -->
                                @else
                                    <i class="far fa-star" style="color: #FD9636;"></i>  <!-- Empty star -->
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="mb-10 font-sm color-gray-900">
                        {{$each->review}}
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
                    </div>
   <div class="col-lg-4">
    <h4 class="mb-30 title-question">Customer reviews</h4>
    
    <!-- Dynamic Star Rating -->
    <div class="d-flex mb-30">
        <div class="rating" style="margin-right: 10px;">
            @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star" style="color: {{ $i <= floor($averageRating) ? '#FD9636;' : 'gray' }}"></i>
            @endfor
        </div>
     
        <!--<h6>{{ number_format($averageRating) }} out of 5</h6>-->
    </div>

    <!-- Dynamic Progress Bars for Each Rating (1-5) -->
    @foreach(range(5, 1) as $star)
        <div class="progress mb-2">
            <!-- Add a label for the star rating -->
            <div class="d-flex justify-content-between">
                <span>{{ $star }} star</span>
                <span>{{ $totalReviews > 0 ? round(($starCounts[$star] / $totalReviews) * 100) . '%' : '0%' }}</span>
            </div>
            
            <div class="progress-bar" role="progressbar" style="width: {{ $totalReviews > 0 ? ($starCounts[$star] / $totalReviews) * 100 : 0 }}%" aria-valuenow="{{ $totalReviews > 0 ? ($starCounts[$star] / $totalReviews) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100">
                <!-- Empty space for progress bar -->
            </div>
        </div>
    @endforeach

    @if(!empty($orderDetailsid))
        @if(empty($reviewsDetailsid) || $reviewsDetailsid->status != 1)
            <div class="d-flex justify-content-end mt-4">
                <button 
                    type="button" 
                    class="btn btn-primary px-4 py-2 rounded-pill shadow-sm" 
                    id="addproductreview" 
                    style="font-size: 1rem; font-weight: 600; text-transform: uppercase; background-color: #FD9636; border: none; color: #fff;">
                    <i class="fa fa-edit me-2"></i> Write Review
                </button>
            </div>
        @endif
    @endif
</div>

                
   </div>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-vendor" role="tabpanel" aria-labelledby="tab-vendor">
                <div class="vendor-logo d-flex mb-30"><img src="assets/imgs/page/product/futur.png" alt="">
                  <div class="vendor-name ml-15">
                    <h6><a href="#">{{$productDetails->user_name }}</a></h6>
                    
                    
                    <div class="seller-rate-cover text-end">
              <div class="seller-rate d-inline-block">
        <div class="seller-rating" style="width: {{ ($sellerAverageRating / 5) * 100 }}%;"></div>
    </div>
    <span class="font-small ml-5 text-muted"> 
        ({{ $totalSellerReviews }} reviews)
    </span>
</div>
                    
                  </div>
                </div>
                   @if($productDetails->created_by==1)
             
                <p class="font-sm color-gray-500 mb-15">
                      {{ setting('description') }}     
                </p>
                 @else
                 {{$productDetails->user_description }}
                 @endif
              </div>
              
             
              
              
            </div>
          </div>
        </div>
      </section>

    
      


     
    </main>




    
<div class="modal fade" id="addreviewmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple modal-add-new-cc">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6"></div>
                <div class="modal-body">
                    <form id="add-review-form" action="{{ url('save-review') }}" method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="font-md-bold color-brand-3 mt-15 mb-20">Write Review</h5>
                            </div>
                        </div>

                        <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                      

                        <!-- Star Rating Section -->
                        <div class="col-lg-12 mb-4 text-center">
                            <div class="star-rating" id="star-rating">
                                <input type="hidden" name="rating" id="rating-value" value="0">
                                <i class="star fa fa-star" data-value="1"></i>
                                <i class="star fa fa-star" data-value="2"></i>
                                <i class="star fa fa-star" data-value="3"></i>
                                <i class="star fa fa-star" data-value="4"></i>
                                <i class="star fa fa-star" data-value="5"></i>
                            </div>
                        </div>

                        <!-- Review Input -->
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control font-sm" name="review" placeholder="Review" required></textarea>
                                <div class="invalid-feedback">Please write a review.</div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-buy w-auto">Save</button>
                            <button type="reset" class="btn btn-buy w-auto btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorBoxes = document.querySelectorAll('.color-box');
        const styleOptions = document.querySelectorAll('.style-option');
        const priceElement = document.querySelector('.price-main'); // Get the price element
        const skuElement = document.querySelector('.SKU');
        colorBoxes.forEach(box => {
            box.addEventListener('click', function() {
                // Remove 'active' class from all boxes and add to clicked
                colorBoxes.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const clickedColor = this.getAttribute('data-text');
                const activeStyles = Array.from(styleOptions)
                    .filter(option => option.classList.contains('active'))
                    .map(option => option.getAttribute('data-text'));

                // Send data to the controller
                sendDataToController(clickedColor, activeStyles);
            });
        });

        styleOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove 'active' class from all options and add to clicked
                styleOptions.forEach(o => o.classList.remove('active'));
                this.classList.add('active');

                const clickedStyle = this.getAttribute('data-text');
                const activeColors = Array.from(colorBoxes)
                    .filter(box => box.classList.contains('active'))
                    .map(box => box.getAttribute('data-text'));

                // Send data to the controller
                sendDataToController(activeColors, clickedStyle);
            });
        });

        function sendDataToController(color, styles) {
            const formData = new FormData();
            formData.append('selectedColor', Array.isArray(color) ? color : [color]);
            formData.append('activeStyles', Array.isArray(styles) ? styles : [styles]);

            fetch('{{ url("chnage-product-variant") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token if using Laravel
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                
                // Update the price if a new price is returned
                if (data.price) {
                    priceElement.textContent = `₹${data.price}`; // Update the price display
                }

                 if (data.sku) {
                    skuElement.textContent = `${data.sku}`; // Update the price display
                }

                
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    });
</script> -->







<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorBoxes = document.querySelectorAll('.color-box');
        const styleOptions = document.querySelectorAll('.style-option');
        const priceElement = document.querySelector('.price-main'); // Get the price element
   
       const specialprice = document.querySelector('.specialprice');
      const variantid = document.querySelector('.variant_id');
        const productIdInput = document.querySelector('input[name="product_id"]');
        
           const mainImageSlider = document.querySelector('.product-image-slider');
        const thumbnailSlider = document.querySelector('.slider-nav-thumbnails');
         const buyNowButton = document.querySelector('.btn-buy'); // Get the Buy Now button

      function updateImages(images) {
    // Clear existing images in the sliders
    mainImageSlider.innerHTML = '';
    thumbnailSlider.innerHTML = '';

    const baseUrl = window.location.origin + '/uploads/';

    images.forEach((image, index) => {
        const fullImageUrl = `${baseUrl}${image}`;

        // Create and append thumbnail
        const thumbnailDiv = document.createElement('div');
        const itemThumb = document.createElement('div');
        itemThumb.classList.add('item-thumb');
        itemThumb.innerHTML = `<img src="${fullImageUrl}" alt="product image">`;

        // Attach click event to change main image
        itemThumb.addEventListener('click', function () {
            mainImageSlider.innerHTML = ''; // Clear previous images
            const newFigure = document.createElement('figure');
            newFigure.classList.add('border-radius-10');

            // Set image with styles
            const newImage = document.createElement('img');
            newImage.src = fullImageUrl;
            newImage.alt = 'product image';
            newImage.style.maxWidth = '100%';
            newImage.style.maxHeight = '400px';
            newImage.style.objectFit = 'contain'; // Prevents cropping
            newImage.style.display = 'block';
            newImage.style.margin = 'auto';

            newFigure.appendChild(newImage);
            mainImageSlider.appendChild(newFigure);
        });

        // Append thumbnail to the thumbnail slider
        thumbnailDiv.appendChild(itemThumb);
        thumbnailSlider.appendChild(thumbnailDiv);

        // Set the first image as the default in the main slider
        if (index === 0) {
            const firstFigure = document.createElement('figure');
            firstFigure.classList.add('border-radius-10');

            // Set image with styles
            const firstImage = document.createElement('img');
            firstImage.src = fullImageUrl;
            firstImage.alt = 'product image';
            firstImage.style.maxWidth = '100%';
            firstImage.style.maxHeight = '400px';
            firstImage.style.objectFit = 'contain';
            firstImage.style.display = 'block';
            firstImage.style.margin = 'auto';

            firstFigure.appendChild(firstImage);
            mainImageSlider.appendChild(firstFigure);
        }
    });
}
        colorBoxes.forEach(box => {
            box.addEventListener('click', function() {
                // Remove 'active' class from all boxes and add to clicked
                colorBoxes.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const clickedColor = this.getAttribute('data-text');
                const activeStyles = Array.from(styleOptions)
                    .filter(option => option.classList.contains('active'))
                    .map(option => option.getAttribute('data-text'));

                // Send data to the controller
                sendDataToController(clickedColor, activeStyles);
            });
        });

        styleOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove 'active' class from all options and add to clicked
                styleOptions.forEach(o => o.classList.remove('active'));
                this.classList.add('active');

                const clickedStyle = this.getAttribute('data-text');
                const activeColors = Array.from(colorBoxes)
                    .filter(box => box.classList.contains('active'))
                    .map(box => box.getAttribute('data-text'));

                // Send data to the controller
                sendDataToController(activeColors, clickedStyle);
            });
        });

        function sendDataToController(color, styles) {
            const formData = new FormData();
            formData.append('selectedColor', Array.isArray(color) ? color : [color]);
            formData.append('activeStyles', Array.isArray(styles) ? styles : [styles]);
             formData.append('product_id', productIdInput.value);

            fetch('{{ url("chnage-product-variant") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token if using Laravel
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                
               // Update the price only if the price element exists
    if (data.price && priceElement) {
        priceElement.textContent = `₹${data.price}`;
    }

    // Update special price only if the element exists
    if (data.specialprice && specialprice) {
        specialprice.textContent = `₹${data.specialprice}`;
    }
               
              if (data.id) {
    variantid.value = `${data.id}`; // Update the value of the input field
}

  if (data.id) {
                // Dynamically update the Buy Now button URL
           const updatedUrl = `{{ url('checkout/' . $productDetails->slug) }}?variant_id=${data.id}`;
                buyNowButton.setAttribute('href', updatedUrl);
            }

         if (data.images && data.images.length > 0) {
                updateImages(data.images); // Call the function to update images
            }
                
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).on('click', '#addproductreview', function(){
      

        $('#addreviewmodal').modal('show'); 
     
        
       
    });

    
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingValue = document.getElementById('rating-value');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                ratingValue.value = value;

                // Highlight selected stars
                stars.forEach(s => s.classList.remove('selected'));
                this.classList.add('selected');
                let prev = this.previousElementSibling;
                while (prev) {
                    prev.classList.add('selected');
                    prev = prev.previousElementSibling;
                }
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("add-review-form");
    const reviewTextarea = form.querySelector("textarea[name='review']");

    // Form submission validation
    form.addEventListener("submit", function (e) {
        let isValid = true;

        // Validate review textarea
        if (reviewTextarea.value.trim() === "") {
            reviewTextarea.classList.add("is-invalid");
            isValid = false;
        } else {
            reviewTextarea.classList.remove("is-invalid");
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
        }
    });

    // Reset invalid state on input
    reviewTextarea.addEventListener("input", function () {
        if (reviewTextarea.value.trim() !== "") {
            reviewTextarea.classList.remove("is-invalid");
        }
    });
});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const qtyInput = document.querySelector(".qty");
        const buyNowBtn = document.getElementById("buyNowBtn");

        buyNowBtn.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent immediate navigation

            // Validate quantity input
            const qtyValue = qtyInput.value.trim();
            if (!qtyValue || isNaN(qtyValue) || qtyValue <= 0) {
                alert("Please enter a valid quantity.");
                return;
            }

            // Get required values dynamically
            const productId = "{{ $productDetails->id }}";
            const productVariantId = document.querySelector(".productvariantid")?.value;

            // Fetch the current URL of the button dynamically
            const currentHref = buyNowBtn.getAttribute("href");

            // AJAX request to validate quantity
            fetch("{{ url('validate-quantity') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // Include CSRF token for Laravel
                },
                body: JSON.stringify({
                    qty: qtyValue,
                    productId: productId,
                    productVariantId: productVariantId
                })
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.type === "success") {
                        // Update the button URL dynamically and redirect
                        const updatedHref = `${currentHref}&qty=${encodeURIComponent(qtyValue)}`;
                        window.location.href = updatedHref;
                    } else {
                        // Display error message
                       toastr.warning("insufficient stock");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Something went wrong. Please try again.");
                });
        });
    });
</script>

 @endsection





