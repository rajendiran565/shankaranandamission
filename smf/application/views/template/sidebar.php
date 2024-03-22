<div class="content">
		<div class="navigation">
			<h5 class="title">Navigation</h5>
			<!-- /.title -->
			<ul class="menu js__accordion">


			<?php if($view=="dashboard"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>dashboard"><i class="menu-icon ti-dashboard"></i><span>Dashboard</span></a>
			</li>

			<?php if($view=="category"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>category"><i class="menu-icon ti-direction"></i><span>Donation Type</span></a>
			</li>


			<?php if($view=="users"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>users"><i class="menu-icon ti-user"></i><span>Users</span></a>
			</li>

			<?php if($view=="blogs" || $view=="update_blogs"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>blogs"><i class="menu-icon ti-envelope"></i><span>News & Articles</span></a>
			</li>

			<?php if($view=="events" || $view=="update_events"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>events"><i class="menu-icon ti-package"></i><span>Events</span></a>
			</li>

					</ul>
					<!-- /.sub-menu js__content -->
				</li>
			</ul>



			<!-- /.menu js__accordion -->
			<h5 class="title">User Interface</h5>
			<!-- /.title -->
			<ul class="menu js__accordion">


				<?php if($view=="banners"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>banners"><i class="menu-icon ti-image"></i><span>Banners</span></a>
				</li>


			<?php if($view=="blessings"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>blessings"><i class="menu-icon ti-gift"></i><span>Daily Blessings</span></a>
				</li>

			<?php if($view=="about_aashram"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>about_aashram"><i class="menu-icon ti-flag"></i><span>About Aashram</span></a>
			</li>

			<?php if($view=="about_swamiji"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>about_swamiji"><i class="menu-icon ti-bag"></i><span>About Swamiji</span></a>
			</li>

			<?php if($view=="image_gallery"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>image_gallery"><i class="menu-icon ti-image"></i><span>Image Gallery</span></a>
			</li>


            <?php if($view=="transactions"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>transactions"><i class="menu-icon ti-money"></i><span>Transaction</span></a>
				</li>


			<?php if($view =="app_setting" || $view=="payment_methods" || $view=="notification_setting" || $view=="contact_us" || $view=="privacy_policy" || $view=="about_us"){?>
				
				<li class="active">
					<a class="waves-effect parent-item js__control" href="#"><i class="menu-icon ti-layout"></i><span>System</span><span class="menu-arrow fa fa-angle-down"></span></a>
					<ul class="sub-menu js__content" style="display: block;">
					<?php } else { ?>
				<li>
					<a class="waves-effect parent-item js__control" href="#"><i class="menu-icon ti-layout"></i><span>System</span><span class="menu-arrow fa fa-angle-down"></span></a>
					<ul class="sub-menu js__content">
					<?php } ?>

						<?php if($view=="app_setting"){?><li class="current"><a style="background:#3F51B5; color:white;" href="settings">App Settings</a></li>
						<?php } else { ?><li><a href="<?=base_url()?>app_settings">App Settings</a></li>
						<?php } ?>
						
						<?php if($view=="payment_methods"){?><li class="current"><a style="background:#3F51B5; color:white;" href="<?=base_url()?>settings/payment_methods">Payment Methods</a></li>
						<?php } else { ?><li><a href="<?=base_url()?>settings/payment_methods">Payment Methods</a></li>
						<?php } ?>
						
						<?php if($view=="notification_setting"){?><li class="current"><a style="background:#3F51B5; color:white;" href="<?=base_url()?>settings/notification_settings">Notification Settings</a></li>
						<?php } else { ?><li><a href="<?=base_url()?>settings/notification_settings">Notification Settings</a></li>
						<?php } ?>
						
						<?php if($view=="contact_us"){?><li class="current"><a style="background:#3F51B5; color:white;" href="<?=base_url()?>settings/contact_us">Contact Us</a></li>
						<?php } else { ?><li><a href="<?=base_url()?>settings/contact_us">Contact Us</a></li>
						<?php } ?>
						
						<?php if($view=="privacy_policy"){?><li class="current"><a style="background:#3F51B5; color:white;" href="<?=base_url()?>settings/privacy_policy">Privacy Policy</a></li>
						<?php } else { ?><li><a href="<?=base_url()?>settings/privacy_policy">Privacy Policy</a></li>
						<?php } ?>
					
					</ul>
					<!-- /.sub-menu js__content -->
				</li>
			
               </ul>
					<!-- /.sub-menu js__content -->
				</li>
			</ul>
			<!-- /.menu js__accordion -->
			<h5 class="title">Additions</h5>
			<!-- /.title -->
			<ul class="menu js__accordion">

			<?php if($view=="faq"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="<?=base_url()?>settings/faq"><i class="menu-icon ti-info"></i><span>FAQs</span>
					<?php
                           $query="select * from faq where status=1 ";
						   $count=$this->db->query($query)->num_rows();
							
                        if($count)
                            { ?>
                        <span class="notice notice-blue"><?php echo $count; ?></span>
                        <?php	} ?>
						</a>
				</li>
				<br/>
				<?php 
                    if($role == 'admin' || $role == 'super admin' || $role == 'superadmin' ){
                ?>
				<?php if($view=="Create or Edit Users"){?>
				<li class="current">
			<?php } else { ?>
				<li>
			<?php } ?>
					<a class="waves-effect" href="system-users"><i class="menu-icon ti-user"></i><span>System Users</span></a>
				</li>
				<?php } ?>
			</ul>
			<!-- /.menu js__accordion -->
		</div>
		<!-- /.navigation -->
	</div>
	<!-- /.content -->