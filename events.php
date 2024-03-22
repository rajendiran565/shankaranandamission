<?php
include_once('./includes/csrf_token.php');
include_once('./includes/crud.php');
include_once('./includes/custom-functions.php');

$db = new Database();
$db->connect();
$db->sql("SET NAMES utf8");
$function = new custom_functions();

// $sql = "select * from events";
// $db->sql($sql);
// $res = $db->getResult();
// //var_dump($res);die;
// $num_rows = $db->numRows($res);
// if($num_rows > 0){ 
//     echo '<pre>';
//     print_r($res);die();
// }else{
//     $error  = true;
//     $messages = "Event not found";
// }
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
</head>
<body class="home page">
  <!-- preloader start  -->
  
<div id="main_menu"></div>
<section class="inner-banner bg-cover" style="background-image: url('images/calendar-back.jpg');">
</section>
 <!-- Blog Heading -->
<section id="blog-heading">
  <div class="heading-section">
   <div class="container">
    <div class="heading-text pull-left">
     <h1 class="blog-title">Calendar of Events</h1>
   </div><!-- /.heading-text -->

   <div class="breadcrumb pull-right">
     <a href="index.html">Home</a><i class="fa fa-angle-double-right"></i> Calendar of Events           
   </div><!-- end breadcrumb -->
 </div><!-- /.container -->
</div><!-- /.heading-fullwidth -->      
</section>

<!-- Blog Page Container -->
   <section class="section-padding" style="padding-bottom:0;">
         <div class="container">
            <div class="content-section">
               <div class="content-wrapper">
                  <h2 class="section-title">Recent Event</h2>

                   <div class="section-detail">   Shree Raghavendra Swamy Madalayam which is a global network that extends its noble social service to all those in need. Many worthy deeds are actively carried out all over Malaysia, Singapore and India, and will be expanded throughout the world in the near future.</div>

                  <!-- all event start  -->
                
               </div><!-- end conent wrapper -->
            </div><!-- end content secton -->
         </div><!-- end container -->
      </section>


<div class="p-5">
  <div class="card">
  <div class="container">
    <div class="card-body p-0">
      <div id="calendar"></div>
    </div>
    </div>
  </div>
</div>
<br><br>
<!-- calendar modal -->
<div id="modal-view-event" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content event-modal1">
            <div class="modal-footer modal-footer1">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span></h4>
                    <div class="event-body"></div>
                </div>
                
            </div>
        </div>
    </div>


<script src="assets/js/popper.min.js"></script>

<script src="assets/js/moment.js"></script>
<script src="assets/js/fullcalendar.min.js"></script>
<script src="assets/js/datepicker.js"></script>
<script src="assets/js/datepicker.en.js"></script>

<script>
jQuery(document).ready(function(){
  jQuery('.datetimepicker').datepicker({
      timepicker: true,
      language: 'en',
      range: true,
      multipleDates: true,
          multipleDatesSeparator: " - "
    });
  jQuery("#add-event").submit(function(){
      alert("Submitted");
      var values = {};
      $.each($('#add-event').serializeArray(), function(i, field) {
          values[field.name] = field.value;
      });
      console.log(
        values
      );
  });
});

(function () {    
    'use strict';
    // ------------------------------------------------------- //
    // Calendar
    // ------------------------------------------------------ //
    jQuery(function() {
        // page is ready
        jQuery('#calendar').fullCalendar({
            themeSystem: 'bootstrap4',
            // emphasizes business hours
            businessHours: false,
            defaultView: 'month',
            // event dragging & resizing
            navLinks: true,
            editable: true,
            eventLimit: true,
            // header
            header: {
                left: 'title',
                center: 'month,agendaWeek,agendaDay',
                right: 'today prev,next'
            },
            events: function(start, end, timezone, callback) {
                jQuery.ajax({
                    url: 'get_events.php', // Replace with the path to your PHP script
                    type: 'GET', // or 'POST' if you are sending data to the server
                    dataType: 'json',
                    success: function(response) {
                        var events = [];
                        if(response){
                            // Assuming response is an array of events
                            events = response;
                        }
                        callback(events);
                    }
                });
            },
            
            eventRender: function(event, element) {
                if(event.icon){
                    element.find(".fc-title").prepend("<i class='fa fa-"+event.icon+"'></i>");
                }
              },
            dayClick: function() {
                jQuery('#modal-view-event-add').modal();
            },
            eventClick: function(event, jsEvent, view) {
                    jQuery('.event-icon').html("<i class='fa fa-"+event.icon+"'></i>");
                    jQuery('.event-title').html(event.title);
                    jQuery('.event-body').html(event.description);
                    jQuery('.eventUrl').attr('href',event.url);
                    jQuery('#modal-view-event').modal();
            },
            
        })
    });
  
})(jQuery);
</script>

<!-- start footer widget -->

           <div id="footer"></div>


<!-- js include -->
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=true&#038;ver=1.0'></script>
<script type='text/javascript' src='assets/js/plugins.js'></script>
<script type='text/javascript' src='assets/js/masterslider.min.js'></script>
<script type='text/javascript' src='assets/js/functions.js'></script>
<!-- custom -->

   
</body>
</html>