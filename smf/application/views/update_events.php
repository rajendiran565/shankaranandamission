<div class="row">
    <div class="col-md-12">	
        <?php if(!isset($permissions['events']['create']) || $permissions['events']['create']==0) { ?>
            <div class="alert alert-danger">You have no permission to create Blog.</div>
        <?php } ?>
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update Event</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action ='<?=base_url('events')?>' method="post" enctype="multipart/form-data">
                <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control"  name="title" value="<?php if(isset($event_title)){echo $event_title;} ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Image :&nbsp;&nbsp;&nbsp;*Please choose image</label>
                            <input type="file" name="image" id="fileupload" accept=".jpg,.jpeg,.png,.gif">
                            <br/>
                           
                            <img  <?php if(isset($event_image)){ ?> src="<?=base_url().$event_image?>"  <?php } ?> id = "event_img"  width="25%!important"/>
                        
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Place</label>
                            <input type="text" class="form-control"  name="event_place" value="<?php if(isset($event_place)){echo $event_place;} ?>" required>
                        </div>

                        <div class="form-group">
                        
                           <label for="exampleInputEmail1">Date</label>
                           <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="event_date" value="<?php if(isset($event_date)){echo $event_date;} ?>" required>
                        </div>

                        <div class="form-group bootstrap-timepicker">
                            <label for="exampleInputEmail1">Time</label>
                            <input type="text" class="form-control" id="timepicker"  name="event_time" value="<?php if(isset($event_time)){echo $event_time;} ?>" required>
                            
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Event Hosted by</label>
                            <input type="text" class="form-control"  name="hosted_by" value="<?php if(isset($hosted_by)){echo $hosted_by;} ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description :</label>
                            <textarea name="description" class="form-control" rows="10" cols="10" required><?php if(isset($description)){echo $description;} ?></textarea>
                        </div>

                        
                        <input type="hidden" name="event_id" value="<?php if(isset($event_id)){echo $event_id;} ?>">
                       
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear"/>
                        <!--<div  id="res"></div>-->
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
<div class="separator"> </div>


<script type="text/javascript">

function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $("#event_img").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $('#fileupload').change(function() {
    readURL(this);
  });


</script>