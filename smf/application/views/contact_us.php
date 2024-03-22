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
                    <form  method="post" enctype="multipart/form-data" action="<?=base_url('contact_us')?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="app_name">Contact US :</label>
                                 <textarea rows="10" cols="10" class="form-control" name="contact_us" id="contact_us" required><?=$res?></textarea>
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
			
<script type="text/javascript" src="<?=base_url()?>assets/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">CKEDITOR.replace('contact_us');</script>
<script>
setTimeout(function() {
$('.alert').fadeOut('slow');
}, 2000);
</script>