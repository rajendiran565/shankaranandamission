<?php if($page=="Frequently Asked Questions"){ ?>

<div class="modal fade" id='editFaqModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit FAQ</h4>
            </div>
            <div class="modal-body">
                <?php if($permissions['faqs']['update']==0) { ?>
                    <div class="alert alert-danger">You have no permission to update FAQ</div>
                <?php } ?>

                <div class="box-body">
                    <form id="update_faq_form"  method="POST" action ="<?=base_url('settings/faq')?>" data-parsley-validate class="form-horizontal form-label-left">
                        <input type='hidden' name="faq_id" id="faq_id"/>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Question</label><?php echo isset($error['question']) ? $error['question'] : '';?>
			                <input type="text" name="query" id="query" class="form-control" value=""/>
					    </div>

                        <div class="form-group">
					       <label for="exampleInputEmail1">Answer :</label><?php echo isset($error['answer']) ? $error['answer'] : '';?>
		                   <input type="text" name="answer" id="answer" class="form-control" value=""/>
					   </div>

                        <div class="form-group">
					        <label for="exampleInputEmail1">Status :</label><?php echo isset($error['status']) ? $error['status'] : '';?>
					        <select name="status" id="status" class="form-control">	
							   <option value="1">Pending</option>
							   <option value="2" >Answered</option>
					        </select>
					    </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" id="update_btn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="update_result"></div></div>
                        </div>
                    </form>
                </div>
              
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if($view=="category"){ ?>
	<div class="modal fade" id='editCategoryModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Donation Category</h4>
                </div>
                        
                <div class="modal-body">
                    <?php if($permissions['category']['update']==0){?>
                    <div class="alert alert-danger">You have no permission to update category</div>
                    <?php }?>

                    <div class="box-body">
                        <form id="update_category"  method="POST" action ="<?=base_url()?>update_category" data-parsley-validate class="form-horizontal form-label-left">
                            <input type='hidden' name="category_id" id="category_id" value=''/>
                            <div class="form-group">
                                <label class="" for="">Name</label>
                                <input type="text" id="category_name" name="category_name" class="form-control col-md-7 col-xs-12">
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" id="update_btn" class="btn btn-success">Update</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="update_result"></div></div>
                            </div>
                        </form>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if($view=="banners"){ ?>

	<div class="modal fade" id='editBannermodal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit banner</h4>
                </div>
                        
                <div class="modal-body">
                    <?php if($permissions['banner']['update']==0){?>
                    <div class="alert alert-danger">You have no permission to update banner</div>
                    <?php } ?>

                    <div class="box-body">
                        <form id="update_banner"  method="POST" action ="<?=base_url()?>update_banner" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                            <input type='hidden' name="banner_id" id="banner_id" value=''/>

                            <div class="form-group">
                            <label for="image">Banner :&nbsp;&nbsp;&nbsp;*Please choose image</label>
                            
                            <input type="file" name="banner" id="banner" accept=".jpg,.jpeg,.png,.gif">
                            <br/>
                            <img id = "banner_img1"   width="60%!important"/>

                        </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" id="update_btn" class="btn btn-success">Update</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="update_result"></div></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if($view=="image_gallery"){ ?>

<div class="modal fade" id='editGallerymodal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Gallery Image</h4>
            </div>
                    
            <div class="modal-body">
                <?php if($permissions['gallery']['update']==0){?>
                <div class="alert alert-danger">You have no permission to update gallery</div>
                <?php } ?>

                <div class="box-body">
                    <form id="update_gallery"  method="POST" action ="<?=base_url()?>update_gallery" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                        <input type='hidden' name="gallery_id" id="gallery_id" value=''/>

                        <div class="form-group">
                           <label for="category">Category</label>
                            <select id="gall_category" name="gall_category"  class="form-control" required>
                                <?php 
                                $options = $this->common_model->selectbyfield('*' , 'category')->result();

                                if(isset($options)) { 
                                    foreach($options as $option) { ?>     
                                <option value="<?=$option->id?>"><?=$option->name?></option>  
                                <?php } }else{ ?>
                                <option value="">Select Category</option>  
                                <?php } ?>
                            </select>
                        </div>    

                        <div class="form-group">
                        <label for="image">Gallery Image :&nbsp;&nbsp;&nbsp;*Please choose image</label>
                        
                        <input type="file" name="gallery" id="gallery" accept=".jpg,.jpeg,.png,.gif">
                        <br/>
                        <img id = "gallery_img1"   width="60%!important"/>

                    </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" id="update_btn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="update_result"></div></div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id='addCategoryModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Category</h4>
            </div>
                        
            <div class="modal-body">
                <div class="box-body">
                    <form id="add_gallery_category"  method="POST" action ="<?=base_url()?>gallery_category" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="form-group">
                        <label class="" for="">Name</label>
                        <input type="text" name="gallery_category_name" class="form-control col-md-7 col-xs-12" required>
                    </div>
                    <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" id="update_btn1" class="btn btn-success">Update</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="result1"></div></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id='editGall_Catmodal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Category</h4>
            </div>
                        
            <div class="modal-body">
                <div class="box-body">
                    <form id="update_gallery_category"  method="POST" action ="<?=base_url()?>update_gallery_category" data-parsley-validate class="form-horizontal form-label-left">
                    <input type='hidden' name="cat_id" id="cat_id" value=''/>
                    <div class="form-group">
                        <label class="" for="">Name</label>
                        <input type="text" name="gallery_category_name" id="cat_name" class="form-control col-md-7 col-xs-12" required>
                    </div>
                    <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" id="update_btn1" class="btn btn-success">Update</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="update_result1"></div></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php } ?>