       <div class="row">
                    
                    <div class="col-md-12">
                    <?php if(isset($success)){ echo $success ; } ?>
                        <?php if($permissions['settings']['read']==1){
                        if($permissions['settings']['update']==0) { ?>
                            <div class="alert alert-danger">You have no permission to update settings</div>
                        <?php } ?>
                       
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Update Privacy Policy</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            
                            
                            <form  method="post" enctype="multipart/form-data" action="<?=base_url('privacy_policy')?>">
                                 
                                <div class="box-body">
                                    
                                    <div class="form-group">
                                        <label for="app_name">Privacy Policy:</label>
                                        <textarea rows="10" cols="10" class="form-control" name="privacy_policy" id="privacy_policy" required><?=$res[1]->value?></textarea>
                                    </div>
                                    <div class="box-header with-border">
                                <h3 class="box-title">Update Terms Conditions</h3>
                            </div>
                            <div class="box-body">
                                    <div class="form-group">
                                        <label for="app_name">Terms & Conditions:</label>
                                        <textarea rows="10" cols="10" class="form-control" name="terms_conditions" id="terms_conditions" required><?=$res[2]->value?></textarea>
                                    </div>
                                </div>
                                    
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn-primary btn" value="Update" name="btn_update"/>
                                </div>
                            </form>
                             <?php } else { ?>
                                <div class="alert alert-danger">You have no permission to view settings</div>
                             <?php } ?>
                           
                        </div>
                        <!-- /.box -->
                        
                        <!-- /.box -->
                    </div>
                    </div>
            <div class="separator"> </div>
			
<script type="text/javascript" src="<?=base_url()?>assets/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">CKEDITOR.replace('privacy_policy');CKEDITOR.replace('terms_conditions');</script>
<script>
setTimeout(function() {
$('.alert').fadeOut('slow');
}, 2000);
</script>