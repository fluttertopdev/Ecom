@extends('admin.layouts.app')
@section('content')

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
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
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
            display: flex;
            justify-content: space-between;
        }

        .order-info, .account-info {
            width: 48%;
        }

        .order-info h3, .account-info h3 {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .order-info ul, .account-info ul {
            list-style: none;
        }

        .order-info ul li, .account-info ul li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .order-info ul li strong, .account-info ul li strong {
            width: 150px;
            display: inline-block;
        }

        .order-info ul li select, .order-info ul li input[type="text"] {
            padding: 5px;
            width: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .address-info {
            margin-top: 40px;
        }

        .billing-shipping {
            display: flex;
            justify-content: space-between;
        }

        .billing-address, .shipping-address {
            width: 48%;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Home Page Management</h2>
            <div class="icons">
                <i class="fas fa-envelope"></i>
                <i class="fas fa-print"></i>
            </div>
        </div>

        <div class="content">
            <div class="order-info">
                <h3>Main Banner</h3>
                
            </div>

           
        </div>

       

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('shippingMethod').addEventListener('change', function () {
                var selectedMethod = this.value;
                var trackingCodeContainer = document.getElementById('trackingCodeContainer');
                
                if (selectedMethod === 'fedex') {
                    trackingCodeContainer.style.display = 'block'; // Show tracking code field
                } else {
                    trackingCodeContainer.style.display = 'none'; // Hide tracking code field
                }
            });
        });
    </script>
</body>
</html>

@endsection

