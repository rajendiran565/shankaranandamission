<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-6">
        <!-- general form elements -->
        <?php if($permissions['settings']['read']==1){
                    if($permissions['settings']['update']==0) { ?>
                        <div class="alert alert-danger">You have no permission to update settings</div>
                    <?php } ?>
                    <div class="box box-primary">
                       <div class="box-header with-border">
                       <h3 class="box-title">Update System Settings</h3>
                    </div>
                    <!-- /.box-header -->
             
                <!-- form start -->
                <form id="system_configurations_form"  method="post" enctype="multipart/form-data">

                    <input type="hidden" id="system_configurations" name="system_configurations" required="" value="1" aria-required="true">
                    <input type="hidden" id="system_timezone_gmt" name="system_timezone_gmt" value="<?php if(!empty($data['system_timezone_gmt'])){ echo $data['system_timezone_gmt']; } ?>" aria-required="true">
                    <input type="hidden" id="system_configurations_id" name="system_configurations_id" value="<?php if(!empty($id)){ echo $id; } ?>" aria-required="true">
                    
                    <div class="box-body">
                        <div class="form-group">
                            <label for="app_name">App Name:</label>
                            <input type="text" class="form-control" name="app_name" value="<?=(isset($data['app_name']))?$data['app_name']:'';?>" placeholder="Name of the App - used in whole system"/>
                        </div>
                        <div class="form-group">
                            <label for="">Support Number:</label>
                            <input type="text" class="form-control" name="support_number" value="<?=(isset($data['support_number']))?$data['support_number']:""?>" placeholder="Customer support mobile number - used in whole system"/>
                        </div>
                        <div class="form-group">
                            <label for="">Support Email:</label>
                            <input type="text" class="form-control" name="support_email" value="<?=(isset($data['support_email']))?$data['support_email']:""?>" placeholder="Customer support email - used in whole system"/>
                        </div>
                        <div class="form-group">
                            <label for="app_name">Logo:</label>
                            <img src="<?=base_url().'assets/img/'.$logo?>" title='<?=$data['app_name']?> - Logo' alt='<?=(isset($data['app_name']))?$data['app_name']:"";?> - Logo' style="max-width:100%"/>
                            <input type='file' name='logo' id='logo' accept=".jpg,.jpeg,.png,.gif"/>
                        </div>
                        <h4>Version Settings</h4><hr>

                        <div class="form-group col-md-4">
                            <label for="">Current Version Of App:</label>
                            <input type="text" class="form-control" name="current_version" value="<?=isset($data['current_version'])?$data['current_version']:''?>" placeholder='Current Version'/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Minimum Version Required: </label>
                            <input type="text" class="form-control" name="minimum_version_required" value="<?=isset($data['minimum_version_required'])?$data['minimum_version_required']:''?>" placeholder='Minimum Required Version'/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Version System Status</label><br>
                            <input type="checkbox" id="version-system-button" class="js-switch" <?php if(!empty($data['is-version-system-on']) && $data['is-version-system-on'] == '1'){ echo 'checked'; }?>>
                            <input type="hidden" id="is-version-system-on" name="is-version-system-on" value="<?=(!empty($data['is-version-system-on']))?$data['is-version-system-on']:0;?>">
                        </div><hr>
                        
                        <div class="form-group">
                            <label for="currency">Donation Currency ( Symbol or Code - $ or USD - Anyone ):</label>
                            <input type="text" class="form-control" name="currency" value="<?=!empty($currency)?$currency:'';?>" placeholder="Either Symbol or Code - For Example $ or USD"/>
                        </div>
                        

                        <div class="form-group">
                            <label class="system_timezone" for="system_timezone">System Timezone</label>
                            <select id="system_timezone" name="system_timezone" required class="form-control col-md-12">
                                <?php foreach($options as $option){?>     
                                <option value="<?=$option[2]?>" data-gmt="<?=$option['1'];?>" <?=(isset($data['system_timezone']) && $data['system_timezone'] == $option[2])?'selected':'';?>><?=$option[2]?> - GMT <?=$option[1]?> - <?=$option[0]?></option>  
                                <?php } ?>
                            </select>
                        </div>
                        <hr>
                        
                        <h4>Mail Settings</h4><hr>
                        <div class="form-group ">
                            <label for="from_mail">From eMail ID: <small>( This email ID will be used in Mail System )</small></label>
                            <input type="email" class="form-control" name="from_mail" value="<?=$data['from_mail']?>" placeholder='From Email ID'/>
                        </div>
                        <div class="form-group">
                            <label for="reply_to">Reply To eMail ID: <small>( This email ID will be used in Mail System )</small></label>
                            <input type="email" class="form-control" name="reply_to" value="<?=$data['reply_to']?>" placeholder='From Email ID'/>
                        </div>
                        <div class="form-group">
                            <label for="mail_password">Mail Password: <small>( Mail Password for SMTP )</small></label>
                            <input type="password" class="form-control" name="mail_password" value="<?=$data['mail_password']?>" placeholder='*****'/>
                        </div>
                        <div class="form-group">
                            <label for="smtp_host">SMTP Host: <small>( SMTP Server )</small></label>
                            <input type="text" class="form-control" name="smtp_host" value="<?=$data['smtp_host']?>" placeholder='smtp.example.com'/>
                        </div>
                        <div class="form-group">
                            <label for="">SMTP Secure</label>
                            <select name="smtp_secure" class="form-control">
                                <option value="tls" <?=(isset($data['smtp_secure']) && $data['smtp_secure']=='tls')?"selected":""?> >TLS</option>
                                <option value="ssl" <?=(isset($data['smtp_secure']) && $data['smtp_secure']=='ssl')?"selected":""?>>SSL</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="smtp_port">SMTP PORT: <small>( PORT Number )</small></label>
                            <input type="text" class="form-control" name="smtp_port" value="<?=$data['smtp_port']?>" placeholder=''/>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div id="result"></div>
                    <div class="box-footer">
                        <input type="submit" id="btn_update" class="btn-primary btn" value="Update" name="btn_update"/>
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

<script type="text/javascript" src="<?=base_url()?>assets/plugin/switchery/switchery.js"></script>

<script type="text/javascript">

 var changeCheckbox = document.querySelector('#version-system-button');
      var init = new Switchery(changeCheckbox);

      changeCheckbox.onchange = function() {
          if ($(this).is(':checked')) {
              $('#is-version-system-on').val(1);
          }else{
              $('#is-version-system-on').val(0);
          }
      };

      var changeCheckbox = document.querySelector('#refer-earn-system-button');
      var init = new Switchery(changeCheckbox);
          changeCheckbox.onchange = function() {
            if ($(this).is(':checked')) {
                $('#is-refer-earn-on').val(1);
            }else{
                $('#is-refer-earn-on').val(0);
            }
          };
          
          
</script>

