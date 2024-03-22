<?php
include_once('./includes/csrf_token.php');
include_once('./includes/crud.php');
include_once('./includes/custom-functions.php');

if(isset($_SESSION['user_id'])) {
    header("Location: ".DOMAIN_URL); 
    exit();
}

$db = new Database();
$db->connect();
$db->sql("SET NAMES utf8");
$function = new custom_functions();
$error = false;
$messages = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }

   
    $email = $_SESSION['email'];

    $otp = ( isset($_POST['otp']) && !empty($_POST['otp']) )?$db->escapeString($_POST['otp']):"";
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($otp)) {
        $error  = true;
        $messages[] = "OTP is required";
    }

    if (empty($password)) {
        $error  = true;
        $messages[] = "Password is required";
    }else{
        if (strlen($password) < 6) {
            $error  = true;
            $messages[] = "Password must be at least 6 characters long";
        }

        if ($password != $confirm_password) {
            $error  = true;
            $messages[] = "New password and confirm password do not match.";
        }
    }
    if(! $error){
        $sql = "SELECT * FROM users WHERE email = '".$email."' AND otp = '".$otp."'";
        $db->sql($sql);
        $res = $db->getResult();
        //var_dump($res);die;
        $num_rows = $db->numRows($res);
        if($num_rows > 0){ 
            $id = $res[0]['id'];
            $salt = bin2hex(random_bytes(32));
            // Hash the new password with the new salt
            $hashed_password = hash('sha256', $password . $salt);

            $data1 = array(
                'password' => $hashed_password,
                'salt' => $salt,
                'otp' => NULL,
                'otp_expiry' => NULL
            );

            $db->update('users',$data1,'id='.$id);

            $_SESSION['success_message'] = 'Password changed successfully';

            header("Location: login.php"); 
            exit();

        }else{
            $error  = true;
            $messages[] = "Invalid OTP";
        }

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
</head>
<body class="home page">
   <!-- preloader start  -->
   
   <div id="main_menu"></div>
     
   <div class="contact-us-section">
      <div class="container">
         <div class="content-section">
            <div class="content-wrapper">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
               <h2 class="section-title">Reset password</h2>
			
               <div role="form" class="wpcf7" id="wpcf7-f7-p367-o1" lang="en-US" dir="ltr">
                  <div class="screen-reader-response"></div>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="wpcf7-form">
                       
                        <?php 
                         if (!empty($_SESSION['success_message'])) : ?>
                            <div class="alert alert-success">
                                <?= $_SESSION['success_message'] ?>
                                <?php unset($_SESSION['success_message']); ?>
                            </div>
                        <?php endif ?>
                        <?php 
                        if($error){
                            echo '<div class="alert alert-danger">';
                            echo '<ul class="list-unstyled">';
                            if(!empty($messages)){
                                foreach($messages as $row){
                                    echo '<li>'.$row.'</li>';
                                }
                            }
                            echo '</ul>';
                            echo '</div>';
                        }
                        ?>

                        <div class="col-md-12 form-group">
                            <span class="wpcf7-form-control-wrap your-email">
                               <input type="text" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email form-control" name="otp" placeholder="OTP" required="" />
                            </span>
                         </div>
                        
                        <div class="col-md-12 login form-group">
                        <span class="wpcf7-form-control-wrap your-email">
                          <input type="password" name="password" class="form-control" autocomplete="current-password" placeholder="Password" required="" id="login_pass">
                    <i class="fa fa-eye" id="togglePassword" style="right: 9px;top: 18px;cursor: pointer;position: absolute;"></i>
                    
                     </div>

                     <div class="col-md-12 login form-group">
                        <span class="wpcf7-form-control-wrap your-email">
                          <input type="password" name="confirm_password" class="form-control" autocomplete="current-password" placeholder="Confirm Password" required="" id="login_pass2">
                    <i class="fa fa-eye" id="togglePassword2" style="right: 9px;top: 18px;cursor: pointer;position: absolute;"></i>
                    
                     </div>
					  
					 
                     <p class="event-btn-container col-md-12">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="submit" name="submit" value="Submit" class="wpcf7-form-control wpcf7-submit btn custom-btn" />
                     </p>
					  <p class="signin text-center">You have an account? <a href="login.php">Sign In</a></p>
                    
                   <div class="wpcf7-response-output wpcf7-display-none"></div>
                  </form>
				  <br>
               </div><!-- end wpcf7 -->
			   </div>
            </div><!-- end content wrapper -->
         </div><!-- end contact section -->
      </div><!-- end container -->
   </div><!-- end contact us -->



   <!--  start full width -->
 

   <!-- start footer widget -->
  
          <div id="footer"></div>

<!-- /.peace layout end -->



<!-- js include -->
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=true&#038;ver=1.0'></script>
<script type='text/javascript' src='assets/js/plugins.js'></script>
<script type='text/javascript' src='assets/js/masterslider.min.js'></script>
<script type='text/javascript' src='assets/js/functions.js'></script>


<!-- custom -->
<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#login_pass');

togglePassword.addEventListener('click', function (e) {
// toggle the type attribute
const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
password.setAttribute('type', type);
// toggle the eye slash icon
this.classList.toggle('fa-eye-slash');
});

const togglePassword2 = document.querySelector('#togglePassword2');
const password2 = document.querySelector('#login_pass2');

togglePassword2.addEventListener('click', function (e) {
// toggle the type attribute
const type2 = password2.getAttribute('type') === 'password' ? 'text' : 'password';
password2.setAttribute('type', type2);
// toggle the eye slash icon
this.classList.toggle('fa-eye-slash');
});
</script>
</body>
</html>