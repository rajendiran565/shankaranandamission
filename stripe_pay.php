<?php
include_once('./includes/csrf_token.php');
include_once('./includes/crud.php');
include_once('./includes/custom-functions.php');

$db = new Database();
$db->connect();
$db->sql("SET NAMES utf8");
$function = new custom_functions();


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
<title>Shankarananda Mission Foundation</title>
  <!-- css include -->
  <link rel='stylesheet' id='bootstrap-css' href='assets/css/bootstrap.min.css' type='text/css' media='all' />
  <link rel='stylesheet' id='fontawesome-css' href='assets/css/font-awesome.min.css' type='text/css' media='all' />
  <link rel='stylesheet' id='theme-css-css' href='assets/css/theme-style.css' type='text/css' media='all' />
  <link rel='stylesheet' id='peace-style-css' href='style.css' type='text/css' media='all' />
  <link rel='stylesheet' id='masterslider-css' href='assets/css/masterslider.main.css' type='text/css' media='all' />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet"> 
<link href="assets/css/datepicker.css" rel="stylesheet" />
<link href='assets/css/fullcalendar.min.css' rel='stylesheet' />
<link href='assets/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
  <link rel='stylesheet' id='theme-css-css' href='assets/css/event-style.css' type='text/css' media='all' />
  
  <!-- js inlcude -->
  <script type='text/javascript' src='assets/js/jquery.js'></script>
    <script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<script> 
$(function(){
  $("#main_menu").load("header_html.php"); 
  $("#footer").load("footer_html.php"); 
});
</script> 
<link rel='stylesheet' href='style_s.css' type='text/css' media='all' /> 
</head>
<body class="home page">
  <!-- preloader start  -->
<div id="main_menu"></div>

<section id="blog-heading">
   <div class="heading-section">
   <div class="container">

      <div style="width:700px; margin:0px auto !important;">
      <h2><?=!empty($_SESSION['donate_desc'])?$_SESSION['donate_desc']:'';?></h2>
      <h1>Amount: <?=number_format($_SESSION['donate_amount']);?></h1>
      
      <!-- Display status message -->
      <div id="stripe-payment-message" class="hidden"></div>

      <p><strong></strong></p>

      <form id="stripe-payment-form" class="hidden">
         <input type='hidden' id='publishable_key' value='pk_live_51OaJKXH7WXIVvYYAw6ggCIbO23mlR9DlcrVc6ci1qqiwUdZYuPoGjM7vkENG3NFF2ynLIG2DjqMJjNJQFbT0IHNd00k3DyiknO'>
         <div class="form-group">
            <input type="hidden" id="fullname" value="<?=$_SESSION['name'];?>" class="form-control" maxlength="50" required autofocus>
         </div>
         <div class="form-group">
            <input type="hidden" id="email" value="<?=$_SESSION['email'];?>" class="form-control" maxlength="50" required>
         </div>
         <h3>Enter Credit Card Information</h3>
         <div id="stripe-payment-element">
              <!--Stripe.js will inject the Payment Element here to get card details-->
         </div>

         <button id="submit-button" class="pay">
            <div class="spinner hidden" id="spinner"></div>
            <span id="submit-text">Pay Now</span>
         </button>
      </form>

      <!-- Display the payment processing -->
      <div id="payment_processing" class="hidden">
         <span class="loader"></span> Please wait! Your payment is processing...
      </div>

      <!-- Display the payment reinitiate button -->
      <div id="payment-reinitiate" class="hidden">
         <button class="btn btn-primary" onclick="reinitiateStripe()">Reinitiate Payment</button>
      </div>

      <br>
      <div style="clear:both;"></div>

      </div> 
   </div>
   </div>
</section>  


<script src="https://js.stripe.com/v3/"></script>
<script src="stripe-checkout.js" defer></script>

<!-- start footer widget -->

<div id="footer"></div>

<!-- js include -->
<script type='text/javascript' src='assets/js/plugins.js'></script>
<script type='text/javascript' src='assets/js/masterslider.min.js'></script>
<script type='text/javascript' src='assets/js/functions.js'></script>
<!-- custom -->
</body>
</html>