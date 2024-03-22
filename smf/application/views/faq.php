<div class="row small-spacing">
	<div class="col-lg-12 col-xs-12">
    <?php if(isset($success)){ echo $success ; } ?>
		<div class="box-content card white">
			<h4 class="box-title">Frequently Asked Questions</h4>
            <!-- /.box-title -->
            <div class="card-content">
                <div class="box-body">
                  <ol class="products-list product-list-in-box">
				  <?php
					if($permissions['faqs']['read']==1){

					foreach ($faqs as $row){ ?>
                        <div class="row">
                            <div class="col-md-9">
					            <a href="" class="product-title"><?php echo $row->question;?> </a>
                                <p class="product-description"><?php echo $row->answer;?></p>
                            </div>

					        <div class="col-md-3">
					            <a data-id = "<?=$row->id;?>" class="product-title delete-faq"><span class="label label-warning pull-right">Delete</span></a>
                                <a  data-id = "<?=$row->id;?>" data-query = "<?=$row->question;?>"  data-answer = "<?=$row->answer;?>" data-status = "<?=$row->status;?>" data-toggle='modal' data-target='#editFaqModal' class="product-title edit_faq"><span class="label label-success pull-right">Edit | Answer</span></a>					  
					        </div>
					    </div>
					    <hr>
					<?php } }  else {?>

					<div class="alert alert-danger">You have no permission to read faq</div>

					<?php } ?>
                    </ol>
                </div><!-- /.box-body -->

            <?php echo isset($error['add_query']) ? $error['add_query'] : '';?>
            <div class="box-footer">
			    <form  method="post" id="faq_add_form" enctype="multipart/form-data">
                    <div class="input-group">
                        <input class="form-control" name="query" placeholder="Add a Query..."><?php echo isset($error['query']) ? $error['query'] : '';?>
					    <input class="form-control" name="answer" placeholder="Add a Answer..."/><?php echo isset($error['answer']) ? $error['answer'] : '';?>
                        <div class="input-group-btn">
                            <button style="color:white !important" class="btn btn-primary" type="submit" name="btnAdd"><i class="fa fa-plus"></i></button>
					    </div>
                    </div>
				</form>
			</div><!-- /.box-footer -->
        </div>
		<!-- /.card-content -->
	</div>
	<!-- /.box-content -->
</div>
<!-- /.col-lg-6 col-xs-12 -->
</div>
<!-- /.row small-spacing -->		
