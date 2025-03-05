<!DOCTYPE html>

<?php
$Symbol = \Helpers::getActiveCurrencySymbol();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .header { background-color: #FD9636; color: white; padding: 10px; text-align: center; font-size: 20px; }
        .order-details { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f4; }
        .footer { margin-top: 20px; font-size: 14px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Thank You for Your Order!
        </div>
        <p>Hello,</p>
        <p>We’ve received your order and are processing it now. Below are your order details:</p>
        
        <div class="order-details">
         
            <strong>Payment Method:</strong> {{ ucfirst(strtolower($orderDetails['payment_method'])) }}<br>

            <strong>Total Amount:</strong> {{$Symbol}}{{ number_format($orderDetails['grandTotalamount'], 2) }}<br>
        </div>

        <h3>Order Summary:</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{$item['product_name'] }}</td>
                    <td>{{$item['qty'] }}</td>
                    <td>{{$Symbol}}{{ number_format($item['product_price'], 2) }}</td>
                    <td>{{$Symbol}}{{ number_format($item['product_price'] * $item['qty'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            If you have any questions, contact us at {{ setting('email') }}<br>
            Thank you for shopping with us!
        </div>
    </div>
</body>
</html>
