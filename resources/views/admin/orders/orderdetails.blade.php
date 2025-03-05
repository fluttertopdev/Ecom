@extends('admin.layouts.app')
@section('content')

<?php
$Symbol = \Helpers::getActiveCurrencySymbol();
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order & Account Information</title>
   <style type="text/css">
       

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
       
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
        }
        
        
.ordercontainer {
background-color: #fff;
border-radius: 8px;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
padding: 20px;
width: 99%;
margin: 0 auto;
}

.header {
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 20px;
}

.header h2 {
font-size: 22px;
font-weight: 600;
}

.header .icons {
font-size: 20px;
}

.header .icons i {
margin-left: 15px;
cursor: pointer;
}

.content {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 20px;
}

.order-info, .account-info {
padding: 20px;
background-color: #fafafa;
border-radius: 8px;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
position: relative;
}

.order-info h3, .account-info h3 {
font-size: 18px;
font-weight: 600;
margin-bottom: 15px;
position: relative;
}

.order-info ul, .account-info ul {
list-style: none;
padding-left: 0;
margin-top: 10px;
}

.order-info ul li, .account-info ul li {
margin-bottom: 10px;
font-size: 16px;
}

.order-info ul li strong, .account-info ul li strong {
width: 150px;
/*display: inline-block;*/
font-weight: 600;
}

.order-info ul li select, .order-info ul li input[type="text"] {
padding: 5px;
width: auto;
border: 1px solid #ccc;
border-radius: 5px;
}

.address-info {
margin-top: 30px;
}

.billing-shipping {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 20px;
}

.billing-address, .shipping-address {
padding: 20px;
background-color: #fafafa;
border-radius: 8px;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.billing-address h4, .shipping-address h4 {
font-size: 18px;
font-weight: 600;
margin-bottom: 10px;
}

.items-ordered {
margin-top: 30px;
}

table {
width: 100%;
border-collapse: collapse;
margin-top: 10px;
}

table th, table td {
padding: 10px;
text-align: left;
border-bottom: 1px solid #ddd;
}

table thead th {
background-color: #f4f4f4;
font-weight: 600;
}

tfoot tr td {
font-weight: 600;
text-align: right;
}
.tax-name, .tax-value {
display: inline-block; /* Keep elements aligned */
vertical-align: top; /* Align the text to the top */
line-height: 1.5; /* Ensure spacing between lines */
}
td:nth-child(5), td:nth-child(6) {
text-align: left; /* Align both columns to the left */
padding: 5px; /* Add padding for better spacing */
}

   </style>
</head>
<body>
    <div class="ordercontainer" id="printableSection">
       <!--  <div class="header">
            <h2>Order & Account Information</h2>
            <div class="icons">
                <i class="fas fa-envelope"></i>
                <i class="fas fa-print" id="printButton" style="cursor: pointer;" onclick="window.print();"></i>
            </div>
        </div> -->

        <div class="content">
            <div class="order-info">
                <h3>Order Information</h3>
                <ul>
                    <li>Order Code:<span>{{$orderProduct->order_key}}</span></li>
                    <li>Order Date:<span>{{ \Helpers::commonDateFormate($orderProduct->created_at) }}</span></li>
                   
                    <li id="trackingCodeContainer" style="display:none;">
                        Tracking Code:
                        <input type="text" id="trackingCode" placeholder="Enter tracking code">
                    </li>
                    <li>Payment Method:<span>{{ ucwords($orderProduct->payment_method) }}</span></li>
                </ul>
            </div>

            <div class="account-info">
                <h3>Account Information</h3>
                <ul>
                    <li>Customer Name:<span>{{$orderProduct->user->name}}</span></li>
                    <li>Customer Email:<span>{{$orderProduct->user->email}}</span></li>
                    <li>Customer Phone:<span>{{$orderProduct->user->phone}}</span></li>
                </ul>
            </div>
        </div>

        <div class="address-info">
            <h3>Address Information</h3>
            <div class="billing-shipping">
                <div class="billing-address">
                    <h4>Billing Address</h4>
                    <p>{{$orderProduct->user->address}}</p>
                </div>
                <div class="shipping-address">
                    <h4>Shipping Address</h4>
                    <p>{{$deliveryaddress->address}}<br>{{$deliveryaddress->city->name}}, {{$deliveryaddress->zip_code}}<br>{{$deliveryaddress->state->name}}, {{$deliveryaddress->country->name}}</p>
                </div>
            </div>
        </div>

        <div class="items-ordered">
            <h3>Items Ordered</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $orderProduct->order_key }}</td>
                        <td>
                            <strong>{{ $orderProduct->product->name }}</strong><br>
                            <span>{{ $orderProduct->productVariantValue->color_variant ?? '' }}</span><br>
                            <span>{{ $orderProduct->productVariantValue->text_variant ?? '' }}</span>
                        </td>
                        <td>
                            @if($orderProduct->productVariantValue)
                              
                            

                                {{$Symbol}}{{ number_format($orderProduct->singleproduct_price  , 0, '.', ',') }}
                            @else
                               
                            

                                {{$Symbol}}{{ number_format($orderProduct->singleproduct_price  , 0, '.', ',') }}
                                
                            @endif
                        </td>
                        <td>{{ $orderProduct->order_quantity }}</td>
   <td>
    <select class="form-control productStatus" data-order-product-id="{{ $orderProduct->id }}" 
        {{ $orderProduct->status === 'delivered' ? 'disabled' : '' }}>
        <option value="pending" {{ $orderProduct->status === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="confirmed" {{ $orderProduct->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
        <option value="Picked-up" {{ $orderProduct->status === 'Picked-up' ? 'selected' : '' }}>Picked-up</option>
        <option value="On-the-way" {{ $orderProduct->status === 'On-the-way' ? 'selected' : '' }}>On the way</option>
        <option value="delivered" {{ $orderProduct->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
    </select>
</td>

                        <td>
                            @if($orderProduct->productVariantValue)
                            
                                 {{$Symbol}}{{ number_format($orderProduct->singleproduct_price *$orderProduct->order_quantity, 0, '.', ',') }}


                                

                            @else
                             {{$Symbol}}{{ number_format($orderProduct->singleproduct_price *$orderProduct->order_quantity, 0, '.', ',') }}
                            @endif
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td>Subtotal</td>
                        <td> {{$Symbol}}{{ number_format($orderProduct->product_price, 0, '.', ',') }}</td>
                    </tr>
                    
<tr>
    <td colspan="4"></td>
    <td><strong>Tax Fees</strong></td>
    <td>
        @if(!empty($orderProduct->tax_details) && count($orderProduct->tax_details) > 0)
            @foreach($orderProduct->tax_details as $tax)
                <span class="tax-name">{{ $tax['tax_name'] }}:</span>
                <span class="tax-value">+ {{$Symbol}}{{ number_format($tax['tax_value'], 0, '.', ',') }}</span><br>
            @endforeach
        @endif
    </td>
</tr>


                    <tr>
                        <td colspan="4"></td>
                        <td>Shipping</td>
                        <td>+{{$Symbol}}{{$orderProduct->shipping_amount}}</td>
                    </tr>
                    
                     <tr>
                        <td colspan="4"></td>
                        <td>Coupons discount</td>
                        <td>-{{$Symbol}}{{$orderProduct->discountamount ?? 00}}</td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="4"></td>
                        <td><strong>Total Amount</strong></td>
                        <td><strong> {{$Symbol}}{{ number_format($orderProduct->order_total, 0, '.', ',') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>





<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $('.productStatus').on('change', function () {
            // Get the selected status and the product ID
            var status = $(this).val();
            var orderProductId = $(this).data('order-product-id');
            
            // Make the AJAX request to update the status
            $.ajax({
                url: "{{ url('admin/update-order-status') }}", // Your controller route
                method: 'POST',
                data: {
                    orderProductId: orderProductId,
                    status: status,
                    _token: '{{ csrf_token() }}' // CSRF token for security
                },
                success: function (response) {
                    // Show SweetAlert based on the response
                    if (response.success) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Product status updated successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success' // Optional: Add a class for styling the button
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'There was an error updating the product status.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-danger' // Optional: Add a class for styling the button
                            }
                        });
                    }
                },
                error: function () {
                    // Handle errors if any
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-danger' // Optional: Add a class for styling the button
                        }
                    });
                }
            });
        });
    });
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".productStatus").forEach(function (dropdown) {
        dropdown.addEventListener("change", function () {
            if (this.value === "delivered") {
                this.disabled = true; // Disable the select dropdown when "delivered" is selected
            }
        });
    });
});
</script>

@endsection