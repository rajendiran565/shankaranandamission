<?php
include_once('./includes/csrf_token.php');
include_once('./includes/crud.php');
include_once('./includes/custom-functions.php');
if(!isset($_SESSION['user_id'])) {
    header("Location: ".DOMAIN_URL."login.php"); 
    exit();
}
$db = new Database();
$db->connect();
$db->sql("SET NAMES utf8");
$function = new custom_functions();

$donation_type = false;
$sql = "select * from donation_type";
$db->sql($sql);
$res = $db->getResult();
$num_rows = $db->numRows($res);
if($num_rows > 0){ 
   //print_r($res);die();
    $donation_type = $res;
}

$error = false;
$messages = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }

   
    $amount      = $_POST['amount'];
    $donate_for      = $_POST['donate_for'];

    if (empty($amount)) {
        $error  = true;
        $messages[] = "amount is required";
    }
    if (empty($donate_for)) {
        $error  = true;
        $messages[] = "donate for is required";
    }
    
    if(! $error){
      $sql = "select * from donation_type where id='".$_POST['donate_for']."'";
      $db->sql($sql);
      $res = $db->getResult();
      $num_rows = $db->numRows($res);
      if($num_rows > 0){ 
          $donation_type = $res[0]['name'];
      }
      $_SESSION['donate_amount']=$amount;
      $_SESSION['donate_desc']=$donation_type;
      header('Location: stripe_pay.php');
      exit();

    }
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

   <!-- js inlcude -->
   <script type='text/javascript' src='assets/js/jquery.js'></script>
      <script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
</head>
<body class="home page">
   <!-- preloader start  -->
   
   <div id="main_menu"><?php require_once('header.php');?></div>
     <section id="blog-heading">
  <div class="heading-section">
   <div class="container">
    <div class="heading-text pull-left">
     <h1 class="blog-title">Donate Now</h1>
   </div><!-- /.heading-text -->

   <div class="breadcrumb pull-right">
     <a href="index.html">Home</a><i class="fa fa-angle-double-right"></i> Donate Now        
   </div><!-- end breadcrumb -->
 </div><!-- /.container -->
</div><!-- /.heading-fullwidth -->     
</section> 
   <div class="contact-us-section">
      <div class="container">
         <div class="content-section">
            <div class="content-wrapper">
         <div class="col-sm-2"></div>
         <div class="col-sm-8">
               <h2 class="section-title" >Donate Now</h2>
               <div  class="wpcf7" id="wpcf7-f7-p367-o1" lang="en-US" dir="ltr">
                  <div class="screen-reader-response"></div>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="wpcf7-form" id="paymentFrm">
                     <div class="col-md-12 form-group">
                        <span class="wpcf7-form-control-wrap your-email">
                           <select name="donate_for" id="donate" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email form-control" required>
                              <option value="">--Donation For---</option>
                              <?php
                              if(!empty($donation_type)){
                                 foreach($donation_type as $row){
                              ?>
                              <option value="<?=$row['id'];?>"><?=$row['name'];?></option>
                              <?php
                                 }
                              }
                              ?>
                              
                           </select>
                        </span>
                     </div><!-- end form group -->
                     <div class="col-md-12 form-group">
                        <span class="wpcf7-form-control-wrap your-email">
                           <input type="text" name="amount" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email form-control" placeholder="Enter Amount" required />
                        </span>
                     </div>

                     <div id="card-errors" role="alert"></div>
                     <p class="event-btn-container col-md-12">
                        <input type="hidden" name="email" placeholder="Email" value="<?=$_SESSION['email'];?>" />
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="submit" value="donate NOW" class="wpcf7-form-control wpcf7-submit btn custom-btn" />
                     </p>

                     <div class="wpcf7-response-output wpcf7-display-none"></div>
                  </form>
               </div><!-- end wpcf7 -->
            </div>
            </div><!-- end content wrapper -->
         </div><!-- end contact section -->
      </div><!-- end container -->
   </div><!-- end contact us -->



   <!--  start full width -->
 

   <!-- start footer widget -->
  
          <div id="footer"><?php require_once('footer.php');?></div>

<!-- /.peace layout end -->



<!-- js include -->

<script type='text/javascript' src='assets/js/plugins.js'></script>
<script type='text/javascript' src='assets/js/masterslider.min.js'></script>
<script type='text/javascript' src='assets/js/functions.js'></script>
</body>
</html>