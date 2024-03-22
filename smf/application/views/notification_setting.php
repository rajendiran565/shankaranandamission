<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
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
                                <h3 class="box-title">Update Notification Settings</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form  method="post" enctype="multipart/form-data" action="<?=base_url('notification_settings')?>">
                                <div class="box-body">
                                    
                                        <div class="form-group">
                                        <label for="fcm_server_key">FCM Server Key : </label>
                                        <textarea class="form-control" name="fcm_server_key" placeholder='FCM Server Key' rows="5"><?=$res?></textarea>
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
                    </div>
                </div>
            <div class="separator"> </div>

<script>
setTimeout(function() {
$('.alert').fadeOut('slow');
}, 2000);
</script>