<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>
		<?=$config['app_name']?>
		</title>
		<link rel="shortcut icon" type="image/png" href="<?=base_url('assets/img/').$logo?>"/>		
		<?php $this->load->view('template/style');?>
    </head>


    <body>

	<script>var base_url="<?=base_url()?>";</script>


		<div class="main-menu">


			<header class="header">
				<a href="<?=base_url()?>" class="logo"><i class="menu-icon ti-flag"></i>
				<?=$config['app_name']?>
				</a>
				<button type="button" class="button-close fa fa-times js__menu_close"></button>
			</header>
			<!-- /.header -->
			<?php $this->load->view('template/sidebar');?>
		
		</div>
		<!-- /.main-menu -->	

		<?php $this->load->view('template/topbar');?>

		<div id="wrapper">
			<div class="main-content">
				<?php $this->load->view($view);?>
			</div>
			<!-- /.main-content -->
		</div>
		<!--/#wrapper -->
		<?php $this->load->view('template/footer');?>
		<?php $this->load->view('template/script');?>
    </body>
</html>