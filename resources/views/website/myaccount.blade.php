<style>
    
    /* Custom styles for SweetAlert */
.swal2-popup {
    width: 400px;  /* Default width for desktop */
    font-size: 18px;  /* Default font size */
    padding: 20px;
}

/* On smaller screens (like mobile), make SweetAlert smaller */
@media only screen and (max-width: 768px) {
    .swal2-popup {
        width: 90%;  /* Make the modal take up most of the screen on mobile */
        font-size: 14px;  /* Smaller font size on mobile */
        padding: 15px;  /* Less padding for mobile */
    }

    .swal2-title {
        font-size: 16px; /* Smaller title font size on mobile */
    }

    .swal2-text {
        font-size: 14px; /* Smaller text size */
    }

    .swal2-confirm {
        font-size: 14px; /* Smaller confirm button text */
    }
}

</style>
   @extends('website.layout.app')
    @section('content')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
 @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: true,
            confirmButtonColor: '#FD9636',
            customClass: {
                popup: 'custom-popup'
            }
        });
    </script>
@endif

<style type="text/css">
  .address-container {
    margin-top: 15px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }


  .address-details-container {
    display: flex;
  }

  .address-label {
    display: flex;
    align-items: flex-start;
    cursor: pointer;
  }

  .address-radio {
    margin-right: 10px;
    margin-top: 5px;
  }

  .address-details {
    display: flex;
    flex-direction: column;
  }

  .name-phone {
    display: flex;
    align-items: center;
  }

  .address-name {
    font-weight: bold;
    margin-right: 10px;
  }

  .address-phone {
    color: #333;
  }

  .address-text {
    margin-top: 5px;
    color: #666;
  }

  .address-text strong {
    font-weight: bold;
  }

  .font-md-bold {
    font-weight: bold;
    font-size: 16px;
  }

  .mt-15 {
    margin-top: 15px;
  }

  .mb-20 {
    margin-bottom: 20px;
  }

  .color-brand-3 {
    color: #333;
  }

  .edit-delete-buttons {
    display: flex;
    align-items: center;
  }

  .edit-delete-buttons button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    color: #007bff;
    font-size: 14px;
    margin-left: 10px;
    transition: color 0.3s;
  }

  .edit-delete-buttons button:hover {
    color: #0056b3;
  }
  .no-data {
    text-align: center;

    margin-top: 20px;
}

.nav-tabs .nav-link {
        color: #555;
        transition: all 0.3s ease;
        border: none;
        border-bottom: 2px solid transparent;
    }
    .nav-tabs .nav-link:hover {
        color: #007bff;
        border-bottom: 2px solid #007bff;
    }
    .nav-tabs .nav-link.active {
        color: #007bff;
        border-bottom: 2px solid #007bff;
        background: none;
    }
    
    
    
    /*for order list*/
  /* For mobile, stack all items vertically */
@media (max-width: 768px) {
  .box-orders {
    display: flex;
    flex-direction: column;
    padding: 15px;
  }

  .item-orders {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 15px;
  }

  .image-orders {
    margin-bottom: 10px;
  }

  .info-orders {
    width: 100%;
  }

  .info-orders h5,
  .info-orders p {
    margin-bottom: 8px;
  }

  .price-orders {
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .head-right {
    margin-top: 10px;
  }
}

/* Ensure images are responsive */
.order-image {
  width: 80px;
  height: auto;
  object-fit: cover;
  border-radius: 5px;
}
  


</style>



<?php
$Symbol = \Helpers::getActiveCurrencySymbol();
?>

    <main class="main">
      <section class="section-box shop-template mt-30">
        <div class="container box-account-template mb-40 mt-40" style="min-height:550px;">
          <h3>Hello {{$userinfo->name}}</h3>
          <p class="font-md color-gray-500">From your account dashboard. you can easily check & view your recent orders,<br class="d-none d-lg-block">manage your shipping and billing addresses and edit your password and account details.</p>
          <div class="box-tabs mb-100">
          <ul class="nav nav-tabs nav-tabs-account" role="tablist">
    <li><a class="nav-link active" id="tab-wishlist-link" href="#tab-wishlist" data-bs-toggle="tab" role="tab" aria-controls="tab-wishlist" aria-selected="true">{{__('lang.Wishlist')}}</a></li>
    <li><a class="nav-link" id="tab-orders-link" href="#tab-orders" data-bs-toggle="tab" role="tab" aria-controls="tab-orders" aria-selected="false">{{__('lang.Order')}}</a></li>
   
    <li><a class="nav-link" id="tab-setting-link" href="#tab-setting" data-bs-toggle="tab" role="tab" aria-controls="tab-setting" aria-selected="false">{{__('lang.Setting')}}</a></li>
    <li><a class="nav-link" id="tab-shipping-link" href="#tab-shipping" data-bs-toggle="tab" role="tab" aria-controls="tab-shipping" aria-selected="false">{{__('lang.Shipping')}}</a></li>
</ul>
            <div class="border-bottom mt-20 mb-40"></div>
            <div class="tab-content mt-30">
              

              <div class="tab-pane fade active show" id="tab-wishlist" role="tabpanel">
                <div class="box-wishlist">
                  <div class="head-wishlist">
                    <div class="item-wishlist">
                      <div class="wishlist-cb">
                        
                      </div>
                      <div class="wishlist-product"><span class="font-md-bold color-brand-3">{{__('lang.Product')}}</span></div>
                      <div class="wishlist-price"><span class="font-md-bold color-brand-3">{{__('lang.Price')}}</span></div>
                      <div class="wishlist-status"><span class="font-md-bold color-brand-3">{{__('lang.Stockstatus')}}</span></div>
                      <div class="wishlist-action"><span class="font-md-bold color-brand-3">{{__('lang.Action')}}</span></div>
                      <div class="wishlist-remove"><span class="font-md-bold color-brand-3">{{__('lang.Remove')}}</span></div>
                    </div>
                  </div>
                  <div class="content-wishlist">
                       @if($mywishlistproduct->isNotEmpty())
                         @foreach ($mywishlistproduct as $product)
                    <div class="item-wishlist">
                      <div class="wishlist-cb">
                       
                      </div>
                       @php
        $firstImage = null;

        // Case 1: If the product has no price, fetch image from productVariantValue
        if (($product->product->variant_id)) {
            // Split the images string by commas and get the first image
            $images = explode(',', $product->productVariantValue->images);
            $firstImage = $images[0]; // Get the first image

            // If you want to prepend the 'uploads/' folder for productVariantValue images
            $firstImage = 'uploads/' . $firstImage; // Add the folder path for productVariantValue images
        }
        // Case 2: If the product has a price, fetch the default image from product_images
        else {
            // Check if there are default images associated with the product
            if ($product->product->product_images->isNotEmpty()) {
                // Get the first default image
                $firstImage = $product->product->product_images->first()->image; // Assuming 'image' is the column name for the image path

                // Add the folder path for product_images images
                $firstImage = 'uploads/product/' . $firstImage; // Add the folder path for product_images images
            }
        }
        
        
    @endphp
    
    @if($product->productVariantValue)
    @php
        $productPrice = $product->productVariantValue->price;
        $productdiscountPrice = $product->productVariantValue->price;
    @endphp
@else
    @php
        $productPrice = $product->product->price; 
         $productdiscountPrice = $product->product->discount + $product->product->price;
    @endphp
@endif
                      
                         @php
                           $productdiscountamount = $productPrice * ($product->product->discount / 100);
                              $priceafterdiscount=$productPrice- $productdiscountamount;
                           
                           
                        $taxRates = $product->product->taxRates; // Assuming a relationship exists in the Product model
                            $totalTax = 0;
                            
                                 foreach ($taxRates as $taxRate) {
                                if ($taxRate->ratetype === 'percentage') {
                                    $totalTax += ($priceafterdiscount * $taxRate->rate) / 100;
                                } elseif ($taxRate->ratetype === 'flat') {
                                    $totalTax += $taxRate->rate;
                                }
                            }
                            
                                      if (setting('including_tax') == 0) {
                                  $finalPriceWithTax = $priceafterdiscount + $totalTax;
                                  $discountpricewithtax=$productPrice + $totalTax;
                                     } else {
                              $finalPriceWithTax = $priceafterdiscount;
                              $discountpricewithtax=$productPrice;
                              }
                            @endphp
                      <div class="wishlist-product">
                        <div class="product-wishlist">
                          <div class="product-image"><a href="{{ url('product-details/'.$product->product->slug) }}">
                              
                            
                               @if($firstImage)
        <img src="{{ url($firstImage) }}" alt="{{ $product->product->name }}" style="width: 50px; height: auto;">
    @else
        <p>No image available</p>
    @endif
                              
                              </div>
                    <div class="product-info">
    <a href="{{ url('product-details/'.$product->product->slug) }}">
        <h5 style="color:#425A8B;">{{ $product->product->name }}</h5>
        <p style="color:#425A8B;">{{ $product->productVariantValue->color_variant ?? '' }}</p>
        <p style="color:#425A8B;">{{ $product->productVariantValue->text_variant ?? '' }}</p>
    </a>
</div>
                        </div>
                      </div>
                      
                      
                      <div class="wishlist-price">
                        <h4>@if($product->productVariantValue)
                    {{$Symbol}}{{$Symbol}}{{ number_format($finalPriceWithTax, 0, '.', ',') }}
                     <input class="productvarintasid" type="hidden"value="{{$product->productVariantValue->id}}"name="" id="">
                      <input class="productprice" type="hidden"value="{{$finalPriceWithTax}}"name="">
                @else
                    {{$Symbol}}{{ number_format($finalPriceWithTax, 0, '.', ',') }}
                    
                     <input class="productprice" type="hidden"value="{{$finalPriceWithTax}}"name="" id="">
                @endif</h4>
                
                  <input class="" type="hidden"value="{{$product->product->created_by}}"name="" id="createdby">
                      </div>
                      @if($product->productVariantValue)
    @if($product->productVariantValue->qty > 0)
        <div class="wishlist-status">
            <span class="btn btn-gray font-md-bold color-brand-3">{{__('lang.InStock')}}</span>
        </div>
    @else
        <div class="wishlist-status">
            <span class="btn btn-gray font-md-bold color-brand-3">{{__('lang.OutofStock')}}</span>
        </div>
    @endif
@else
    @if($product->product->qty > 0)
        <div class="wishlist-status">
            <span class="btn btn-gray font-md-bold color-brand-3">{{__('lang.InStock')}}</span>
        </div>
    @else
        <div class="wishlist-status">
            <span class="btn btn-gray font-md-bold color-brand-3">{{__('lang.OutofStock')}}</span>
        </div>
    @endif
@endif

                            <input class="" type="hidden"value="{{$discountpricewithtax }}"name="" id="product-discount-{{$product->product->id }}">
                              <input class="" type="hidden"value="{{$totalTax }}"name="" id="product-tax-{{$product->product->id }}">

            <div class="wishlist-action"><a class="btn btn-cart font-sm-bold addtocartwishlist" data-product_id="{{$product->product->id}}" data-qty="1">{{__('lang.Addtocart')}}</a></div>
                      <div class="wishlist-remove "><a class="btn btn-delete delete-wishlist-btn "  data-id="{{ $product->id }}"></a></div>
                    </div>
                    @endforeach
                    
                  
 @else
        <div class="no-data">
          <span class="text-center">No  Wishlist found</span>
           
        </div>
    @endif

                    


                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="tab-orders" role="tabpanel">
  @if($myorders->isNotEmpty())
    @foreach ($myorders as $product)
    <div class="box-orders">
      <div class="head-orders">
        <div class="head-left">
          <h5 class="mr-20">{{__('lang.OrderID')}}: {{ $product->order_key }}</h5>
          <span class="font-md color-brand-3 mr-20">Date: {{ $product->created_at->format('d F Y') }}</span>
        </div>
      </div>

      <div class="body-orders">
        <div class="list-orders">
          <div class="item-orders">
            <div class="image-orders">
              @php
                $firstImage = null;
                // Case 1: If the product has no price, fetch image from productVariantValue
                if (($product->product->variant_id)) {
                    $images = explode(',', $product->productVariantValue->images);
                    $firstImage = $images[0]; 
                    $firstImage = 'uploads/' . $firstImage; 
                }
                // Case 2: If the product has a price, fetch the default image from product_images
                else {
                    if ($product->product->product_images->isNotEmpty()) {
                        $firstImage = $product->product->product_images->first()->image; 
                        $firstImage = 'uploads/product/' . $firstImage; 
                    }
                }
              @endphp
              @if($firstImage)
                <img src="{{ url($firstImage) }}" alt="{{ $product->product->name }}" class="order-image">
              @else
                <p>No image available</p>
              @endif
            </div>

            <div class="info-orders">
              <h5>{{ $product->product->name }}</h5>
              <p>{{ $product->productVariantValue->color_variant ?? '' }}</p>
              <p>{{ $product->productVariantValue->text_variant ?? '' }}</p>
            </div>

            <div class="quantity-orders">
              <h5>{{__('lang.Quantity')}}: {{ $product->order_quantity }}</h5>
            </div>

            <div class="quantity-orders">
              <h5>{{ $product->order_key }}</h5>
            </div>

 <div class="quantity-orders">
  <span class="label-delivery" 
        style="margin-left: 20px; 
               background-color: {{ $product->status === 'delivered' ? 'green' : '#FD9636' }}; 
               color: white; 
               
               border-radius: 4px;">
    {{ ucwords($product->status) }}
  </span>
</div>


            <!-- Move the price below the status -->
            <div class="price-orders">
              <h5>@if($product->productVariantValue)
                {{$Symbol}}{{ number_format($product->order_total, 0, '.', ',') }}
              @else
                {{$Symbol}}{{ number_format($product->order_total, 0, '.', ',') }}
              @endif</h5>
            </div>

            <!-- Adjust the "View" button to be below the price -->
            <div class="head-right">
              <a href="{{ url('user-orderdetails/'.$product->id) }}" class="btn btn-buy font-sm-bold w-auto">{{__('lang.View')}}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  @else
    <div class="no-orders text-center" style="padding: 50px;">
      <p class="font-md color-brand-3">You haven’t placed any orders yet!</p>
    </div>
  @endif
</div>

              <div class="tab-pane fade" id="tab-order-tracking" role="tabpanel" >
                <p class="font-md color-gray-600">To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on<br class="d-none d-lg-block">your receipt and in the confirmation email you should have received.</p>
                <div class="row mt-30">
                  <div class="col-lg-6">
                    <div class="form-tracking">
                      <form action="#" method="get">
                        <div class="d-flex">
                          <div class="form-group box-input">
                            <input class="form-control" type="text" placeholder="FDSFWRFAF13585">
                          </div>
                          <div class="form-group box-button">
                            <button class="btn btn-buy font-md-bold" type="submit">Tracking Now</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="border-bottom mb-20 mt-20"></div>
                <h3 class="mb-10">Order Status:<span class="color-success">International shipping</span></h3>
                <h6 class="color-gray-500">Estimated Delivery Date: 27 August - 29 August</h6>
                <div class="table-responsive">
                  <div class="list-steps">
                    <div class="item-step">
                      <div class="rounded-step">
                        <div class="icon-step step-1 active"></div>
                        <h6 class="mb-5">Order Placed</h6>
                        <p class="font-md color-gray-500">15 August 2022</p>
                      </div>
                    </div>
                    <div class="item-step">
                      <div class="rounded-step">
                        <div class="icon-step step-2 active"></div>
                        <h6 class="mb-5">In Producttion</h6>
                        <p class="font-md color-gray-500">16 August 2022</p>
                      </div>
                    </div>
                    <div class="item-step">
                      <div class="rounded-step">
                        <div class="icon-step step-3 active"></div>
                        <h6 class="mb-5">International shipping</h6>
                        <p class="font-md color-gray-500">17 August 2022</p>
                      </div>
                    </div>
                    <div class="item-step">
                      <div class="rounded-step">
                        <div class="icon-step step-4"></div>
                        <h6 class="mb-5">Shipping Final Mile</h6>
                        <p class="font-md color-gray-500">18 August 2022</p>
                      </div>
                    </div>
                    <div class="item-step">
                      <div class="rounded-step">
                        <div class="icon-step step-5"></div>
                        <h6 class="mb-5">Delivered</h6>
                        <p class="font-md color-gray-500">19 August 2022</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="list-features">
                  <ul>
                    <li>09:10 25 August 2022: Delivery in progress</li>
                    <li>08:25 25 August 2022: The order has arrived at warehouse 05-YBI Marvel LM Hub</li>
                    <li>05:44 25 August 2022: Order has been shipped</li>
                    <li>04:51 25 August 2022: The order has arrived at Marvel SOC warehouse</li>
                    <li>20:54 18 August 2022: Order has been shipped</li>
                    <li>18:21 17 August 2022: The order has arrived at Marvel SOC warehouse</li>
                    <li>17:09 17 August 2022: Order has been shipped</li>
                    <li>15:23 17 August 2022: The order has arrived at warehouse 20-HNI Marvel 2 SOC</li>
                    <li>12:42 16 August 2022: Successful pick up</li>
                    <li>10:44 15 August 2022: The sender is preparing the goods</li>
                  </ul>
                </div>
                <h3>Package Location</h3>
                <div class="map-account">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193548.25784139088!2d-74.12251055507726!3d40.71380001554004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2zVGjDoG5oIHBo4buRIE5ldyBZb3JrLCBUaeG7g3UgYmFuZyBOZXcgWW9yaywgSG9hIEvhu7M!5e0!3m2!1svi!2s!4v1664974174994!5m2!1svi!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <p class="color-gray-500 mb-20">Maecenas porttitor augue sit amet nibh venenatis bibendum. Morbi lorem elit, fringilla quis libero vitae, tincidunt commodo purus. Quisque diam nisi, tincidunt sed vehicula nec, fermentum vitae lectus. Curabitur sit amet sagittis libero. Pellentesque cursus turpis at ipsum luctus tempor.</p>
                  </div>
                  <div class="col-lg-6">
                    <p class="color-gray-500 mb-20">Ut auctor varius nisl, scelerisque dictum justo maximus ut. Fusce rhoncus, augue sed molestie consectetur, leo felis ultricies erat, nec lobortis enim dui eu justo. Pellentesque aliquam hendrerit venenatis. Integer efficitur bibendum lectus sed sollicitudin. Suspendisse faucibus posuere euismod.</p>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="tab-setting" role="tabpanel">
                <div class="row">
                  <div class="col-lg-6 mb-20">
                    <form action="{{url('update-my-account')}}" method="post">
                      @csrf
                      <div class="row">
                        <div class="col-lg-12 mb-20">
                          <h5 class="font-md-bold color-brand-3 text-sm-start ">{{__('lang.Personalinformation')}}</h5>
                        </div>
 
                        <div class="col-lg-12">
                          <div class="form-group">
                            <input class="form-control font-sm" value="{{$userinfo->name}}" type="text" name="name" placeholder="{{__('lang.Full_Name')}}*" required>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="form-group">
                            <input class="form-control font-sm" value="{{$userinfo->email}}" type="text" name="email" placeholder="{{__('lang.Email')}}*" required>
                          </div>
                        </div>
                        <div class="col-lg-12">
                        <div class="form-group">
    <input class="form-control font-sm" 
           value="{{$userinfo->phone}}" 
           type="text" 
           name="phone"  
           oninput="this.value = this.value.replace(/\D/g, '').slice(0, 12);" 
           pattern="[0-9]{10}" 
           placeholder="{{__('lang.Phone')}}" 
           required>
</div>

                        </div>
                        <div class="col-lg-12">
                          <div class="form-group">
                            <input class="form-control font-sm"  maxlength="8" name="password" value="" type="text" placeholder="{{__('lang.Password')}}">
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="form-group mt-20">
                            <input type="submit" class="btn btn-buy w-auto h54 font-md-bold" value="{{__('lang.Update')}}">
                          </div>
                        </div>

                       </form>
                     
                      </div>
            
                  </div>
                 
                </div>
              </div>

              

              <div class="tab-pane fade" id="tab-shipping" role="tabpanel">
                <div class="row">
                <div class="row">
  <div class="col-lg-12">
    <h5 class="font-md-bold color-brand-3 mt-15 mb-20">{{__('lang.Shipping_Address')}}</h5>
  </div>
  @if($deliveryadress->isNotEmpty())
  @foreach ($deliveryadress as $eachdata)
  <div class="col-lg-12 address-container">
    <div class="address-details-container">
      <label class="address-label">
        <input type="radio" value="{{$eachdata->id}}" name="address" class="address-radio">
        <span class="address-details">
          <div class="name-phone">
            <strong class="address-name">{{$eachdata->name}}</strong>
            <span class="address-phone">{{$eachdata->phone}}</span>
          </div>
          <div class="address-text">
            {{$eachdata->address}}, {{$eachdata->city->name}}, {{$eachdata->state->name}}, {{$eachdata->country->name}}.
            <strong>{{$eachdata->zip_code}}</strong>
          </div>
        </span>
      </label>
    </div>

    <div class="edit-delete-buttons">
        <a href="{{ url('edit-shipping-address/'.$eachdata->id) }}"><button type="button">Edit</button></a>
       <a href="javascript:void(0);" class="delete-address-btn" data-id="{{ $eachdata->id }}">
    <button type="button">Delete</button>
</a>
    </div>
  </div>

  @endforeach
    @else
        <div class="no-data">
            <p>No Shipping Address Found</p>
        </div>
    @endif
</div>    
  
                </div>
              </div>


            </div>
          </div>
        </div>
      </section>

   
      
    

    </main>

 @endsection

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>


<script type="text/javascript">
  
  $(document).on('click','.shippingaddressupdate',function(e){
e.preventDefault();


var name = $('.name').val();
var email = $('.email').val();
var phone = $('.mobile').val();
var address = $('.address').val();
var landmark = $('.landmark').val();
var countryid = $('.countryid').val();


var stateid = $('.stateid').val();
var cityid = $('.cityid').val();
var postCode = $('.postCode').val();






$.ajax({
url:"{{url('update-shipping-address')}}",
type:"POST",
dataType:"JSON",

data:{
name:name,
email:email,
phone:phone,
address:address,
landmark:landmark,
countryid:countryid,
stateid:stateid,
cityid:cityid,
postCode:postCode,
 _token: '{{ csrf_token() }}' 

},

success:function(res){
toster(res.type,res.msg);




}

});



});
</script>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Bind a click event on all delete buttons
    document.querySelectorAll('.delete-address-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id'); // Get the address ID

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FD9636', // Updated color
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, redirect to the delete route
                    window.location.href = "{{ url('delete-shipping-address') }}/" + id;
                }
            });
        });
    });
});

</script>


<script>
 document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-wishlist-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id'); // Get the wishlist ID

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FD9636', // Color for "Yes, delete it!" button
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ url('delete-wishlist') }}/" + id, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: data.type === 'success' ? 'Deleted!' : 'Error!',
                            text: data.msg,
                            icon: data.type,
                            confirmButtonColor: '#FD9636' // Color for "OK" button after deletion
                        }).then(() => {
                            if (data.type === 'success') {
                                location.reload(); // Refresh only if deletion was successful
                            }
                        });
                    }).catch(error => console.error('Error:', error));
                }
            });
        });
    });
});

</script>


<script>
    $(document).on('click', '.addtocartwishlist', function (e) {
    e.preventDefault();

    // Get the clicked button
    var $this = $(this);

    // Find values specific to this product using `.closest()`
    var qty = $this.data('qty');
    var product_id = $this.data('product_id');
    var productvariantid = $this.closest('.item-wishlist').find('.productvarintasid').val();
    
    
  
    var productPrice = $this.closest('.item-wishlist').find('.productprice').val();
    var productdiscount = $('#product-discount-' + product_id).val();
   
     var producttax = $('#product-tax-' + product_id).val();
     
    var created_by = $this.closest('.item-wishlist').find('#createdby').val();

    // Debugging: Check if the correct values are being fetched
    console.log({
        qty,
        product_id,
        productvariantid,
        productPrice,
        created_by,
      
    });

    // Send the AJAX request
    $.ajax({
        url: "{{url('add-to-cart')}}",
        type: "POST",
        dataType: "JSON",
        data: {
            qty: qty,
            product_id: product_id,
            productvariantid: productvariantid,
            productPrice: productPrice,
            created_by: created_by,
             productdiscount:productdiscount,
             producttax:producttax,
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            // Show a success message
           showToast(res.type, res.msg);

            // Refresh cart functions
            myCartFyunction();
            navmyCartFyunction();
            getCartCount();
        }
    });
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Check if there is a hash in the URL
    const hash = window.location.hash;

    // Hide all tab content initially
    const allTabsContent = document.querySelectorAll('.tab-content .tab-pane');
    allTabsContent.forEach(function (content) {
        content.classList.remove('active', 'show'); // Hide all tab content
    });

    // If a hash exists, try to activate the corresponding tab
    if (hash) {
        activateTab(hash);
    } else {
        // If no hash exists, activate the first tab by default
        const firstTabLink = document.querySelector('.nav-tabs .nav-link');
        if (firstTabLink) {
            firstTabLink.classList.add('active');
            const firstTabContent = document.querySelector(firstTabLink.getAttribute('href'));
            if (firstTabContent) {
                firstTabContent.classList.add('active', 'show');
            }
        }
    }

    // Handle click events to update the URL hash
    document.querySelectorAll('.nav-tabs .nav-link').forEach(function (tab) {
        tab.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default hash change behavior

            // Remove active classes from all tabs and content
            document.querySelectorAll('.nav-tabs .nav-link').forEach(function (link) {
                link.classList.remove('active');
            });
            document.querySelectorAll('.tab-content .tab-pane').forEach(function (content) {
                content.classList.remove('active', 'show');
            });

            // Add active class to the clicked tab and its content
            tab.classList.add('active');
            const tabContent = document.querySelector(tab.getAttribute('href'));
            if (tabContent) {
                tabContent.classList.add('active', 'show');
            }

            // Update the URL hash without scrolling
            history.replaceState(null, null, tab.getAttribute('href'));
        });
    });

    // Function to activate a tab
    function activateTab(tabId) {
        const tabLink = document.querySelector(`a[href="${tabId}"]`);
        if (tabLink) {
            // Remove 'active' class from all tabs
            document.querySelectorAll('.nav-tabs .nav-link').forEach(function (link) {
                link.classList.remove('active');
            });

            // Add 'active' class to the clicked tab
            tabLink.classList.add('active');

            // Activate the tab content associated with the hash
            const tabContent = document.querySelector(tabId);
            if (tabContent) {
                tabContent.classList.add('active', 'show');
            }
        }
    }
});

</script>


