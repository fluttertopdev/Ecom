@extends('website.layout.app') @section('content')
<?php
$user_id = Auth::guard('customer')->user();
$Symbol = \Helpers::getActiveCurrencySymbol(); ?>

<style>
  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Hide number input spinner arrows in Firefox */
  input[type="number"] {
    -moz-appearance: textfield;
  }
</style>
<main class="main">
  <div class="section-box">
    <div class="breadcrumbs-div">
      <div class="container">
        <ul class="breadcrumb">
          <li><a class="font-xs color-gray-1000" href="{{url('/')}}">{{__('lang.Home')}}</a></li>
          <li><a class="font-xs color-gray-500" href="{{url('/')}}">{{__('lang.Shop')}}</a></li>
          <li><a class="font-xs color-gray-500" href="{{url('cart')}}">Cart</a></li>
        </ul>
      </div>
    </div>
  </div>

  <section class="section-box shop-template">
    <div class="container mb-40 mt-40" style="min-height: 550px;">
      <div class="row">
        <!-- "Your Order" Section (Moved to the left) -->
        <div class="col-lg-6">
          <div class="box-border">
            <h5 class="font-md-bold mb-20">{{__('lang.Your_Order')}}</h5>
            <div class="listCheckout">
              @php $totalPrice = 0; $finalTotal = 0; $totalTax = 0; @endphp @foreach($res_data as $list) @php $productdiscountamount = round($list->product_price * ($list->product->discount / 100)); $productPrice =
              $list->price_after_discount; if((setting('including_tax') == 0)) $productPrice = $list->price_after_discount + $list->producttaxprice; else $totalTax += $list->producttaxprice * $list->qty; $productPrice =
              $productPrice * $list->qty; $totalPrice = $totalPrice + $productPrice; $finalTotal = $finalTotal + $productPrice; @endphp

              <div class="item-wishlist">
                <input type="hidden" value="{{$list->product_id}}" class="product_id" />

                <input type="hidden" value="" class="shippingofproduct" />

                <input type="hidden" value="" class="discountofproduct" />
                <div class="wishlist-product">
                  <div class="product-wishlist">
                    <div class="product-image">
                      <a href="{{ url('product-details/'.$list->product->slug) }}">
                        <img src="{{ asset($list->product_image) }}" alt="Ecom" />
                      </a>
                    </div>
                    <span class="showdiscountofproduct mt-2"></span>
                    <div class="product-info">
                      <a href="{{ url('product-details/'.$list->product->slug) }}">
                        <h6 class="color-brand-3">{{$list->product->name}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="wishlist-status">
                  <h5 class="color-gray-500">x{{$list->qty}}</h5>
                </div>
                <div class="wishlist-price">
                  <h4 class="color-brand-3 font-lg-bold">{{$Symbol}}{{ number_format($productPrice, 2, '.', ',') }}</h4>

                  <input class="product_price" type="hidden" value="{{$productPrice}}" name="product_price" />
                  <input class="product_tax" type="hidden" value="{{ $list->producttaxprice * $list->qty}}" name="product_tax" />
                </div>
              </div>

              @endforeach
            </div>

            <div class="form-group mt-15 font-md-bold color-brand-3">
              <label for="coupnscode" class="form-label">{{__('lang.Best_coupons_for_you')}}</label>
              <div class="d-flex">
                <input id="coupnscode" class="form-control mr-15 coupnscode" placeholder="{{__('lang.Enter_Your_Coupon')}}" />
                <button class="btn btn-buy w-auto" id="applycoupns">Apply</button>
              </div>
            </div>

            <div class="form-group mb-0">
              <div class="row mb-10">
                <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">{{__('lang.Subtotal')}}</span></div>
                <input type="hidden" value="{{$totalPrice}}" name="total" />

                <div class="col-lg-6 col-6 text-end">
                  <span class="font-lg-bold color-brand-3">
                    {{$Symbol}}{{ number_format($totalPrice, 2, '.', ',') }}
                  </span>
                </div>
              </div>

              @if(setting('including_tax') == 0)
              <input name="totaltax" type="hidden" value="0" />
              @else
              <div class="row mb-10">
                <div class="col-lg-6 col-6">
                  <span class="font-md-bold color-brand-3">Estimated tax</span>
                </div>
                <div class="col-lg-6 col-6 text-end">
                  <span class="font-lg-bold color-brand-3">{{$Symbol}}{{ number_format($totalTax, 2, '.', ',') }}</span>
                  <input type="hidden" value="{{$totalTax}}" name="totaltax" />
                </div>
              </div>
              @endif

              <div class="mb-10 pb-5">
                <div class="row">
                  <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">{{__('lang.Shipping')}}</span></div>
                  <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3 shippingtotal">-</span></div>
                </div>
                <input type="hidden" name="shippingtotal" class="shipping_amount" />
              </div>

              <div class="row mb-10 border-bottom">
                <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">{{__('lang.Coupn_Discount')}}</span></div>
                <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3 discount-price">-</span></div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">{{__('lang.Total')}}</span></div>
                <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3 grandstotal final-amount">{{$Symbol}}{{ number_format($finalTotal, 2, '.', ',') }}</span></div>
                <input class="sumofgrandstotal" type="hidden" name="grandtotal" />
              </div>
            </div>
          </div>
        </div>

        <!-- Shipping Address, Payment Method, and Place Order (Moved to the right) -->
        <div class="col-lg-6">
          <div class="box-border">
            <div class="row">
              <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h5 class="font-md-bold color-brand-3 mt-15 mb-20">{{ __('lang.Shipping_Address') }}</h5>
                @if(isset($user_id) && $user_id != '')
                <a class="btn btn-buy w-auto addressaddbtn" id="addshippingaddress" href="#">{{ __('lang.Add_New_Address') }}</a>
                @endif
              </div>

              @if($user_id) @if($deliveryadress->isEmpty())
              <p>No shipping address found.</p>
              @else @foreach ($deliveryadress as $index => $eachdata)
              <div class="col-lg-12 address-container">
                <label class="address-label">
                  <input type="radio" value="{{ $eachdata->id }}" data-pincode="{{ $eachdata->zip_code }}" data-shippingaddressid="{{ $eachdata->id }}" name="address" class="address-radio pincode" {{ $loop->first ?'checked' : '' }} />
                  <span class="address-details">
                    <div class="name-phone">
                      <strong class="address-name">{{ $eachdata->name }}</strong>
                      <span class="address-phone">{{ $eachdata->phone }}</span>
                    </div>
                    <div class="address-text">
                      {{ $eachdata->address }}, {{ $eachdata->city->name }}, {{ $eachdata->state->name }}, {{ $eachdata->country->name }}.
                      <strong>{{ $eachdata->zip_code }}</strong>
                    </div>
                  </span>
                </label>
              </div>
              @endforeach @endif @else
              <p>{{ __('lang.Please_log_in_to') }}</p>
              @endif
            </div>

            <div class="payment-container">
              <h3>{{__('lang.Payment')}}</h3>
              <p>{{__('lang.Allencrypted')}}</p>
              <div class="payment-method">
                @if(setting('enable_cod') == 1)
                <label>
                  <input type="radio" name="payment" value="cash" />
                  <span>Cash On Delivery</span>
                </label>
                @endif @if(setting('enable_paypal') == 1)
                <label>
                  <input type="radio" class="payment" name="payment" value="paypal" />
                  <span>PayPal</span>
                </label>
                @endif @if(setting('enable_razorpay') == 1)
                <label>
                  <input type="radio" class="payment" name="payment" value="razorpay" />
                  <span>Razorpay</span>
                </label>
                @endif @if(setting('enable_stripe') == 1)
                <label>
                  <input type="radio" class="payment" name="payment" value="stripe" />
                  <span>Stripe</span>
                </label>
                @endif
              </div>
            </div>

            <div class="row mt-20">
              <div class="col-lg-6 col-5 mb-20"></div>
              <div class="col-lg-6 col-7 mb-20 text-end">
                <a class="btn btn-buy w-auto arrow-next placeorderbtn placeorderbtndisable" href="#">{{__('lang.Place_an_Order')}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="shippingaddressmodal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6"></div>
        <div class="modal-body">
          <form id="shippingForm" action="{{url('add-new-shipping-address')}}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <h5 class="font-md-bold color-brand-3 mt-15 mb-20">{{__('lang.Shipping_Address')}}</h5>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <input class="form-control font-sm" name="name" type="text" placeholder="{{__('lang.Name')}}*" id="name" />
                  <div class="error-message text-danger" id="nameError"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <input class="form-control font-sm" name="email" type="text" placeholder="{{__('lang.Email')}}*" id="email" />
                  <div class="error-message text-danger" id="emailError"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <input class="form-control font-sm" name="phone" type="text" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 12);" pattern="[0-9]{10}" placeholder="{{__('lang.Phone')}}*" id="phone" />
                  <div class="error-message text-danger" id="phoneError"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <select class="form-control font-sm select-style1 color-gray-700" name="countryid" id="category-select">
                    <option value="">{{__('lang.Select_Country')}}</option>
                    @foreach($country_data as $country)
                    <option value="{{ $country->id }}">{{$country->name}}</option>
                    @endforeach
                  </select>
                  <div class="error-message text-danger" id="countryError"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <select class="form-control font-sm select-style1 color-gray-700" name="stateid" id="State-select">
                    <option value="">{{__('lang.Select_state')}}</option>
                  </select>
                  <div class="error-message text-danger" id="stateError"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <select class="form-control font-sm select-style1 color-gray-700" name="cityid" id="city-select">
                    <option value="">{{__('lang.Select_city')}}</option>
                  </select>
                  <div class="error-message text-danger" id="cityError"></div>
                </div>
              </div>

              <!-- New Select Box for Zipcodes -->
              <div class="col-lg-12">
                <div class="form-group">
                  <select class="form-control font-sm select-style1 color-gray-700" name="postCode" id="zipcode-select">
                    <option value="">{{__('lang.SelectZipcode')}}</option>
                  </select>
                  <div class="error-message text-danger" id="zipcodeError"></div>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="form-group">
                  <textarea class="form-control font-sm" name="address" placeholder="{{__('lang.Address')}}" id="address"></textarea>
                  <div class="error-message text-danger" id="addressError"></div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-0">
                  <textarea class="form-control font-sm" name="landmark" placeholder="{{__('lang.Landmark')}}({{__('lang.Optional')}})" rows="5"></textarea>
                </div>
              </div>
            </div>
            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-buy w-auto">{{__('lang.Save')}}</button>
              <button type="reset" class="btn btn-buy w-auto btn-reset" data-bs-dismiss="modal" aria-label="Close">{{__('lang.Cancel')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Form Validation Function
  function validateForm() {
    let valid = true;

    // Clear previous error messages
    document.getElementById("nameError").textContent = "";
    document.getElementById("emailError").textContent = "";
    document.getElementById("phoneError").textContent = "";
    document.getElementById("countryError").textContent = "";
    document.getElementById("stateError").textContent = "";
    document.getElementById("cityError").textContent = "";
    document.getElementById("zipcodeError").textContent = "";
    document.getElementById("addressError").textContent = "";

    // Name Validation
    const name = document.getElementById("name").value;
    if (!name.trim()) {
      document.getElementById("nameError").textContent = "Name is required.";
      valid = false;
    }

    // Email Validation
    const email = document.getElementById("email").value;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!email.trim()) {
      document.getElementById("emailError").textContent = "Email is required.";
      valid = false;
    } else if (!emailRegex.test(email)) {
      document.getElementById("emailError").textContent = "Invalid email format.";
      valid = false;
    }

    // Phone Validation
    const phone = document.getElementById("phone").value;
    if (!phone.trim()) {
      document.getElementById("phoneError").textContent = "Phone number is required.";
      valid = false;
    } else if (phone.length > 12) {
      document.getElementById("phoneError").textContent = "Phone number cannot be longer than 12 digits.";
      valid = false;
    }

    // Country Validation
    const countryid = document.getElementById("category-select").value;
    if (!countryid) {
      document.getElementById("countryError").textContent = "Please select a country.";
      valid = false;
    }

    // State Validation
    const stateid = document.getElementById("State-select").value;
    if (!stateid) {
      document.getElementById("stateError").textContent = "Please select a state.";
      valid = false;
    }

    // City Validation
    const cityid = document.getElementById("city-select").value;
    if (!cityid) {
      document.getElementById("cityError").textContent = "Please select a city.";
      valid = false;
    }

    // Zipcode Validation
    const postcode = document.getElementById("zipcode-select").value;
    if (!postcode) {
      document.getElementById("zipcodeError").textContent = "Please select a zipcode.";
      valid = false;
    }

    // Address Validation
    const address = document.getElementById("address").value;
    if (!address.trim()) {
      document.getElementById("addressError").textContent = "Address is required.";
      valid = false;
    }

    return valid; // Return false to prevent form submission if validation fails
  }
</script>

@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script type="text/javascript">
  $(document).on("click", "#addshippingaddress", function() {
    $("#shippingaddressmodal").modal("show");
  });
</script>

<script>
  $(document).ready(function() {
    $('.placeorderbtn').on('click', function(e) {
      e.preventDefault();

      var $button = $(this);
      var originalText = $button.text();

      if ($button.prop('disabled')) {
        return;
      }

      $button.prop('disabled', true).text('Processing...');

      var userId = <?php echo json_encode($user_id); ?>;

      if (!userId) {
        Swal.fire({
          icon: 'warning',
          title: 'Please sign in to continue.',
          text: 'Please sign in to place an order.',
          confirmButtonText: 'OK',
          confirmButtonColor: '#FD9636'
        }).then(() => {
          window.location.href = '{{ url("login") }}';
        });
        $button.prop('disabled', false).text(originalText);
        return;
      }

      var selectedAddress = $('input[name="address"]:checked').val();
      if (!selectedAddress) {
        Swal.fire({
          icon: 'warning',
          title: 'Shipping Address Required',
          text: 'Please select a shipping address before proceeding.',
          confirmButtonText: 'OK',
          confirmButtonColor: '#FD9636'
        });

        $button.prop('disabled', false).text(originalText);
        return;
      }

      var paymentMethod = $('input[name="payment"]:checked').val();
      if (!paymentMethod) {
        Swal.fire({
          icon: 'warning',
          title: 'Payment Method Required',
          text: 'Please select a payment method before proceeding.',
          confirmButtonText: 'OK',
          confirmButtonColor: '#FD9636'
        });

        $button.prop('disabled', false).text(originalText);
        return;
      }
      $('input[name="payment"]').prop('disabled', true);
      $('.addressaddbtn').prop('disabled', true);


      var data = {
        product_ids: $('.product_id').map(function() {
          return $(this).val();
        }).get(),
        shippingamount: $('input[name="shippingtotal"]').val(),
        product_price: $('.product_price').map(function() {
          return $(this).val();
        }).get(),
        product_tax: $('.product_tax').map(function() {
          return $(this).val();
        }).get(),
        grandTotalamount: $('input[name="grandtotal"]').val(),
        shippingAddressId: $('input[name="address"]:checked').data('shippingaddressid'),
        payment_method: paymentMethod,
        productshipping: $('.shippingofproduct').map(function() {
          return $(this).val();
        }).get(),
        productcoupndiscount: $('.discountofproduct').map(function() {
          return $(this).val();
        }).get(),
        _token: '{{ csrf_token() }}'
      };

      if (paymentMethod === "razorpay") {
        $.ajax({
          url: '{{ route("create.razorpay.order") }}',
          method: 'POST',
          data: data,
          success: function(response) {
            if (response.status && response.razorpay_order_id) {
              var options = {
                "key": "{{ setting('razorpay_key') }}", // Your Razorpay API key
                "amount": response.total_amount,
                "currency": response.currency,
                "name": "Ecom",
                "description": "Order Payment",
                "image": "https://ecom.fluttertop.com/NewEcom/uploads/setting/1729672087.svg",
                "order_id": response.razorpay_order_id,
                "handler": function(paymentResponse) {
                  $.ajax({
                    url: '{{ route("update.payment.status") }}',
                    method: 'POST',
                    data: {
                      order_id: response.order_key,
                      razorpay_payment_id: paymentResponse.razorpay_payment_id,
                      razorpay_order_id: paymentResponse.razorpay_order_id,
                      razorpay_signature: paymentResponse.razorpay_signature,
                      _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                      if (res.status) {
                        // Handle cart deletion after successful payment
                        $.ajax({
                          url: '{{ route("delete.ordercart") }}', // New endpoint to delete the cart
                          method: 'POST',
                          data: {
                            user_id: userId,
                            _token: '{{ csrf_token() }}'
                          },
                          success: function(cartDeletionResponse) {
                            if (cartDeletionResponse.status) {
                              window.location.href = "{{ url('order-complete') }}";
                            } else {
                              Swal.fire({
                                icon: 'error',
                                title: 'Cart Deletion Error',
                                text: cartDeletionResponse.message || 'Failed to clear the cart. Please try again.',
                                confirmButtonText: 'OK'
                              });
                            }
                          },
                          error: function() {
                            Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: 'An error occurred while deleting the cart. Please contact support.',
                              confirmButtonText: 'OK'
                            });
                          }
                        });
                      } else {
                        Swal.fire({
                          icon: 'error',
                          title: 'Payment Error',
                          text: res.message || 'Payment failed, please try again.',
                          confirmButtonText: 'OK'
                        });
                        $button.prop('disabled', false).text(originalText);
                      }
                    },
                    error: function() {
                      Swal.fire({
                        icon: 'error',
                        title: 'Payment Error',
                        text: 'An error occurred while verifying payment. Please contact support.',
                        confirmButtonText: 'OK'
                      });
                      $button.prop('disabled', false).text(originalText);
                    }
                  });
                },
                "theme": {
                  "color": "#3399cc"
                },
                "modal": {
                  "ondismiss": function() {
                    // Reload the page if the payment gateway is closed or canceled
                    location.reload();
                  }
                }
              };

              var rzp = new Razorpay(options);
              rzp.open();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Order Failed',
                text: response.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'OK'
              });
              $button.prop('disabled', false).text(originalText);
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while creating the order. Please try again.',
              confirmButtonText: 'OK'
            });
            $button.prop('disabled', false).text(originalText);
          }
        });
      } else if (paymentMethod === "cash") {
        $.ajax({
          url: '{{ route("create.cash.order") }}',
          method: 'POST',
          data: data,
          success: function(response) {
            if (response.status) {
              window.location.href = "{{ url('order-complete') }}";
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Order Failed',
                text: response.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'OK'
              });
              $button.prop('disabled', false).text(originalText);
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while processing your cash order. Please try again.',
              confirmButtonText: 'OK'
            });
            $button.prop('disabled', false).text(originalText);
            $('input[name="payment"]').prop('disabled', false);
            $('.addressaddbtn').prop('disabled', false);
          }
        });
      }
    });
  });
</script>

<script>
  $(document).on("click", "#applycoupns", function() {
    var currencySymbol = "<?php echo $Symbol; ?>"; // Pass PHP variable to JavaScript

    if ($(this).text() === "Remove") {
      $(".coupnscode").val("").prop("readonly", false);
      $(".discount-price").text("-");

      var originalTotal = $(".sumofgrandstotal").data("original-value");

      $(".sumofgrandstotal").val(originalTotal);

      var formattedAmount = Math.round(originalTotal).toLocaleString();
      $(".final-amount").text(currencySymbol + formattedAmount);

      // Reset individual product discount display
      $(".discountofproduct").html("").val("");
      $(".showdiscountofproduct").html("").val("");

      $(this).text("Apply");
      return;
    }

    if ($('input[name="address"]:checked').length === 0) {
      toastr.warning("Please select a valid shipping address with a pincode.");
      return;
    }

    var coupnscode = $(".coupnscode").val();
    if (coupnscode.trim() === "") {
      toastr.warning("Please enter a valid coupon code.");
      return;
    }

    var shipping_amount = $(".shipping_amount").val();
    var sumofgrandstotal = $(".sumofgrandstotal").val();

    var productIds = [];

    $(".product_id").each(function() {
      productIds.push($(this).val());
    });

    $.ajax({
      url: '{{ url("check-coupnscode") }}',
      method: "POST",
      data: {
        coupnscode: coupnscode,
        product_ids: productIds,

        sumofgrandstotal: sumofgrandstotal,
        shipping_amount: shipping_amount,
        _token: "{{ csrf_token() }}",
      },
      success: function(response) {
        if (response.type === "success") {
          response.updated_products.forEach(function(product) {
            var productElement = $('input.product_id[value="' + product.product_id + '"]').closest(".item-wishlist");

            var discountAmount = parseFloat(product.discount_applied).toFixed(2);

            // Update discount input field
            productElement.find(".discountofproduct").val(discountAmount);

            // Update discount span with "You Save:" text and apply red color
            productElement.find(".showdiscountofproduct").html('<span style="color: red;">Save: ' + currencySymbol + discountAmount + "</span>");
          });

          let totalDiscount = response.total_discount;
          let finalTotal = parseFloat((sumofgrandstotal - totalDiscount).toFixed(2));

          $(".discount-price").text(currencySymbol + totalDiscount.toLocaleString());
          $(".sumofgrandstotal").data("original-value", sumofgrandstotal);
          $(".sumofgrandstotal").val(finalTotal);

          var formattedFinalAmount = finalTotal.toLocaleString();
          $(".final-amount").text(currencySymbol + formattedFinalAmount);

          if (finalTotal <= 0) {
            $(".payment").prop("disabled", true);
          } else {
            $(".payment").prop("disabled", false);
          }

          $(".coupnscode").prop("readonly", true);
          $("#applycoupns").text("Remove");

          toastr.success(response.msg);
        } else {
          toastr.warning(response.msg);
        }
      },
      error: function(xhr, status, error) {
        alert("An error occurred while applying the coupon.");
      },
    });
  });
</script>
