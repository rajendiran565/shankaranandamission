<?php if($permissions['users']['read']==1) { ?>
<style>
.uppercase {
  text-transform: uppercase;
}
</style>
    <div class="row small-spacing">
        <div class="col-xs-12">
			<div class="box-content">
				<table id="xin_table" style="width:100%" class="datatable table table-striped table-bordered table-hover">
				 <thead>
                <tr>
                  <th>ID</th>						 
                  <th>Email</th>
                  <th>Registration Time</th>
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
    <div class="alert alert-danger topmargin-sm leftmargin-sm">You have no permission to view Users.</div>
 <?php } ?>