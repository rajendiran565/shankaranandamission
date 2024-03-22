<!-- Placed at the end of the document so the pages load faster -->
<script src="<?=base_url()?>assets/js/modernizr.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/nprogress/nprogress.js"></script>
	<script src="<?=base_url()?>assets/plugin/sweet-alert/sweetalert.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/waves/waves.min.js"></script>
	<!-- Sparkline Chart -->
	<script src="<?=base_url()?>assets/plugin/chart/sparkline/jquery.sparkline.min.js"></script>
	<script src="<?=base_url()?>assets/js/chart.sparkline.init.min.js"></script>

	<!-- Percent Circle -->
	<script src="<?=base_url()?>assets/plugin/percircle/js/percircle.js"></script>

	<!-- Google Chart -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<!-- Chartist Chart -->
	<script src="<?=base_url()?>assets/plugin/chart/chartist/chartist.min.js"></script>
	<script src="<?=base_url()?>assets/js/jquery.chartist.init.min.js"></script>

	<!-- FullCalendar -->
	<script src="<?=base_url()?>assets/plugin/moment/moment.js"></script>
	<script src="<?=base_url()?>assets/plugin/fullcalendar/fullcalendar.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/bootstrap-table/bootstrap-table.js"></script>
	<script src="<?=base_url()?>assets/js/fullcalendar.init.js"></script>
	
	<script src="<?=base_url()?>assets/plugin/datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/select2/js/select2.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/daterangepicker/daterangepicker.js"></script>
	<script src="<?=base_url()?>assets/js/main.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/toastr/toastr.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/datatables/datatables.min.js"></script>

  <script src="<?=base_url()?>assets/plugin/datepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="<?=base_url()?>assets/plugin/timepicker/bootstrap-timepicker.min.js"></script>

  <!-- Demo Scripts -->
  <script src="<?=base_url()?>assets/js/form.demo.min.js"></script>
  
 
	<script type="text/javascript">var base_url = '<?php echo base_url(); ?>';</script>
  
<script>
setTimeout(function() {
$('.alert').fadeOut('slow');
}, 2000);
</script>

<?php if($page=="App Settings"){?>
<script>
    $('#system_timezone').on('change',function(e){
        gmt = $(this).find(':selected').data('gmt');
        $('#system_timezone_gmt').val(gmt);
    });
            
    $('#system_configurations_form').validate({
        rules:{currency:"required"}
    });

    $('#system_configurations_form').on('submit',function(e){
          e.preventDefault();

		if( $("#system_configurations_form").validate().form() ){

          var formData = new FormData(this);

          $.ajax({
                  type:'POST',
                  url: base_url+"add_settings",
                  data:formData,
                  beforeSend:function(){$('#btn_update').html('Please wait..');},
                  cache:false,
                  contentType: false,
                  processData: false,
                  success:function(result){
                        $('#result').html(result);
                        $('#result').show().delay(5000).fadeOut();
                        $('#btn_update').html('Save Settings');
                  }
          });
		}

      }); 
    
    </script>
<?php } ?>

<?php if($page=="Payment Methods Settings"){?>
	  <script>

      $('#payment_configurations_form').on('submit',function(e){
          e.preventDefault();
          var formData = new FormData(this);
         
          $.ajax({
                  type:'POST',
                  url: base_url+"settings/add_payment_methods",
                  data:formData,
                  beforeSend:function(){$('#btn_update').html('Please wait..');},
                  cache:false,
                  contentType: false,
                  processData: false,
                  success:function(result){
                      console.log(result);
                        $('#result').html(result);
                        $('#result').show().delay(5000).fadeOut();
                        $('#btn_update').html('Save Settings');
                  }
          });
      }); 
        
    
    
    </script>
<?php } ?>

<?php if($page=="Frequently Asked Questions"){?>

<script>

$("#faq_add_form").validate({
        rules:{
        query:"required",       
        answer:"required",
        }
  });

  $('#faq_add_form').on('submit',function(e){
  e.preventDefault();

  var formData = new FormData(this);

    if( $("#faq_add_form").validate().form()){

      $.ajax({
        url : base_url+"add_faq",
        type: 'POST',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,

        success: function(result){
          console.log(result);
          if(result==0){
            alert('Faq Added');
            location.reload();
          }
          if(result==1){
                alert('Error! Faq could not be added.');
          }
          if(result==2){
                alert('You have no permission to add Faq');
          }   
          if(result==3){
                alert('All field Required !!');
          }   
        }
    });
    }
  }); 



$("#update_faq_form").validate({
        rules:{
        query:"required",       
        answer:"required",
        }
  });


$('#update_faq_form').on('submit',function(e){
  e.preventDefault();
  var formData = new FormData(this);
    if( $("#update_faq_form").validate().form() ){

      $.ajax({
        url : base_url+"add_faq",
        type: 'POST',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,

        success: function(result){
          console.log(result);
          if(result==0){
            alert('Faq Added');
            location.reload();
          }
          if(result==1){
                alert('Error! Faq could not be added.');
          }
          if(result==2){
                alert('You have no permission to add Faq');
          }   
          if(result==3){
                alert('All field Required !!');
          }   
        }
    });

    }
});

$(document).on('click' , '.edit_faq', function () {

  faq_id = $(this).data("id");
  query = $(this).data("query");
  answer = $(this).data("answer");
  status = $(this).data("status");

  $('#faq_id').val(faq_id);
  $('#query').val(query);
  $('#answer').val(answer);
  $('#status').val(status);

});

$(document).on('click','.delete-faq',function(){

if(confirm('Are you sure want to delete faq.')){
    
    id = $(this).data("id");

    $.ajax({
        url : base_url+"delete_faq",
        type: 'POST',
        data: {'faq_id':id},
        success: function(result){
          if(result==0){
            alert('faq deleted');
            location.reload();
          }
          if(result==1){
                alert('Error! Faq could not be deleted.');
          }
            if(result==2){
                alert('You have no permission to delete Faq');
            }   
        }
    });
}
});
</script>
<?php } ?>

<?php if($view=="category"){?>
<script>
  $('#add_category').validate({
    rules:{ name:"required"}
  });

  $('#update_category').validate({
        rules:{
        category_name:"required"}
  });

  $('#add_category').on('submit',function(e){
    e.preventDefault();
    var formData = new FormData(this);

    if( $("#add_category").validate().form() ){
      $.ajax({
          type:'POST',
          url: $(this).attr('action'),
          data:formData,
          beforeSend:function(){$('#update_btn').html('Please wait..');},
          cache:false,
          contentType: false,
          processData: false,
          success:function(result){
            $('#result').html(result);
            $('#result').show().delay(6000).fadeOut();
            $('#update_btn').html('Submit');
            $('#add_category')[0].reset();
            setTimeout(function(){ $('#xin_table').DataTable().ajax.reload(null, false ); }, 2000);
          }
        });
      }
  }); 
  
  $('#update_category').on('submit',function(e){
    e.preventDefault();
    var formData = new FormData(this);

    if( $("#update_category").validate().form() ){ 
      $.ajax({
          type:'POST',
          url: $(this).attr('action'),
          data:formData,
          beforeSend:function(){$('#update_btn').html('Please wait..');},
          cache:false,
          contentType: false,
          processData: false,
          success:function(result){
            $('#update_result').html(result);
            $('#update_result').show().delay(6000).fadeOut();
            $('#update_btn').html('Update');
            $('#update_category')[0].reset();
            setTimeout(function() {$('#editCategoryModal').modal('hide'); $('#xin_table').DataTable().ajax.reload(null, false ); }, 2000);
          }
      });
    }
  }); 

  $(document).on('click','.edit-category',function(){
    id = $(this).data("id");
    name = $(this).data("name");
    $('#category_id').val(id);
    $('#category_name').val(name);
  });
  

  $(document).on('click','.delete-category',function(){
    if(confirm('Are you sure? Want to delete category.')){
      id = $(this).data("id");
      $.ajax({
          url : base_url+'welcome/delete_category',
          type: "post",
          data: {'category_id':id},
          success: function(result){
              if(result==0){
							    alert('Category deleted');
                    $('#xin_table').DataTable().ajax.reload(null, false );
                  }
              if(result==1){
                  alert('Error! Category could not be deleted.');
              }
          }
        });
      }
  });
</script>

<?php } ?>

<?php if($view=="blogs"){?>
<script>
$(document).on('click','.delete-blog',function(){
  if(confirm('Are you sure? Want to delete blog.')){
    id = $(this).data("id");
    $.ajax({
      url : base_url+'delete_blogs',
      type: "post",
      data: {'blog_id':id},
      success: function(result){
      if(result==0){
				alert('Blog deleted');
        $('#xin_table').DataTable().ajax.reload(null, false );
      }
      if(result==1){
          alert('Error! Blog could not be deleted.');
      }
    }
  });
}});
</script>

<?php } ?>

<?php if($view=="events"){?>
<script>
$(document).on('click','.delete-event',function(){
  if(confirm('Are you sure? Want to delete event.')){
    id = $(this).data("id");
    $.ajax({
      url : base_url+'delete_event',
      type: "post",
      data: {'event_id':id},
      success: function(result){
      if(result==0){
				alert('Event deleted');
        $('#xin_table').DataTable().ajax.reload(null, false );
      }
      if(result==1){
          alert('Error! Event could not be deleted.');
      }
    }
  });
}});
</script>

<?php } ?>


<?php if($view=="banners"){?>
<script>
  $('#add_banner').validate({
    rules:{ banner:"required"}
  });

  $('#update_banner').validate({
        rules:{banner:"required"}
  });

  $('#add_banner').on('submit',function(e){
    e.preventDefault();
    var formData = new FormData(this);
    if( $("#add_banner").validate().form() ){
      $.ajax({
          type:'POST',
          url: $(this).attr('action'),
          data:formData,
          beforeSend:function(){$('#update_btn').html('Please wait..');},
          cache:false,
          contentType: false,
          processData: false,
          success:function(result){
            $('#result').html(result);
            $('#result').show().delay(6000).fadeOut();
            $('#update_btn').html('Submit');
            $('#add_banner')[0].reset();
            $('#banner_img').removeAttr('src');
            setTimeout(function(){ $('#xin_table').DataTable().ajax.reload(null, false ); }, 2000);
          }
        });
      }
  }); 
  
  $('#update_banner').on('submit',function(e){
    e.preventDefault();
    var formData = new FormData(this);

    if( $("#update_banner").validate().form() ){ 
      $.ajax({
          type:'POST',
          url: $(this).attr('action'),
          data:formData,
          beforeSend:function(){$('#update_btn').html('Please wait..');},
          cache:false,
          contentType: false,
          processData: false,
          success:function(result){
            $('#update_result').html(result);
            $('#update_result').show().delay(6000).fadeOut();
            $('#update_btn').html('Update');
            $('#update_banner')[0].reset();
            $('#banner_img1').removeAttr('src');
            setTimeout(function() {$('#editBannermodal').modal('hide'); $('#xin_table').DataTable().ajax.reload(null, false ); }, 2000);
          }
      });
    }
  }); 

  $(document).on('click','.edit-banner',function(){
    id = $(this).data("id");
    banner = $(this).data("banner");
    $('#banner_id').val(id);
    $('#banner_img1').attr('src' , base_url+banner);
  });
  

  $(document).on('click','.delete-banner',function(){
    if(confirm('Are you sure? Want to delete banner.')){
      id = $(this).data("id");
      $.ajax({
          url : base_url+'welcome/delete_banner',
          type: "post",
          data: {'banner_id':id},
          success: function(result){
              if(result==0){
							    alert('banner deleted');
                    $('#xin_table').DataTable().ajax.reload(null, false );
                  }
              if(result==1){
                  alert('Error! banner could not be deleted.');
              }
          }
        });
      }
  });

  function readURL3(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $("#banner_img1").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $('#banner').change(function() {
    readURL3(this);
  });


</script>
<?php } ?>

<?php if($view == "image_gallery"){ ?>

<script>

$('#add_gallery').validate({rules:{gallery:"required"}});

$('#update_gallery').validate({rules:{gall_category:"required"}});

$('#add_gallery').on('submit' , function(e){
  e.preventDefault();
  var formData = new FormData(this);
  if($("#add_gallery").validate().form() ){
  $.ajax({
    url:$(this).attr('action'),
    type:'POST',
    data:formData,
    cache:false,
    beforeSend:function(){$('#update_btn').html('Please wait..');},
    contentType:false,
    processData:false,
    success:function(result){
      $('#result').html(result);
      $('#result').show().delay(6000).fadeOut();
      $('#update_btn').html('Submit');
      $('#add_gallery')[0].reset();
      $('#gallery_img').removeAttr('src');
      setTimeout(function() { $("#xin_table").DataTable().ajax.reload(null , false ); },2000);
    }
  });
  }
});

$(document).on('click','.edit-gallery',function(){
    id = $(this).data("id");
    gallery = $(this).data("gallery");
    category = $(this).data("category");

    $('#gall_category').val(category);
    $('#gallery_id').val(id);
    $('#gallery_img1').attr('src' , base_url+gallery);
  });




$('#update_gallery').on('submit' , function(e){
e.preventDefault();
var formData = new FormData(this);

if($('#update_gallery').validate().form()){

$.ajax({
    type:'POST',
    url:$(this).attr('action'),
    data:formData,
    beforeSend:function(){$("#update_btn").html('Please wait..');},
    cache:false,
    contentType:false,
    processData:false,
    success:function(result){
      $('#update_result').html(result);
      $('#update_result').show().delay(6000).fadeOut();
      $('#update_btn').html('Submit');
      $('#update_gallery')[0].reset();
      $('#gallery_img1').removeAttr('src');
      setTimeout(function() {$('#editGallerymodal').modal('hide'); $('#xin_table').DataTable().ajax.reload(null, false ); }, 2000);
    }
});
}
});

$(document).on('click','.delete-gallery',function(){
    if(confirm('Are you sure? Want to delete image.')){
      id = $(this).data("id");
      $.ajax({
          url : base_url+'delete_gallery',
          type: "post",
          data: {'id':id},
          success: function(result){
              if(result==0){
							    alert('Gallery Image deleted');
                    $('#xin_table').DataTable().ajax.reload(null, false );
                  }
                if(result==1){
                  alert('Error! Gallery Image could not be deleted.');
              }
          }
        });
      }
  });

  function readURL2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $("#gallery_img1").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $('#gallery').change(function() {
    readURL2(this);
  });


$('#add_gallery_category').validate({ rules:{gallery_category_name:"required"}});
$('#update_gallery_category').validate({rules:{gallery_category_name:"required"}});

$('#add_gallery_category').on('submit' , function(e){
  e.preventDefault();
  var formData = new FormData(this);
  if($("#add_gallery_category").validate().form() ){
  $.ajax({
    url:$(this).attr('action'),
    type:'POST',
    data:formData,
    cache:false,
    beforeSend:function(){$('#update_btn1').html('Please wait..');},
    contentType:false,
    processData:false,
    success:function(result){
      $('#result1').html(result);
      $('#result1').show().delay(6000).fadeOut();
      $('#update_btn1').html('Submit');
      $('#add_gallery_category')[0].reset();
      setTimeout(function() {$('#addCategoryModal').modal('hide'); $("#xin_table1").DataTable().ajax.reload(null , false ); },2000);
    }
  });
  }
});

$(document).on('click','.edit-cat',function(){
    id = $(this).data("id");
    title = $(this).data("title");
    $('#cat_id').val(id);
    $('#cat_name').val(title);
  });

  
$('#update_gallery_category').on('submit' , function(e){
e.preventDefault();
var formData = new FormData(this);

if($('#update_gallery_category').validate().form()){

$.ajax({
    type:'POST',
    url:$(this).attr('action'),
    data:formData,
    beforeSend:function(){$("#update_btn").html('Please wait..');},
    cache:false,
    contentType:false,
    processData:false,
    success:function(result){
      $('#update_result1').html(result);
      $('#update_result1').show().delay(6000).fadeOut();
      $('#update_btn').html('Submit');
      $('#update_gallery_category')[0].reset();
      setTimeout(function() {$('#editGall_Catmodal').modal('hide'); $('#xin_table1').DataTable().ajax.reload(null, false ); }, 2000);
    }
});
}
});

$(document).on('click','.delete-cat',function(){
    if(confirm('Are you sure? Want to delete category.')){
      id = $(this).data("id");
      $.ajax({
          url : base_url+'welcome/delete_gallery_category',
          type: "post",
          data: {'cat_id':id},
          success: function(result){
              if(result==0){
							    alert('Category deleted');
                    $('#xin_table1').DataTable().ajax.reload(null, false );
                  }
                if(result==1){
                  alert('Error! Category could not be deleted.');
              }
          }
        });
      }
  });










</script>
<?php } ?>
