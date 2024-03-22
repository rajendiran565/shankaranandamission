<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$logo = $this->common_model->get_settings('logo');

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/ico" href="">
	<title>Admin Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
	<link rel="stylesheet" href="assets/css/style.min.css">

	<link rel="shortcut icon" type="image/png" href="<?=base_url('assets/img/').$logo?>"/>	

	<!-- Waves Effect -->
	<link rel="stylesheet" href="assets/plugin/waves/waves.min.css">
	<link rel="stylesheet" href="assets/plugin/toastr/toastr.min.css">
  </head>
<body>
		
<div id="single-wrapper">
	<form style="margin-top: 150px;" method="post" id="loginform" action="login" enctype="multipart/form-data" class="frm-single">
		<div class="inside">
		<div class="title">
			<img src="" height="110">
			<h3> Dashboard</h3>
		</div>
			<div class="frm-input"><input type="text"  name="username" placeholder="Username" class="frm-inp"><i class="fa fa-user frm-ico" required></i></div>
			<!-- /.frm-input -->
			<div class="frm-input"><input type="password" name="password" placeholder="Password" class="frm-inp"><i class="fa fa-lock frm-ico" required></i></div>
			<!-- /.frm-input -->

			<div class="frm-input"><div class="g-recaptcha" data-sitekey="6LfHu5kpAAAAACFjp125C-ooQcZ8cEZPcs2p4WQU"></div></div>
		
			<!-- /.clearfix -->
			<button type="submit" name="btnLogin" class="frm-submit">Login<i class="fa fa-arrow-circle-right"></i></button>
			
			<div class="frm-footer text-center">SpiderIndia © <?=date('Y')?>.</div>
			<!-- /.footer -->
		</div>
		<!-- .inside -->
	</form>
	<!-- /.frm-single -->
</div><!--/#single-wrapper -->
	<script src="assets/plugin/nprogress/nprogress.js"></script>
	<script src="assets/plugin/waves/waves.min.js"></script>
	 <!-- ========== COMMON JS FILES ========== -->
        <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/plugin/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?=base_url()?>assets/plugin/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?=base_url()?>assets/plugin/toastr/toastr.min.js"></script>
		

        <script>
            $(document).ready(function(){

				$("#loginform").submit(function(e){

					$('.save').prop('disabled', true);
					$('.saveinfo').removeClass('ft-unlock');
					$('.saveinfo').addClass('fa spinner fa-refresh');
				/*Form Submit*/
				e.preventDefault();

				var username = $('input[name="username"]').val();
				var password = $('input[name="password"]').val();
				var captcha =  $('#g-recaptcha-response').val();
				
	            var is_redirect = 1;

				$.ajax({
					type: "POST",
					url: '<?=base_url()?>welcome/login',
					data: {'username' :username ,'password':password , 'g-recaptcha-response':captcha},
					cache: false,
					success: function (res) {
					console.log(res);
						if (res.error != '') {
							toastr.error(res.error);

							$('.save').prop('disabled', false);
							$('.saveinfo').addClass('ft-unlock');
							$('.saveinfo').removeClass('fa spinner fa-refresh');

						} else {

							toastr.success(res.result);

							$('.save').prop('disabled', false);
							$('.saveinfo').addClass('ft-unlock');
							$('.saveinfo').removeClass('fa spinner fa-refresh');

							if(is_redirect==1) {
								setTimeout(function(){window.location.reload(); }, 1000);
							}
						}
					}
				});
				});
			});
        </script>
	<script src="assets/js/main.min.js"></script>
  </body>
</html>