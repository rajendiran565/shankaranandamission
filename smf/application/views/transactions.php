<div class="row">
   <!-- Left col -->
   <div class="col-xs-12">
      <?php if($permissions['transactions']['read']==1){

         ?>
      <div class="box-header">
         <h3 class="box-title">Transactions</h3>
         <div class="box-tools">
         <form method="post" name="form1">
               <ul class="list-inline margin-bottom-0">
                  <li class="form-group">
                     From<input class="form-control" type="date" id="start_date" name="start_date" placeholder="YYYY/MM/DD" autocomplete="off" required/>
                  </li>
                  <li class="form-group">
                     To<input class="form-control" type="date" id="end_date" name="end_date" placeholder="YYYY/MM/DD" autocomplete="off" required/>
                  </li>
                  <li class="form-group">
                     <button type="submit" id="date_filter" class="form-control btn btn-default"><i class="fa fa-search"></i></button>
                  </li>
               </ul>
            </form> 
         </div>
      </div>
      <?php } else { ?>
      <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view transactions</div>
      <?php } ?>
   </div>
</div>


<div class="content-header">
   <h1>Records List</h1>
   <hr/>
</div>
<!-- search form -->
<div id="wrapper">
<!-- Main row -->
<div class="row small-spacing">
        <div class="col-xs-12">
			<div class="box-content">
               <table id="xin_table" style="width:100%" class="datatable table table-striped table-bordered table-hover">
                  <thead>
                     <tr>				
                        <th>SN</th>
                        <th>Transaction ID</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Transaction Date</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
      </div>
      
      <div class="separator"> </div>
   
 
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

	   $('#date_filter').on('click',  function(e) {
		   
        e.preventDefault();

			$('#xin_table').dataTable({
				"scrollX": true,
				"bDestroy": true,
				"order": [[ 0, "desc" ]],
				"ajax": {
					url : base_url+'<?=$table_link?>'+"/",
					type : 'POST',
					"data": function(d){
						d.start_date = $('#start_date').val();
						d.end_date = $('#end_date').val();
					}
				}
			});
		});

   });

   

</script>