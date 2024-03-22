<?php if($permissions['events']['read']==1) { ?>
<style>
.uppercase {
  text-transform: uppercase;
}
</style>

<div class="col-md-4" style="margin-bottom:10px;">
    <?php if($permissions['events']['create']==1){?>
	<a href='<?= base_url('update_events/add')?>' class='btn btn-primary btn-sm'>Add Events</a>
    <?php } ?>
</div>


    <div class="row small-spacing">
        <div class="col-xs-12">
        <?php if(!empty($this->session->flashdata('message'))){
			            echo $this->session->flashdata('message'); 
			        }elseif(isset($success)){ 
				         echo $success ; 
			        } 
		    ?>
        
			<div class="box-content">
				<table id="xin_table" style="width:100%" class="datatable table table-striped table-bordered table-hover">
				 <thead>
                <tr>
                  <th>ID</th>						 
                  <th>Title</th>
                  <th>Image</th>
                  <th>Place</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Hosted By</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
			  </table>
                    
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
    <div class="alert alert-danger topmargin-sm leftmargin-sm">You have no permission to view events.</div>
 <?php } ?>