<div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <?php if(isset($success)){ echo $success ; } ?>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Update Information</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form  method="post" enctype="multipart/form-data" action="<?=base_url('about_aashram')?>">
                                <div class="box-body">

                                <div class="form-group">
                                    <label for="image">Image :&nbsp;&nbsp;&nbsp;*Please choose image</label>
                                    <input type="file" name="image" id="fileupload" accept=".jpg,.jpeg,.png,.gif">
                                    <br/>
                                   <img  <?php if(isset($res->image)){ ?> src="<?=base_url().$res->image?>" <?php } ?> id = "blessing_img" width="25%!important" required/>
                                   <br/>
                                </div>


                                    <div class="form-group">
                                        <label for="app_name">About Aashram :</label>
                                        <textarea rows="10" cols="10" class="form-control" name="about_aashram"  required><?php if(isset($res->description)){ echo $res->description ; } ?></textarea>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn-primary btn" value="Update" name="btn_update"/>
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
        $("#blessing_img").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $('#fileupload').change(function() {
    readURL(this);
  });
</script>

<script type="text/javascript" src="<?=base_url()?>assets/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">CKEDITOR.replace('about_aashram');</script>

<script>
setTimeout(function() {
$('.alert').fadeOut('slow');
}, 2000);
</script>