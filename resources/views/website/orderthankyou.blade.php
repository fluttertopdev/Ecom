
<style type="text/css">
  *{
  box-sizing:border-box;
 /* outline:1px solid ;*/
}
body{
background: #ffffff;
background: linear-gradient(to bottom, #ffffff 0%,#e1e8ed 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e1e8ed',GradientType=0 );
    height: 100%;
        margin: 0;
        background-repeat: no-repeat;
        background-attachment: fixed;
  
}

.wrapper-1{
  width:100%;
  height:100vh;
  display: flex;
flex-direction: column;
}
.wrapper-2{
  padding :30px;
  text-align:center;
}
h1{
    font-family: 'Kaushan Script', cursive;
  font-size:4em;
  letter-spacing:3px;
  color:#5892FF ;
    color: #FD9636;
  margin:0;
  margin-bottom:20px;
}
.wrapper-2 h4 {
    margin: 0;
    font-size: 1.3em;
    margin-bottom: 14px;
    color: #3e3e3e;
    font-family: 'Source Sans Pro', sans-serif;
    letter-spacing: 1px;
}
.wrapper-2 p {
    margin: 0;
    color: #5f5f5f;
    font-family: 'Source Sans Pro', sans-serif;
    letter-spacing: 1px;
    font-size: 18px;
}
.go-home{
  color:#fff;
  background:#5892FF;
  background: #FD9636;
  border:none;
  padding:10px 50px;
  margin:30px 0;
  border-radius:30px;
  text-transform:capitalize;
  cursor:pointer;
  box-shadow: 0 10px 16px 1px rgba(174, 199, 251, 1);
}
.footer-like{
  margin-top: auto; 
  background:#D7E6FE;
    background: #dadada;
  padding:6px;
  text-align:center;
}
.footer-like p{
  margin:0;
  padding:4px;
  color:#5892FF;
  font-family: 'Source Sans Pro', sans-serif;
  letter-spacing:1px;
}
.footer-like p a{
  text-decoration:none;
  color:#5892FF;
  font-weight:600;
}

@media (min-width:360px){
  h1{
    font-size:4.5em;
  }
  .go-home{
    margin-bottom:20px;
  }
}

@media (min-width:600px){
  .content{
  max-width:1000px;
  margin:0 auto;
}
  .wrapper-1{
  height: initial;
  max-width:620px;
  margin:0 auto;
  margin-top:100px;
  box-shadow: 4px 8px 40px 8px rgba(88, 146, 255, 0.2);
}
  
}
</style>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#0E0E0E">
    <meta name="template-color" content="#0E0E0E">
    <meta name="description" content="Index page">
    <meta name="keywords" content="index, page">
    <meta name="author" content="">
   
   
   <link rel="shortcut icon" type="image/x-icon" href="{{url('uploads/setting/'.setting('favicon'))}}">
   <link href="{{asset('front_assets/css/style.css?v=3.0.0')}}" rel="stylesheet">
    <link href="{{asset('front_assets/css/custom.css')}}" rel="stylesheet">
    <title>Ecom</title>
  </head>
<body>

<div class=content>
  <div class="wrapper-1">
    <div class="wrapper-2">
      <h1>Thank you !</h1>
      <h4>Thank you for your order</h4>
      <p>Your order is now being processed, and you’ll receive a confirmation email with all the details shortly. If you have any questions, feel free to reach out</p>
      

      <a href="{{url('my-account#tab-orders')}}"><button class="go-home">
      View Order
      </button></a>
        <a href="{{url('index')}}"><button class="go-home">
      Continue Shopping
      </button></a>
    </div>
    
</div>
</div>



<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Source+Sans+Pro" rel="stylesheet">
<!-- partial -->
  
</body>
</html>

<script type="text/javascript">
    // Check if the current page is 'order-complete'
    if (window.location.pathname.includes('order-complete')) {
        // Redirect after 5 seconds
        setTimeout(function() {
            window.location.href = "{{ url('my-account#tab-orders') }}";
        }, 5000); // 5000ms = 5 seconds
    }
</script>