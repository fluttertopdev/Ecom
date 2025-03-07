

<?php


use App\Models\Cms;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

 $languageCode = Session::get('website_locale', App::getLocale());

   $titles = CMS::where('status', 1)->with(['translations' => function($query) use ($languageCode) {
            $query->where('language_code', $languageCode);
        }])->get();
 


?>
<style>
    
    .footer-1 {
    padding: 40px 0; /* Add padding to the footer */
}
.menu-footer {
    list-style: none;
    padding: 0;
    margin: 0;
}
.menu-footer li {
    margin-bottom: 10px;
}
.icon-socials {
    display: inline-block;
    margin-right: 10px;
    font-size: 18px; /* Adjust icon size */
}
.icon-socials:hover {
    color: #007bff; /* Add hover effect for icons */
}

</style>

<footer class="footer bg-footer-homepage5">
    <div class="footer-1">
        <div class="container">
            <div class="row">
                <!-- Contact Section -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                    <h4 class="mb-30 color-gray-1000">{{__('lang.Contact')}}</h4>
                    <div class="font-md mb-20 color-gray-900">
                        <strong class="font-md-bold">Address:</strong> {{ setting('address') }}
                    </div>
                    <div class="font-md mb-20 color-gray-900">
                        <strong class="font-md-bold">Phone:</strong>
                        <a href="tel:{{ setting('phone') }}" class="color-gray-900">{{ setting('phone') }}</a>
                    </div>
                    <div class="font-md mb-20 color-gray-900">
                        <strong class="font-md-bold">E-mail:</strong>
                        <a href="mailto:{{ setting('email') }}" class="color-gray-900">{{ setting('email') }}</a>
                    </div>
                    <div class="mt-30">
                        <a class="icon-socials icon-facebook" href="{{ setting('facebook') }}"></a>
                        <a class="icon-socials icon-instagram" href="{{ setting('instagram') }}"></a>
                        <a class="icon-socials icon-twitter" href="{{ setting('XSocialMedia') }}"></a>
                        <a class="icon-socials icon-linkedin" href="{{ setting('linkedin') }}"></a>
                    </div>
                </div>

              <!-- Get to Know Us Section -->
<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
    <h4 class="mb-30 color-gray-1000">
        {{__('lang.Get_to_Know_Us')}} <!-- Static title, can be translated -->
    </h4>
    <ul class="menu-footer">
        @foreach ($titles->slice(0, 5) as $each)
            <li>
                <a href="{{ route('cms.page', ['slug' => $each->slug]) }}">
                    <!-- Check if a translation exists for the title, otherwise fall back to the original -->
                    {{ $each->translations->isNotEmpty() ? $each->translations->first()->title : $each->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<!-- Make Money with Us Section -->
<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
    <h4 class="mb-30 color-gray-1000">
       {{__('lang.Make_Money_with_Us')}} <!-- Static title, can be translated -->
    </h4>
    <ul class="menu-footer">
        @foreach ($titles->slice(5, 5) as $each)
            <li>
                <a href="{{ route('cms.page', ['slug' => $each->slug]) }}">
                    <!-- Check if a translation exists for the title, otherwise fall back to the original -->
                    {{ $each->translations->isNotEmpty() ? $each->translations->first()->title : $each->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>


                <!-- App & Payment Section -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                    <h4 class="mb-30 color-gray-1000">{{__('lang.App_&_Payment')}}</h4>
                    <div>
                        
                        
                        <p class="font-md color-gray-900">{{__('lang.footer_des')}}</p>
                        <div class="mt-20">
                            <a class="mr-10" href="#">
                                <img src="{{asset('front_assets/imgs/template/appstore.png')}}" alt="Ecom">
                            </a>
                            <a href="#">
                                <img src="{{asset('front_assets/imgs/template/google-play.png')}}" alt="Ecom">
                            </a>
                        </div>
                        <p class="font-md color-gray-900 mt-20 mb-10">{{__('lang.Secured_Payment_Gateways')}}</p>
                        <img src="{{url('uploads/setting/'.setting('footerimg'))}}" alt="Ecom">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="{{asset('front_assets/js/vendors/modernizr-3.6.0.min.js')}}"></script>
    <script src="{{asset('front_assets/js/vendors/jquery-3.6.0.min.js')}}"></script>

  <script src="{{asset('front_assets/js/vendors/jquery-migrate-3.3.0.min.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/waypoints.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/wow.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/magnific-popup.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/perfect-scrollbar.min.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/select2.min.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/isotope.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/scrollup.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/swiper-bundle.min.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/noUISlider.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/slider.js') }}"></script>
<!-- Count down -->
<script src="{{asset('front_assets/js/vendors/counterup.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/jquery.countdown.min.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/jquery.elevatezoom.js') }}"></script>
<script src="{{asset('front_assets/js/vendors/slick.js') }}"></script>

    <script src="{{asset('front_assets/js/main.js?v=3.0.0')}}"></script>
    <script src="{{asset('front_assets/js/shop.js?v=1.2.1')}}"></script>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>






<script>
    function showToast(type, message) {
        // Clear existing toastr notifications before showing a new one
        toastr.clear();

        // Configure toastr options to prevent duplicate messages
        toastr.options = {
            preventDuplicates: true, // Prevent duplicate toasts
            closeButton: true,       // Add a close button for user control
            progressBar: true,       // Add a progress bar for timeout
           timeOut: 800,          // Set to 15 seconds (15000 milliseconds)
            extendedTimeOut: 5000           // Time in milliseconds before the toast disappears
        };

        // Display the toast message based on the type
        switch (type) {
            case 'success':
                toastr.success(message);
                break;
            case 'warning':
                toastr.warning(message);
                break;
            case 'error':
                toastr.error(message);
                break;
            case 'info':
                toastr.info(message);
                break;
            default:
                toastr.info(message); // Default to info if type is not recognized
        }
    }
</script>



<script type="text/javascript">
  
   function myCartFyunction() {
            $.ajax({
                url: "{{url('featch-cart')}}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}' 
                },
                success: function(res) {
                    $('#cartTable').html(res);
                }
            });
        }
</script>

<script type="text/javascript">
  
   function navmyCartFyunction() {
            $.ajax({
                url: "{{url('featch-cartnav')}}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}' 
                },
                success: function(res) {
                    $('#navcartTable').html(res);
                }
            });
        }
</script>
<script type="text/javascript">
function wishlistCount() {
    $.ajax({
        url: "{{ url('wishCount') }}",
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}', 
            wishlistCount: 'wishlistCount'
        },
        success: function(res) {
            console.log(res);
            let wishlistSpan = $('.wishlistCount');
            
            if (res.wish_count > 0) {
                wishlistSpan.html(res.wish_count).css("display", "inline-block"); // Show when > 0
            } else {
                wishlistSpan.hide(); // Hide when 0
            }
        }
    });
}

// Call function on page load
wishlistCount();

// Update count after adding an item to wishlist
$(document).on('click', '.addwishlist', function() {
    wishlistCount();
});
</script>

<script type="text/javascript">
     $(document).ready(function() {
         
        
         myCartFyunction();
         navmyCartFyunction();
        getCartCount();
        wishlistCount();
    });
</script>

<script type="text/javascript">
    function getCartCount() {
        $.ajax({
            url: "{{ url('cartCount') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}', 
                cartCount: 'getcartCount'
            },
            success: function(res) {
                console.log(res);
                let cartSpan = $('.cartcount');
                
                if (res.cart_count > 0) {
                    if (cartSpan.length) {
                        cartSpan.html(res.cart_count).show();
                    } else {
                        $(".icon-cart").append('<span class="number-item font-xs cartcount">' + res.cart_count + '</span>');
                    }
                } else {
                    cartSpan.hide();
                }
            }
        });
    }

    $(document).ready(function() {
        getCartCount(); // Call function on page load
    });
</script>

<script type="text/javascript">
  
  $(document).on('click','.add_to_cart',function(e){
e.preventDefault();


var qty = $('.qty').val();

var productvariantid = $('.productvariantid').val();


var product_id=$(this).data('product_id');
var created_by=$(this).data('created_by');
var productPrice = $('#product-price-' + product_id).text().replace('₹', '').trim();
var productdiscount = $('.product-discount').val();

var producttax = $('#product-tax-' + product_id).val();
$.ajax({
url:"{{url('add-to-cart')}}",
type:"POST",
dataType:"JSON",

data:{
qty:qty,
product_id:product_id,
productvariantid:productvariantid,
created_by:created_by,
productPrice:productPrice,
productdiscount:productdiscount,
producttax:producttax,

 _token: '{{ csrf_token() }}' 

},

success:function(res){
showToast(res.type, res.msg);



  myCartFyunction();
  navmyCartFyunction();
  getCartCount();


}

});



});
</script>

<script type="text/javascript">
  
  $(document).on('click', '.addtocart', function (e) {
    e.preventDefault();

    var $this = $(this);
    
    // Disable the button immediately and update text
    $this.prop('disabled', true).text('Adding...').css({
        'background-color': '#2E446B',
        'color': 'white',
        'border': 'none'
    });

    var qty = $this.data('qty');
    var productvariantid = $this.data('variantproductid');
    var product_id = $this.data('product_id');
    var productPrice = $('#product-price-' + product_id).val();
    var productdiscount = $('#product-discount-' + product_id).val();
    var producttax = $('#product-tax-' + product_id).val();
    var created_by = $('#created_by-' + product_id).val();

    $.ajax({
        url: "{{ url('add-to-cart') }}",
        type: "POST",
        dataType: "JSON",
        data: {
            qty: qty,
            product_id: product_id,
            productvariantid: productvariantid,
            productPrice: productPrice,
            created_by: created_by,
            productdiscount: productdiscount,
            producttax: producttax,
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            showToast(res.type, res.msg);

            myCartFyunction();
            navmyCartFyunction();
            getCartCount();

            // Change button text to "Added to Cart" and apply disabled styles
            $this.text('Added to Cart').css({
                'background-color': '#2E446B',
                'color': 'white',
                'border': 'none'
            }).addClass('disabled');
        },
        error: function () {
            // If there's an error, re-enable the button
            $this.prop('disabled', false).text('Add to Cart').css({
                'background-color': '', // Reset to original color
                'color': '',
                'border': ''
            });
        }
    });
});

</script>


<script type="text/javascript">
    

$(document).on('keyup change','.updateCartqty',function(e){
e.preventDefault();

if(e.keyCode == 8) {
//  alert('backspace pressed');
return false;
}

var qty=$(this).val();


var productid=$(this).data('productid');

var variantid=$(this).data('variantid');




$.ajax({
url:"{{url('update_Cart')}}",
type:"POST",
dataType:"JSON",

data:{
qty:qty,
variantid:variantid,
productid:productid,
 _token: '{{ csrf_token() }}' 

},

success:function(res){


 myCartFyunction();
navmyCartFyunction();
 

if(res.msg!=null){
showToast(res.type, res.msg);


}





}

});


});


</script>



<script type="text/javascript">
    


    $(document).on('click','.remove-cart',function(e){
e.preventDefault();

var product_id=$(this).data('product_id');

$.ajax({
  url: "{{url('removeCart')}}",
type:"POST",
dataType:"JSON",

data:{
product_id:product_id,
 _token: '{{ csrf_token() }}' 

},

success:function(res){
myCartFyunction();
 getCartCount();
 navmyCartFyunction();

showToast(res.type, res.msg);





}

});


});

 

</script>



 






<script type="text/javascript">
    $(document).ready(function() {

        function updateShippingAmount() {
            var checkedRadio = $('input[name="address"]:checked'); // Get checked radio button
            
            if (checkedRadio.length > 0) {
                var pincode = checkedRadio.data('pincode');
                var total = $('input[name="total"]').val();
                var totaltax = $('input[name="totaltax"]').val();
                var productIds = [];

                // Loop through each hidden input and get the product_id values
                $('.product_id').each(function() {
                    productIds.push($(this).val());
                });

                // Clear any previous error message
                $('#pincode-error').remove();

                // Disable button and show spinner
                $('#applycoupns')
                    .prop('disabled', true);

      
            
                   

                // Send the data via AJAX
                $.ajax({
                    url: '{{ url("getuserdatawithproduct") }}', // Replace with your route
                    method: 'POST',
                    data: {
                        pincode: pincode,
                        product_ids: productIds,
                        total: total,
                        totaltax: totaltax,
                        _token: '{{ csrf_token() }}' // Include CSRF token for security
                    },
                    success: function(response) {
                        // Handle success response
                        console.log(response);

                        if (response.success) {
                            // Update shipping and grand total values in the HTML
                            $('.shippingtotal').text(response.shippingTotal == 0 ? '-' : '₹' + response.shippingTotal);
                           $('.grandstotal').text('₹' + parseFloat(response.grandTotal).toFixed(2));


                            // Also assign these values to the input fields
                            $('input[name="shippingtotal"]').val(response.shippingTotal);
                            $('input[name="grandtotal"]').val(response.grandTotal);

                            // Loop through each product and assign shipping amounts
                            $.each(response.productShipping, function(index, productData) {
                                // Find the corresponding product and set the shipping amount
                                $('.product_id').each(function() {
                                    if ($(this).val() == productData.product_id) {
                                        // Assign the shipping amount to the product's corresponding input field
                                        $(this).closest('.item-wishlist').find('.shippingofproduct').val(productData.shipping_amount);
                                    }
                                });
                            });

                        } else {
                            toastr.warning("Pincode not serviceable");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        alert('An error occurred while processing your request.');
                    },
                    complete: function() {
                        // Re-enable button after response
                        $('#applycoupns')
                            .prop('disabled', false)
                           
                             
                    }
                });
            }
        }

        // Bind click event to radio buttons
        $('.pincode').on('click', function() {
            updateShippingAmount();
        });

        // Call function on page load for checked radio button
        updateShippingAmount();
    });
</script>




<script type="text/javascript">
  $(document).ready(function() {
    // Trigger when category is selected
    $('#category-select').on('change', function() {
        var categoryId = $(this).val(); // Get the selected category ID
         
        // Check if a category is selected
        if (categoryId) {
            $.ajax({
                url: "{{url('admin/country-change')}}", // Route to handle the AJAX request
                type: 'POST',
                data: {
                    category_id: categoryId,
                    _token: '{{ csrf_token() }}' // Laravel CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        var statename = response.statename;
                        
                        // Clear and populate the state select box
                        $('#State-select').empty();
                        $('#State-select').append('<option value="">Select State</option>');
                        
                        $.each(statename, function(key, state) {
                            $('#State-select').append('<option value="'+state.id+'">'+state.name+'</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            // Clear state select box if no category is selected
            $('#State-select').empty();
            $('#State-select').append('<option value="">Select State</option>');
        }
    });

    // Trigger when a state is selected to load cities
    $('#State-select').on('change', function() {
        var stateId = $(this).val(); // Get the selected state ID

        if (stateId) {
            $.ajax({
                url: "{{url('admin/state-change')}}", // Route to handle the city request
                type: 'POST',
                data: {
                    state_id: stateId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var cities = response.cities;
                        $('#city-select').empty();
                        $('#city-select').append('<option value="">Select City</option>');

                        $.each(cities, function(key, city) {
                            $('#city-select').append('<option value="'+city.id+'">'+city.name+'</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#city-select').empty();
            $('#city-select').append('<option value="">Select City</option>');
        }
    });

    // Trigger when a city is selected to load zipcodes
    $('#city-select').on('change', function() {
        var cityId = $(this).val(); // Get the selected city ID

        if (cityId) {
            $.ajax({
                url: "{{url('admin/city-change')}}", // Route to handle the zipcode request
                type: 'POST',
                data: {
                    city_id: cityId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var zipcodes = response.zipcodes;
                        $('#zipcode-select').empty(); // Clear the existing zipcodes
                        $('#zipcode-select').append('<option value="">Select Zipcode</option>'); // Add the default option

                        $.each(zipcodes, function(key, zipcode) {
                            $('#zipcode-select').append('<option value="'+zipcode+'">'+zipcode+'</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#zipcode-select').empty();
            $('#zipcode-select').append('<option value="">Select Zipcode</option>');
        }
    });
  });
</script>




<script type="text/javascript">
$(document).on('click', '.addwishlist', function (e) {
    e.preventDefault();

    var $this = $(this); // Store the clicked element
    var productvariant_id = $this.data('productvariant_id');
    var productid = $this.data('productid');

    $.ajax({
        url: "{{ url('save-wishlist') }}",
        type: "POST",
        dataType: "JSON",
        data: {
            productid: productid,
            productvariant_id: productvariant_id,
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            if (res.type === 'error' && res.msg === 'Please login') {
                showToast(res.type, res.msg);
            } else if (res.type === 'added') {
                showToast('success', res.msg);
                wishlistCount();
                // Add the active class when added to wishlist
                $this.addClass('activeheart');
            } else if (res.type === 'removed') {
                showToast('success', res.msg);
                wishlistCount();
                // Remove the active class when removed from wishlist
                $this.removeClass('activeheart');
            }
        },
        error: function (xhr, status, error) {
            console.error('An error occurred:', error);
        }
    });
});

</script>






























