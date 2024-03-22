<?php
include_once('./includes/csrf_token.php');
include_once('./includes/crud.php');
include_once('./includes/custom-functions.php');
include_once('./library/send-email2.php');

$db = new Database();
$db->connect();
$db->sql("SET NAMES utf8");
$function = new custom_functions();

// If transaction ID is not empty 
if(!empty($_GET['tid'])){
    $transaction_id  = $_GET['tid'];
    $sql = "select * from stripe_payment WHERE transaction_id='".$transaction_id."'";
    $db->sql($sql);
    $res = $db->getResult();
    $num_rows = $db->numRows($res);
    if($num_rows > 0){
        $fullname = $res[0]['fullname'];
        $email = $res[0]['email'];
        $item_description = $res[0]['item_description'];
        $currency = $res[0]['currency'];
        $amount = $res[0]['amount'];
        $status = $res[0]['payment_status'];
        if(!empty($status) && $status == 'succeeded'){
            $to = $email;
            $subject = 'Thank You for Your Generous Donation!';
            $message = "<p>We are incredibly grateful for your generous donation of $amount to Shankarananda Mission. Your contribution has been successfully received. Thanks to your support.</p>";
            send_email($to,$subject,$message);
        }
    }
}else{ 
    header("Location: donate.php"); 
    exit(); 
} 
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

        <?php if(!empty($status) && $status == 'succeeded'){ ?>
            <h2 style="color: #327e00;">Success! Your payment has been received successfully.</h2>
            <h3>Payment Receipt:</h3>
            <p><strong>Full Name:</strong> <?php echo $fullname; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Transaction ID:</strong> <?php echo $transaction_id; ?></p>
            <p><strong>Amount:</strong> <?php echo $amount.' '.$currency; ?></p>
            <p><strong>Description:</strong> <?php echo $item_description; ?></p>
        <?php }else{ ?>
            <h1>Error! Your transaction has been failed.</h1>
        <?php } ?>

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