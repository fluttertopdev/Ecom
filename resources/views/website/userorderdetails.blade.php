@extends('website.layout.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<style type="text/css">

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center; /* Align the items vertically */
    }


    h2.content-title {
        margin: 0; /* Remove any default margin */
    }

    .btn {
        margin-left: auto; /* Push the button to the far right */
    }

    .star-rating .star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s;
    }

    .star-rating .star.selected,
    .star-rating .star.hovered {
        color: #f39c12;
    }

    #addreview {
        transition: all 0.3s ease;
    }

    #addreview:hover {
        background-color: #45a049; /* Darker green on hover */
        transform: translateY(-2px); /* Lift effect */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
    }

    #printOrderButton {
        transition: all 0.3s ease;
    }

    #printOrderButton:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: translateY(-2px); /* Slight lift effect */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Enhanced shadow effect */
    }

    .wrapper {
        width: 100%;
        margin: 20px auto;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .top-bar h1 {
        font-size: 18px;
        color: #333;
    }

    .top-bar .verification-code {
        font-size: 16px;
        color: #007bff;
    }

    .top-bar .date-label {
        font-size: 14px;
        color: #555;
        margin-top: 5px;
    }

    .print-button {
        display: inline-block;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
    }

    .print-button:hover {
        background-color: #0056b3;
    }

    .content-section {
        margin-bottom: 20px;
    }

    .content-section h2 {
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }

    .info-box {
        display: flex;
        justify-content: space-between;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        background-color: #f8f9fa;
    }

    .info-row {
        display: flex;
        align-items: center;
        margin-bottom: 10px; /* Space between rows */
    }

    .info-row h3 {
        font-size: 14px;
        font-weight: bold;
        color: #555;
        margin: 0;
        margin-right: 10px; /* Space between label and value */
    }

    .info-row p.info-value {
        font-size: 14px;
        font-weight: bold; /* Bold value text */
        color: #333;
        margin: 0;
    }

    .info-row p {
        font-size: 14px;
        margin: 0;
        color: #555;
    }

    .info {
        width: 48%;
    }

    .info h3 {
        font-size: 14px;
        color: #555;
    }

    .info p {
        font-size: 14px;
        margin: 2px 0;
        color: #555;
    }

    .order-details {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .order-details th, .order-details td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .order-details th {
        background-color: #f8f9fa;
        color: #333;
    }

    .totals {
        width: 100%;
        border-collapse: collapse;
    }

    .totals td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    .totals .total-label {
        text-align: right;
        font-weight: bold;
        color: #333;
    }

    .totals .total-amount {
        text-align: right;
        color: #007bff;
        font-weight: bold;
    }

    .cancel-order-button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #ff4d4d;
        color: #fff;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
    }

    .cancel-order-button:hover {
        background-color: #e60000;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .wrapper {
            padding: 10px;
        }

        .top-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .top-bar h1 {
            font-size: 16px;
        }

        .top-bar .verification-code,
        .top-bar .date-label {
            font-size: 14px;
        }


        .content-section h2 {
            font-size: 14px;
        }

        .info-box {
            flex-direction: column;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .info-row h3 {
            font-size: 13px;
        }

        .info-row p {
            font-size: 13px;
        }

        .order-details th, .order-details td {
            font-size: 14px;
        }

        .totals .total-label,
        .totals .total-amount {
            font-size: 14px;
        }

        .cancel-order-button {
            font-size: 14px;
        }

        #addreview {
            font-size: 14px;
            padding: 10px 15px;
        }
    }

    @media (max-width: 480px) {
        .top-bar h1 {
            font-size: 14px;
        }

        .top-bar .verification-code,
        .top-bar .date-label {
            font-size: 12px;
        }

        .info-box {
            padding: 10px;
        }

        .info {
            width: 100%;
            margin-bottom: 10px;
        }

        .order-details th, .order-details td {
            font-size: 12px;
            padding: 8px;
        }

        .totals .total-label,
        .totals .total-amount {
            font-size: 12px;
        }

        .cancel-order-button {
            font-size: 12px;
            padding: 8px;
        }

        #addreview {
            font-size: 13px;
            padding: 8px 12px;
        }
    }

</style>

<main class="main-wrap">
    <div class="container">
        <section class="content-main">
            <div class="">
                @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        showConfirmButton: true
                    });
                </script>
                @endif
                <?php
                $Symbol = \Helpers::getActiveCurrencySymbol();
                ?>
            </div>

            <div class="wrapper">
                <div class="top-bar">
                    <h1>Order Summary</h1>
                    <div>
                        <span class="verification-code">Order Code: <strong>{{ $myordersdetails->order_key }}</strong></span>
                        <div class="date-label">Date: {{$myordersdetails->created_at->format('D, M d, Y') }}</div>
                    </div>
                </div>

                <div class="content-section">
                    <h2>Payment Info</h2>
                    <div class="info-box">
                        <div class="info">
                            <div class="info-row">
                                <h3>Payment Status:</h3>
                                <p class="info-value">
                                    @if ($myordersdetails->payment_method !== 'cash' && $myordersdetails->payment_status == 'pending')
                                    FAILED
                                    @else
                                    {{ ucwords($myordersdetails->payment_status) }}
                                    @endif
                                </p>
                            </div>
                            <div class="info-row">
                                <h3>Payment Method:</h3>
                                <p class="info-value">{{ ucwords($myordersdetails->payment_method) }}</p>
                            </div>
                        </div>

                        <div class="info">
                            <h3>Shipping Address</h3>
                            <p>Name: {{$deliveryaddress->name}}</p>
                            <p>Email: {{$deliveryaddress->email}}</p>
                            <p>Phone: {{$deliveryaddress->phone}}</p>
                            <p>City/Zip: {{$deliveryaddress->city->name}},{{$deliveryaddress->zip_code}}</p>
                            <p>Address: {{$deliveryaddress->address}}</p>
                        </div>

                        <div class="info">
                            <h3>Customer Contact</h3>
                            <p>Name: {{$myordersdetails->user->name}}</p>
                            <p>Email: {{$myordersdetails->user->email}}</p>
                            <p>Phone: {{$myordersdetails->user->phone}}</p>
                        </div>
                    </div>
                </div>

                <div class="content-section">
                    <h2>Order Details</h2>
                    <table class="order-details">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $myordersdetails->product->name }}<br>
                                    <span>{{ $myordersdetails->productVariantValue->color_variant ?? '' }}</span><br>
                                    <span>{{ $myordersdetails->productVariantValue->text_variant ?? '' }}</span>
                                </td>
                                <td>{{$myordersdetails->order_quantity}}</td>
                                <td>{{$Symbol}}{{ number_format($myordersdetails->product_price + $myordersdetails->producttax, 2, '.', ',') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="totals">
                        <tr>
                            <td class="total-label">Subtotal</td>
                            <td class="total-amount">{{$Symbol}}{{ number_format($myordersdetails->product_price, 2, '.', ',') }}</td>
                        </tr>

                        @if(!empty($myordersdetails->tax_details))
                        @foreach($myordersdetails->tax_details as $tax)
                        <tr>
                            <td class="total-label">{{ $tax['tax_name'] }}</td>
                            <td class="total-amount">{{$Symbol}}{{ number_format($tax['tax_value'], 2, '.', ',') }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="total-label">Tax Fee</td>
                            <td class="total-amount">₹0</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="total-label">Shipping Fee</td>
                            <td class="total-amount">{{$Symbol}}{{ number_format($myordersdetails->shipping_amount ?? 2, 0, '.', ',') }}</td>
                        </tr>

                        @if(!empty($myordersdetails->discountamount) && $myordersdetails->discountamount > 0)
                        <tr>
                            <td class="total-label">Coupon Discount</td>
                            <td class="total-amount">{{$Symbol}}{{ number_format($myordersdetails->discountamount, 2, '.', ',') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="total-label">Total</td>
                            <td class="total-amount">{{$Symbol}}{{ number_format($myordersdetails->order_total ?? 2, 0, '.', ',') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if(empty($reviews->order_id) && $myordersdetails->status == 'delivered')
            <div class="d-flex justify-content-end mb-5">
                <button type="button" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm" id="addreview" style="font-size: 1rem; font-weight: 600; text-transform: uppercase; background-color: #FD9636; border: none; color: #fff;">
                    <i class="fa fa-edit me-2"></i> Write Review
                </button>
            </div>
            @endif
        </section>
    </div>
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

                        <input type="hidden" name="product_id" value="{{ $myordersdetails->product->id }}">
                         <input type="hidden" name="order_id" value="{{ $myordersdetails->id }}">

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
<script type="text/javascript">
    $(document).on('click', '#addreview', function(){
      

        $('#addreviewmodal').modal('show'); 
     
        
       
    });

    
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingValue = document.getElementById('rating-value');

        stars.forEach(star => {
            // Add click event to set the rating
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

            // Add hover effect for left-to-right star selection
            star.addEventListener('mouseover', function () {
                stars.forEach(s => s.classList.remove('hovered'));
                this.classList.add('hovered');
                let prev = this.previousElementSibling;
                while (prev) {
                    prev.classList.add('hovered');
                    prev = prev.previousElementSibling;
                }
            });

            // Remove hover effect when mouse leaves the star
            star.addEventListener('mouseout', function () {
                stars.forEach(s => s.classList.remove('hovered'));
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("add-review-form");
        const ratingInput = form.querySelector("input[name='rating']");
        const stars = document.querySelectorAll(".star");
        const starRatingContainer = document.getElementById("star-rating");

        // Create an error message element
        const ratingErrorMsg = document.createElement("div");
        ratingErrorMsg.classList.add("invalid-feedback");
        ratingErrorMsg.style.display = "none"; // Hidden by default
        ratingErrorMsg.textContent = "Please provide a star rating.";
        starRatingContainer.appendChild(ratingErrorMsg);

        // Update the rating value when a star is clicked
        stars.forEach(star => {
            star.addEventListener("click", function () {
                const value = this.getAttribute("data-value");
                ratingInput.value = value;

                // Highlight selected stars
                stars.forEach(s => s.classList.remove("selected"));
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add("selected");
                }

                // Hide the error message on valid input
                if (value > 0) {
                    ratingErrorMsg.style.display = "none";
                }
            });
        });

        // Form submission validation
        form.addEventListener("submit", function (e) {
            let isValid = true;

            // Validate star rating
            if (ratingInput.value === "0") {
                ratingErrorMsg.style.display = "block";
                isValid = false;
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>


@endsection
