<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <?php   if(!empty($this->session->flashdata('message'))){
			        echo $this->session->flashdata('message'); 
			    }elseif(isset($success)){ 
				    echo $success ; 
			    } 
		?>
            <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form  method="post" enctype="multipart/form-data" action="<?=base_url('blessings')?>">
                <div class="box-body">

                    

                    <div class="form-group">
                        <label for="app_name">Daily Blessings :</label>
                            <textarea rows="10" cols="10" class="form-control" name="blessings" required><?php if(isset($res->blessing)){ echo $res->blessing ; }?></textarea>
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
			

<script>
setTimeout(function() {
$('.alert').fadeOut('slow');
}, 2000);
</script>