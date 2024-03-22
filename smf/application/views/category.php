<?php if($permissions['category']['read']==1) { ?>
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
                  <h3 class="box-title">Add Donation Category</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form  method="post" id="add_category" action="<?=base_url()?>add_category">

                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Title</label>
                      <input type="text" class="form-control"  name="name">
                    </div> 
                  </div><!-- /.box-body -->

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
                  <th>Title</th>
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

 <?php } else { ?>
    <div class="alert alert-danger topmargin-sm leftmargin-sm">You have no permission to view Category.</div>
 <?php } ?>