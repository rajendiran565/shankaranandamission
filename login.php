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

   
    $email      = ( isset($_POST['email']) && !empty($_POST['email']) )?$db->escapeString($_POST['email']):"";
    $password      = $_POST['password'];

    if (empty($email)) {
        $error  = true;
        $messages[] = "Email is required";
    }
    if (empty($password)) {
        $error  = true;
        $messages[] = "Password is required";
    }else{
        if (strlen($password) < 6) {
            $error  = true;
            $messages[] = "Password must be at least 6 characters long";
        }
    }
    
    if(! $error){
        
        $sql = "select * from users where email='".$email."'";
        $db->sql($sql);
        $res = $db->getResult();
        //var_dump($res);die;
        $num_rows = $db->numRows($res);
        if($num_rows > 0){ 
            $hashed_password = hash('sha256', $password . $res[0]['salt']);
            // Check if passwords match
            if ($hashed_password === $res[0]['password']) {
                $_SESSION['logged_in']=true;
                $_SESSION['user_id']=$res[0]['id'];
                $_SESSION['name']=$res[0]['fullname'];
                $_SESSION['email']=$res[0]['email'];
                $_SESSION['mobile']=$res[0]['phone'];
                // Login successful
                // Redirect to dashboard or home page
                header('Location: donate.php');
                exit();
            } else { 
                $error  = true;
                $messages[] = "Invalid password";
            }
        }else{
            $error  = true;
            $messages[] = "Invalid email address";
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

</head>
<body class="home page">
   <!-- preloader start  -->
   
   <div id="main_menu"><?php require_once('header.php');?></div>
     
   <div class="contact-us-section">
      <div class="container">
         <div class="content-section">
            <div class="content-wrapper">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
               <h2 class="section-title" >Login</h2>
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
                           <input type="email" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email form-control" name="email" placeholder="Email Id" value="<?php echo !empty($email)?$email:'';?>" required="" />
                        </span>
                     </div>
					   <div class="col-md-12 login form-group">
                        <span class="wpcf7-form-control-wrap your-email">
                          <input type="password" name="password" class="form-control" autocomplete="current-password" placeholder="Password" required="" id="login_pass">
                    <i class="fa fa-eye" id="togglePassword" style="right: 9px;top: 18px;cursor: pointer;position: absolute;"></i>
                    
                     </div>
					  <p class="forget"><a href="forgot_password.php" id="forgot_linkrr">Forgot Password?</a></p>
                    
                     <p class="event-btn-container col-md-12">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="submit" name="submit" value="Sign In" class="wpcf7-form-control wpcf7-submit btn custom-btn" />
                     </p>
                   <p class="signin text-center">You have not an account? <a href="register.php">Sign Up</a></p>
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
  
          <div id="footer"><?php require_once('footer.php');?></div>

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
</script>
</body>
</html>