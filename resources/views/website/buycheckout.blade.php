@extends('website.layout.app')
@section('content')
<?php $user_id = Auth::guard('customer')->user();
$Symbol = \Helpers::getActiveCurrencySymbol();
?>

@php
$qty = request()->query('qty', 1); // Default to 1 if qty is not present in the URL


@endphp

<main class="main">
    <div class="section-box">
        <div class="breadcrumbs-div">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a class="font-xs color-gray-1000" href="index.html">Home</a></li>
                    <li><a class="font-xs color-gray-500" href="shop-grid.html">Shop</a></li>
                    <li><a class="font-xs color-gray-500" href="shop-cart.html">Checkout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <section class="section-box shop-template">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="box-border">
                        <h5 class="font-md-bold mb-20">Your Order</h5>
                        <div class="listCheckout">

                            <div class="item-wishlist">

                                <div class="wishlist-product">
                                    <div class="product-wishlist">
                                        <div class="product-image">

                                            @if($res_data->variant_id)
                                            <a href="{{ url('product-details/'.$res_data->slug) }}">
                                                <img src="{{ url('uploads/'.$res_data->first_image) }}" alt="Ecom">
                                            </a>
                                            @else


                                            <a href="{{ url('product-details/'.$res_data->slug) }}">
                                                <img src="{{ url('uploads/product/'.$res_data->first_image) }}" alt="Ecom">
                                            </a>
                                            @endif



                                            @php
                                            $productdiscountamount = $res_data->variantprice * ($res_data->discount / 100);
                                            $priceafterdiscount = $res_data->variantprice - $productdiscountamount;

                                            $totalTax = $res_data->producttaxprice ?? 0;
                                            @endphp



                                            @php
                                            if (setting('including_tax') == 0) {
                                            $finalPriceWithTax = $priceafterdiscount + $totalTax;
                                            $discountpricewithtax=$res_data->variantprice + $totalTax;
                                            } else {
                                            $finalPriceWithTax = $priceafterdiscount;
                                            $discountpricewithtax=$res_data->variantprice;
                                            }






                                            @endphp

                                        </div>
                                        <span class="discountofproduct mt-2"></span>
                                        <div class="product-info">
                                            <a href="{{ url('product-details/'.$res_data->slug) }}">
                                                <h6 class="color-brand-3">{{$res_data->product_name}}</h6>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="wishlist-status">
                                    <h5 class="color-gray-500">{{$qty}}x</h5>
                                    <input type="hidden" value="{{$qty}}" class="productqty">
                                </div>
                                <div class="wishlist-price">



                                    <h4 class="color-brand-3 font-lg-bold">{{
$Symbol}}{{ number_format($finalPriceWithTax, 0, '.', ',') }}</h4>


                                </div>


                            </div>

                            <div class="form-group mt-15 font-md-bold color-brand-3">
                                <label for="coupnscode" class="form-label ">{{__('lang.Best_coupons_for_you')}}</label>
                                <div class="d-flex">
                                    <input id="coupnscode" class="form-control mr-15 coupnscode" placeholder="{{__('lang.Enter_Your_Coupon')}}">
                                    <button class="btn btn-buy w-auto" id="applycoupns">Apply</button>
                                </div>
                            </div>

                        </div>

                        <div class="form-group mb-0">
                            <div class="row mb-10">
                                <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Subtotal</span></div>
                                <div class="col-lg-6 col-6 text-end">

                                    <span class="font-lg-bold color-brand-3">{{
$Symbol}}{{ number_format($finalPriceWithTax*$qty, 0, '.', ',') }}</span>
                                    <input type="hidden" value="{{$finalPriceWithTax*$qty}}" name="total">



                                </div>

                                @if(setting('including_tax') == 0)
                                <input name="totaltax" type="hidden" value="0">

                                @else
                                <div class="row mb-10">
                                    <div class="col-lg-6 col-6">
                                        <span class="font-md-bold color-brand-3">Estimated tax</span>
                                    </div>
                                    <div class="col-lg-6 col-6 text-end">
                                        <span class="font-lg-bold color-brand-3">{{$Symbol}}{{number_format($totalTax*$qty, 0, '.', ',') }}</span>
                                        <input type="hidden" value="{{round($totalTax*$qty)}}" name="totaltax">
                                    </div>
                                </div>
                                @endif

                            </div>
                            <div class=" mb-10 pb-5">
                                <div class="row">
                                    <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Shipping</span></div>
                                    <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3 shippingtotal">-</span></div>
                                </div>
                                <input type="hidden" name="shippingtotal" class="shipping_amount">
                                <input type="hidden" name="discountofproduct" value="" class="discountofproduct">


                            </div>


                            <div class="row mb-10 border-bottom">
                                <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">{{__('lang.Coupn_Discount')}}</span></div>
                                <div class="col-lg-6 col-6 text-end"><span class="font-lg-bold color-brand-3 discount-price">-</span>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-6"><span class="font-md-bold color-brand-3">Total</span></div>
                                <div class="col-lg-6 col-6 text-end">

                                    @php
                                    // Assuming $finalPriceWithTax and $totalTax are already calculated
                                    if (setting('including_tax') == 0) {
                                    $grandTotal = $finalPriceWithTax * $qty;
                                    } else {
                                    $grandTotal = ($finalPriceWithTax + $totalTax) * $qty;
                                    }
                                    @endphp

                                    <span class="font-lg-bold color-brand-3 grandstotal final-amount">{{$Symbol}}{{number_format($grandTotal, 0, '.', ',') }}</span>




                                    <input class="sumofgrandstotal " type="hidden" name="grandtotal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-4">
                    <div class="box-border">


                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                <h5 class="font-md-bold color-brand-3 mt-15 mb-20">Shipping Address</h5>

                                @if(isset($user_id) && $user_id != '')
                                <a class="btn btn-buy w-auto addressaddbtn" id="addshippingaddress" href="#">Add New Address</a>
                                @endif
                            </div>


                            @if($user_id)
                            @if($deliveryadress->isEmpty())
                            <p>No shipping address found.</p>
                            @else
                            @foreach ($deliveryadress as $eachdata)
                            <div class="col-lg-12 address-container">

                                <label class="address-label">
                                    <input type="radio" value="{{ $eachdata->id }}" data-pincode="{{ $eachdata->zip_code }}" data-shippingaddressid="{{ $eachdata->id }}" name="address" class="address-radio pincode"
                                        {{ $loop->first ? 'checked' : '' }}>

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
                            @endforeach
                            @endif
                            @else
                            <p>Please log in to view your addresses.</p>
                            @endif

                        </div>
                    </div>


                    <div class="payment-container">
                        <h3>{{__('lang.Payment')}}</h3>
                        <p>{{__('lang.Allencrypted')}}</p>
                        <div class="payment-method">
                            @if(setting('enable_cod') == 1)
                            <label>
                                <input type="radio" name="payment" value="cash">
                                <span>Cash On Delivery</span>
                            </label>
                            @endif

                            @if(setting('enable_paypal') == 1)
                            <label>
                                <input type="radio" class="payment" name="payment" value="paypal">
                                <span>PayPal</span>
                            </label>
                            @endif
                            @if(setting('enable_razorpay') == 1)
                            <label>
                                <input type="radio" class="payment" name="payment" value="razorpay">
                                <span>Razorpay</span>
                            </label>
                            @endif
                            @if(setting('enable_stripe') == 1)
                            <label>
                                <input type="radio" class="payment" name="payment" value="stripe">
                                <span>Stripe</span>
                            </label>
                            @endif
                        </div>
                    </div>





                    <div class="row mt-20">


                        <div class="col-lg-6 col-5 mb-20"></div>

                        <div class="col-lg-6 col-7 mb-20 text-end"><a class="btn btn-buy w-auto arrow-next directplaceorderbtn placeorderbtndisable" id="">Place an Order</a></div>
                    </div>

                </div>

            </div>
    </section>

    <input type="hidden" name="productid" value="{{$res_data->product_id}}" class="productid">
    <input type="hidden" value="{{$res_data->product_id}}" class="product_id">
    <input type="hidden" name="variantsid" value="{{$res_data->variantid}}" class="variantsid">
    <input type="hidden" name="created_byid" value="{{$res_data->created_byid}}" class="created_byid">
    <input type="hidden" name="productqty" value="{{$qty}}" class="productqty">
    <input type="hidden" name="productprice" value="{{round($finalPriceWithTax)}}" class="productprice">
    <input type="hidden" name="producttax" value="{{$totalTax}}" class="producttax">



</main>

<div class="modal fade" id="shippingaddressmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6"></div>
                <div class="modal-body">
                    <form id="shippingForm" action="{{url('add-new-shipping-address')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="font-md-bold color-brand-3 mt-15 mb-20">Shipping address</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="form-control font-sm" name="name" type="text" placeholder="Name*" required>
                                    <div class="error-message text-danger" id="nameError"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="form-control font-sm" name="email" type="text" placeholder="Email*" required>
                                    <div class="error-message text-danger" id="emailError"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input class="form-control font-sm" name="phone" type="text" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 12);"
                                        pattern="[0-9]{10}" placeholder="Phone*" required>
                                    <div class="error-message text-danger" id="phoneError"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control font-sm select-style1 color-gray-700" name="countryid" id="category-select" required>
                                        <option value="">Select Country</option>
                                        @foreach($country_data as $country)
                                        <option value="{{ $country->id }}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message text-danger" id="countryError"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control font-sm select-style1 color-gray-700" name="stateid" id="State-select" required>
                                        <option value="">Select State</option>
                                    </select>

                                    <div class="error-message text-danger" id="stateError"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control font-sm select-style1 color-gray-700" name="cityid" id="city-select" required>
                                        <option value="">Select City</option>
                                    </select>
                                    <div class="error-message text-danger" id="cityError"></div>
                                </div>
                            </div>

                            <!-- New Select Box for Zipcodes -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <select class="form-control font-sm select-style1 color-gray-700" name="postCode" id="zipcode-select" required>
                                        <option value="">Select Zipcode</option>
                                    </select>
                                    <div class="error-message text-danger" id="zipcodeError"></div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea class="form-control font-sm" name="address" placeholder="Address" required></textarea>
                                    <div class="error-message text-danger" id="addressError"></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-0">
                                    <textarea class="form-control font-sm" name="landmark" placeholder="Land Mark(Optional)" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
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

@endsection






<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>




<script type="text/javascript">
    $(document).on('click', '#addshippingaddress', function() {


        $('#shippingaddressmodal').modal('show');



    });
</script>


<script>
    document.getElementById('shippingForm').addEventListener('submit', function(event) {
        let valid = true;

        // Clear previous error messages
        const errorFields = ['nameError', 'emailError', 'phoneError', 'countryError', 'stateError', 'cityError', 'postCodeError', 'addressError'];
        errorFields.forEach(field => {
            document.getElementById(field).innerText = '';
        });

        // Validate each field
        const requiredFields = ['name', 'email', 'phone', 'countryid', 'stateid', 'cityid', 'postCode', 'address'];

        requiredFields.forEach(field => {
            const input = this[field];
            if (!input.value) {
                valid = false;
                document.getElementById(field + 'Error').innerText = `${field.replace(/([A-Z])/g, ' $1').replace(/^./, str => str.toUpperCase())} is required.`;
            }
        });

        if (!valid) {
            event.preventDefault(); // Stop form submission
        }
    });
</script>





<script type="text/javascript">
    $(document).ready(function() {
        $('.directplaceorderbtn').on('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior

            var $button = $(this);
            var originalText = $button.text();

            // Disable button and show processing text
            $button.prop('disabled', true).text('Processing...');

            var userId = <?php echo json_encode($user_id); ?>;

            // Check if the user is logged in

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

            // Check if any shipping address is selected
            var selectedAddress = $('input[name="address"]:checked').val();
            if (!selectedAddress) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Shipping Address Required',
                    text: 'Please select a shipping address before proceeding.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#FD9636'
                });
                $button.prop('disabled', false).text(originalText); // Re-enable button
                return; // Stop the AJAX request if no shipping address is selected
            }

            // Check if any payment method is selected
            var paymentMethod = $('input[name="payment"]:checked').val();
            if (!paymentMethod) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Payment Method Required',
                    text: 'Please select a payment method before proceeding.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#FD9636'
                });
                $button.prop('disabled', false).text(originalText); // Re-enable button
                return; // Stop the AJAX request if no payment method is selected
            }
            $('input[name="payment"]').prop('disabled', true);
            $('.addressaddbtn').prop('disabled', true);
            // Get form data
            var data = {
                productid: $('input[name="productid"]').val(),
                total: $('input[name="total"]').val(),
                shippingamount: $('input[name="shippingtotal"]').val(),
                grandTotalamount: $('input[name="grandtotal"]').val(),
                shippingAddressId: $('input[name="address"]:checked').data('shippingaddressid'),
                paymentMethod: paymentMethod,
                variantsid: $('input[name="variantsid"]').val(),
                created_byid: $('input[name="created_byid"]').val(),
                productqty: $('input[name="productqty"]').val(),
                productprice: $('input[name="productprice"]').val(),
                producttax: $('input[name="producttax"]').val(),
                discountofproduct: $('input[name="discountofproduct"]').val(),
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            };

            // If payment method is Razorpay
            if (paymentMethod === "razorpay") {
                $.ajax({
                    url: '{{ route("create.razorpay.singleorder") }}',
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
                                                window.location.href = "{{ url('order-complete') }}";
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
                    url: '{{ url("placeorderdirect") }}', // Cash order processing
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.status) {
                            window.location.href = "{{url('order-complete')}}";
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Order Failed',
                                text: response.message || 'Something went wrong. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                        $button.prop('disabled', false).text(originalText); // Re-enable button
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while processing your order. Please try again.',
                            confirmButtonText: 'OK'
                        });
                        $button.prop('disabled', false).text(originalText); // Re-enable button
                        $('input[name="payment"]').prop('disabled', false);
                        $('.addressaddbtn').prop('disabled', false);
                    }
                });
            }
        });
    });
</script>







<script>
    $(document).on('click', '#applycoupns', function() {
        var currencySymbol = "<?php echo $Symbol; ?>";

        if ($(this).text() === 'Remove') {
            $('.coupnscode').val('').prop('readonly', false);
            $('.discount-price').text('-');
            var originalValue = $('.sumofgrandstotal').data('original-value');

            $('.sumofgrandstotal').val(originalValue);
            var formattedOriginalValue = Math.round(originalValue).toLocaleString();
            $('.final-amount').text(currencySymbol + formattedOriginalValue);

            $('.discountofproduct').val('0').text('');
            $(this).text('Apply');

            return;
        }

        if ($('input[name="address"]:checked').length === 0) {
            toastr.warning("Please select a valid shipping address with a pincode.");
            return;
        }

        var coupnscode = $('.coupnscode').val();
        var productqty = $('.productqty').val();

        if (coupnscode.trim() === '') {
            toastr.warning("Please enter a valid coupon code.");
            return;
        }

        var sumofgrandstotal = $('.sumofgrandstotal').val();
        var shipping_amount = $('.shipping_amount').val();

        var productIds = [];

        $('.product_id').each(function() {
            productIds.push($(this).val());
        });

        $.ajax({
            url: '{{ url("check-coupnscode-single") }}',
            method: 'POST',
            data: {
                coupnscode: coupnscode,
                product_ids: productIds,
                sumofgrandstotal: sumofgrandstotal,
                productqty: productqty,
                shipping_amount: shipping_amount,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.type === 'success') {
                    let totalDiscount = Math.round(response.total_discount);
                    let totalDiscountOnProduct = Math.round(response.totalDiscountOnProduct);
                    let finalAmount = Math.round(response.final_amount);

                    $('.discount-price').text(currencySymbol + totalDiscount.toLocaleString());
                    $('.sumofgrandstotal').data('original-value', sumofgrandstotal);

                    let formattedTotal = finalAmount.toLocaleString();
                    $('.sumofgrandstotal').val(finalAmount);
                    $('.final-amount').text(currencySymbol + formattedTotal);

                    $('.shipping_amount').val(response.shipping_total);

                    $('.discountofproduct').val(totalDiscountOnProduct).text('save: ' + currencySymbol + totalDiscountOnProduct).css('color', 'red');

                    $('.coupnscode').prop('readonly', true);
                    $('#applycoupns').text('Remove');

                    if (finalAmount <= 0) {
                        $('.payment').prop('disabled', true);
                    } else {
                        $('.payment').prop('disabled', false);
                    }

                    toastr.success(response.msg);
                } else {
                    toastr.warning(response.msg);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred while applying the coupon.');
            }
        });
    });
</script>
