<?php
//require_once 'config.php'; 
?>
<html>
<head>
<title>Demo Integrate Stripe Payment Gateway using PHP - AllPHPTricks.com</title>
<link rel='stylesheet' href='style_s.css' type='text/css' media='all' />
</head>
<body>

<div style="width:700px; margin:50 auto;">
<h1>Demo Integrate Stripe Payment Gateway using PHP</h1>

<!-- Display status message -->
<div id="stripe-payment-message" class="hidden"></div>

<p><strong>Charge $10.00 with Stripe Demo Payment</strong></p>

<form id="stripe-payment-form" class="hidden">
   <input type='hidden' id='publishable_key' value='pk_live_51OaJKXH7WXIVvYYAw6ggCIbO23mlR9DlcrVc6ci1qqiwUdZYuPoGjM7vkENG3NFF2ynLIG2DjqMJjNJQFbT0IHNd00k3DyiknO'>
   <div class="form-group">
      <label><strong>Full Name</strong></label>
      <input type="text" id="fullname" class="form-control" maxlength="50" required autofocus>
   </div>
   <div class="form-group">
      <label><strong>E-Mail</strong></label>
      <input type="email" id="email" class="form-control" maxlength="50" required>
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
<script src="https://js.stripe.com/v3/"></script>
<script src="stripe-checkout.js" defer></script>
</body>
</html>