<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$message = '';

?>

    
    <?php if ($permissions['settings']['read'] == 1) { ?>
            <div class="row">
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Payment Methods Settings</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="col-md-12">
                                <form method="post" enctype="multipart/form-data" id="payment_configurations_form">
                                    <h5>Paypal Payments </h5>
                                    <hr>

                                    <div class="form-group">
                                        <label for="paypal_payment_method">Paypal Payments <small>[ Enable / Disable ] </small></label><br>
                                        <input type="checkbox" id="paypal_payment_method_btn" class="js-switch"
                                            <?php if (!empty($data['paypal_payment_method']) && $data['paypal_payment_method'] == '1') {
                                                    echo 'checked';
                                            } ?>>
                                        <input type="hidden" id="paypal_payment_method" name="paypal_payment_method" value="<?= (isset($data['paypal_payment_method']) && !empty($data['paypal_payment_method'])) ? $data['paypal_payment_method'] : 0; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Payment Mode <small>[ sandbox / live ]</small></label>
                                        <select name="paypal_mode" class="form-control" required>
                                            <option value="">Select Mode </option>
                                            <option value="sandbox" <?= (isset($data['paypal_mode']) && $data['paypal_mode'] == 'sandbox') ? "selected" : "" ?>>Sandbox ( Testing )</option>
                                            <option value="production" <?= (isset($data['paypal_mode']) && $data['paypal_mode'] == 'production') ? "selected" : "" ?>>Production ( Live )</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="paypal_business_email">Paypal Business Email</label>
                                        <input type="text" class="form-control" name="paypal_business_email" value="<?= (isset($data['paypal_business_email'])) ? $data['paypal_business_email'] : '' ?>" placeholder="Paypal Business Email" />
                                    </div>
                                    <hr>
                                    
                                    <h5>Stripe Payments </h5>
                                    <hr>

                                    <div class="form-group">
                                        <label for="stripe_payment_method">Stripe Payments <small>[ Enable / Disable ] </small></label><br>
                                        <input type="checkbox" id="stripe_payment_method_btn" class="js-switch"
                                            <?php if (!empty($data['stripe_payment_method']) && $data['stripe_payment_method'] == '1') {
                                                    echo 'checked';
                                            } ?>>
                                        <input type="hidden" id="stripe_payment_method" name="stripe_payment_method" value="<?= (isset($data['stripe_payment_method']) && !empty($data['stripe_payment_method'])) ? $data['stripe_payment_method'] : 0; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="stripe_publishable_key">Publishable key</label>
                                        <input type="text" class="form-control" name="stripe_publishable_key" value="<?= (isset($data['stripe_publishable_key'])) ? $data['stripe_publishable_key'] : '' ?>" placeholder="Stripe publishable key" />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="stripe_secret_key">Secret key</label>
                                        <input type="text" class="form-control" name="stripe_secret_key" value="<?= (isset($data['stripe_secret_key'])) ? $data['stripe_secret_key'] : '' ?>" placeholder="Stripe secret key" />
                                    </div>

                                   
                                    <hr>
                                    
                                    <div id="result"></div>
                                    <input type="submit" id="btn_update" class="btn-primary btn" value="Update" name="btn_update" />
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
    <?php } else { ?>
        <div class="alert alert-danger">You have no permission to view settings</div>
    <?php } ?>
    <div class="separator"> </div>

</body>

</html>
<script type="text/javascript" src="<?=base_url()?>assets/plugin/switchery/switchery.js"></script>

<script type="text/javascript">
    var changeCheckbox1 = document.querySelector('#paypal_payment_method_btn');

    var init1 = new Switchery(changeCheckbox1);
   
    /* paypal change button value */
    changeCheckbox1.onchange = function() {
        // alert(changeCheckbox1.checked);
        if (changeCheckbox1.checked)
            $('#paypal_payment_method').val(1);
        else
            $('#paypal_payment_method').val(0);
    };
    
    var changeCheckbox2 = document.querySelector('#stripe_payment_method_btn');

    var init2 = new Switchery(changeCheckbox2);
   
    /* paypal change button value */
    changeCheckbox2.onchange = function() {
        // alert(changeCheckbox1.checked);
        if (changeCheckbox1.checked)
            $('#stripe_payment_method').val(1);
        else
            $('#stripe_payment_method').val(0);
    };
</script>