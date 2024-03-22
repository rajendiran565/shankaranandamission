<?php 
$month = 30 * 24 * 60 * 60; // 30 days * 24 hours * 60 minutes * 60 seconds
ini_set('session.cookie_lifetime', $month);
ini_set('session.gc_maxlifetime', $month);
session_start();
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&display=swap" rel="stylesheet">

<header id="top-section">
<div class="container">
<div class="col-sm-4 col-xs-12 col3 mobile">
<div class="logo text-center">
<a href="index.html"> <img src="images/smf-logo.png" alt="smf" /> </a>
</div>
</div>
<div class="col-sm-4 col7 address">
<div class="pull-left">
<ul>
<li><i class="fa fa-phone"></i>018-7828130</li>
<li><i class="fa fa-envelope-o"></i> shankaranandamissions@gmail.com</li>
</ul>

</div>
</div>

<div class="col-sm-4 col-xs-12 desktop">
<div class="logo text-center">
<a href="index.html"> <img src="images/smf-logo.png" alt="smf" /> </a>
</div>
</div>
<div class="social-search log-sec1">
<ul>
<?php if(! isset($_SESSION['user_id'])) { ?>
<li><a href="login.php" class="login-btn">Login</a></li>
<?php } ?>
<?php if(isset($_SESSION['user_id'])) { ?>
<li>
<div class="dropdown user-sec2">
<button class="btn btn-primary user-sec1 dropdown-toggle" type="button" data-toggle="dropdown"><img src="images/user.png"></button>
<ul class="dropdown-menu">
<li><a><?=!empty($_SESSION['name'])?$_SESSION['name']:'';?></a></li>
<li><a><?=!empty($_SESSION['email'])?$_SESSION['email']:'';?></a></li>
<li><a><?=!empty($_SESSION['mobile'])?$_SESSION['mobile']:'';?></a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</div>
</li>
<?php } ?>
</ul>
</div>

<div class="social-search hidden-xs">
<ul>
<li><a href="#"><i class="fa fa-facebook"></i><span></span></a></li>

<li><a href="#"><i class="fa fa-twitter"></i><span></span></a></li>
<li><a href="https://www.youtube.com/@SatgurunatharAyya" target="_blank"><img src="images/youtube.png"></a></li>
</ul>
</div>



</div><!-- /.container -->

<!--  menu slider start -->
<div class="menu-slider">
<nav id="peace-menu">
<div class="container">

<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#responsive-icon" aria-expanded="false">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div><!--  navbar-header -->

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="responsive-icon">
<div class="menu-menu-1-container">

<ul class="nav navbar-nav text-center nav navbar-nav text-center">

<li class="dropdown active">
<a title="Home" href="index.html" >Home</a>

</li>
<li>
<span class="line-span">|</span>                          
</li>
<li class="dropdown">
<a title="Events" href="aid_for_single_parent.html" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">About <i class="fa fa-angle-down"></i></a>
<ul role="menu" class="dropdown-menu">
<li> <a title="about" href="about.html">Satgurunathar Ayya</a></li>
<li> <a title="about" href="madalayam.html">Shree Raghavendra Swamy Madalayam</a></li>
</ul>
</li>

<li>
<span class="line-span">|</span>                          
</li>
<li class="dropdown">
<a title="background" href="background.html">Background</a>

</li>

<li>
<span class="line-span">|</span>                          
</li>
<li class="dropdown">
<a title="Events" href="aid_for_single_parent.html" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">Activities <i class="fa fa-angle-down"></i></a>
<ul role="menu" class="dropdown-menu">
<li><a title="single parents" href="aid_for_single_parent.html">Aid For Single Parents</a>
</li>
<li><a title="underprevilleged" href="home_for_under_pervilliged.html">Home For Underprivileged Children </a>
</li>
<li><a title="freemeels" href="free_meals.html">Free Meals / Annathanam </a>
</li>
<li><a title="food distribution" href="food_distribution.html">Food Distribution to Poor Families </a>
</li>
<li><a title="free consultation" href="free_consultation.html">Free Consultation</a>
</li>
<li><a title="Free Talks" href="free_talk.html">Free Talks / Seminars And Spiritual Courses  </a>
</li>
<li><a title="Prayer" href="prayer_for_word_peace.html">Prayer for World peace</a>
</li>
<li><a title="Cultural Activities" href="cultural_activity.html">Cultural Activities</a></li>
<li><a title="Welfare" href="wellfare_activity.html">Welfare Activities At Temple </a>
</li>
<li><a title="Charity" href="charity.html">Charity/Fund Raising Events</a>
</li>
<li><a title="Youth" href="youth_projects.html">Youth Projects</a>
</li>
<li><a title="Hsa Hospital" href="hsa_hospital.html">Visit To HSA Hospital</a>
</li>
<li><a title="Pet Care" href="pet_care.html">Pet Care</a>
</li>
<li><a title="Conserving" href="conserving_nature.html">Conserving Nature/the Environment</a>
</li>
<li><a title="Visit To Home" href="visit_to_home.html">Visit to Home and Orphanages</a>
</li>
<li><a title="School Visits" href="school_visit.html">School Visits/Talks</a>
</li>
<li><a title="Youth Leadership" href="youth_leadership.html">Youth Leadership Camp</a>
</li>
<li><a title="Annual Charity" href="annual_charity.html">Annual Charity Dinner</a>
</li>
<li><a title="Talk Consultation" href="talk_consultation.html">Talk Consultation and Charity in India</a>
</li>
<li><a title="Million Projects" href="million_projects.html">1 Million Projects (Feed the Hunger)</a>
</li>
</ul>
</li>
<li>
<span class="line-span">|</span>                          
</li>

<li class="dropdown">
<a title="Certificate" href="achievements.html">Achievements</a>

</li>
<li>
<span class="line-span">|</span>                          
</li>

<li class="dropdown">
<a title="Events" href="events.php">Calendar of Events</a>

</li>

<li>
<span class="line-span">|</span>                          
</li>

<li class="dropdown">
<a title="Gallery" href="gallery.html">Gallery</a>

</li>


<li>
<span class="line-span">|</span>                          
</li>


<li><a title="Contact Us" href="contact-us.html">Contact Us</a></li>

<li class="button-skew"><a class="donate-button" href="donate.php"><span> Donate Now </span></a></li>
</ul>
</div><!-- menu-menu-1-container  -->
</div><!-- /.navbar-collapse -->
</div><!-- container  -->
</nav><!-- peace-menu -->
</div><!-- /.menu-slider -->
</header>
<!--  /# top section  -->