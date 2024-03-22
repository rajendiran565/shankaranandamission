<?php if($permissions['banner']['read']==1) { ?>
<style>
.uppercase {
  text-transform: uppercase;
}
</style>
    <div class="row small-spacing">
        <div class="col-xs-4">
			<!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Banner</h3>

                </div><!-- /.box-header   -->
                <!-- form start -->
                <form  method="post"  id="add_banner" action="<?=base_url()?>add_banner" enctype="multipart/form-data">

                  <div class="box-body">
                    <div class="form-group">
                        <label for="image">Banner :&nbsp;&nbsp;&nbsp;*Please choose image</label>
                        <input type="file" name="banner" id="fileupload" accept=".jpg,.jpeg,.png,.gif">
                        <br/>
                        <img id = "banner_img"  width="25%!important"/>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="submit_btn" name="btnAdd">Add</button>
                    <input type="reset" class="btn-warning btn" value="Clear"/>
                </div>

                <div class="form-group">
                    <div id="result" style="display: none;"></div>
                </div>
                </form>
              </div><!-- /.box -->
             </div>


        <div class="col-xs-8">
			<div class="box-content">
				<div class="row">
				
				<table id="xin_table" style="width:100%" class="datatable table table-striped table-bordered table-hover">
				 <thead>
                <tr>
                  <th>ID</th>						 
                  <th>Banner</th>
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
			  </table>
                    
            </div>
        </div>
    </div>
    </div>
	
	<script>
		$(document).ready(function() {
			var xin_table = $('#xin_table').dataTable({
				"scrollX": true,
				"bDestroy": true,
				"order": [[ 0, "desc" ]],
				"ajax": {
					url : base_url+'<?=$table_link?>'+"/",
					type : 'POST'
				},
				"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
				}
			});
		});
	</script>

<script type="text/javascript">

function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $("#banner_img").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $('#fileupload').change(function() {
    readURL(this);
  });


</script>

 <?php } else { ?>
    <div class="alert alert-danger topmargin-sm leftmargin-sm">You have no permission to view banner.</div>
 <?php } ?>