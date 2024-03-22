<?php if($permissions['gallery']['read']==1) { ?>
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
            <h3 class="box-title">Add Gallery Image</h3>
          </div><!-- /.box-header   -->
          <!-- form start -->
          <form  method="post"  id="add_gallery" action="<?=base_url()?>add_gallery" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
              <label for="category">Category</label>
              <select id="category" name="category"  class="form-control" required>
                <?php if(isset($options)) { foreach($options as $option) { ?>     
                <option value="<?=$option->id?>"><?=$option->name?></option>  
                <?php } }else{ ?>
                <option value="">Select Category</option>  
                <?php } ?>
              </select>
            </div>    
            <div style="float: right;!important"> 
                <a href="javascript:void(0)" class="btn-xs btn-primary" style="border: none!important;" title='Add Category' data-toggle = 'modal' data-target = '#addCategoryModal'>Add Category</a>
            </div>
            <br/>
            <div class="form-group">
              <label for="image">gallery :&nbsp;&nbsp;&nbsp;*Please choose image</label>
              <input type="file" name="gallery" id="fileupload" accept=".jpg,.jpeg,.png,.gif">
              <br/>
              <img id = "gallery_img" width="25%!important"/>
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
              <th>Image</th>
              <th>Category</th>
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

<div class="row small-spacing">
      <div class="col-xs-8">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Gallery category</h3>
          </div><!-- /.box-header   -->
          <div class="box-content">
				    <div class="row">
				      <table id="xin_table1" style="width:100%" class="datatable table table-striped table-bordered table-hover">
				        <thead>
                  <tr>
                    <th>ID</th>						 
                    <th>Title</th>
                    <th class="cat_action_list">Action</th>
                  </tr>
                </thead>
              <tbody>
              </tbody>
			        </table>
            </div>
          </div><!-- /.box -->
        </div>
        <div class="col-xs-4"></div>
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

<script>
		$(document).ready(function() {
			var xin_table = $('#xin_table1').dataTable({
				"scrollX": true,
				"bDestroy": true,
				"order": [[ 0, "desc" ]],
				"ajax": {
					url : base_url+'<?=$category_link?>'+"/",
					type : 'POST'
				},
				"fnDrawCallback": function(settings){
				$('[data-toggle="tooltip"]').tooltip();          
				}
			});
		});
	</script>

<script type="text/javascript">

function readURL1(input) {
  
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
       
        $("#gallery_img").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $('#fileupload').change(function() {
    readURL1(this);
  });


</script>

 <?php } else { ?>
    <div class="alert alert-danger topmargin-sm leftmargin-sm">You have no permission to view gallery.</div>
 <?php } ?>