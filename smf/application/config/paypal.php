<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------
// Paypal library configuration
// ------------------------------------------------------------------------

// PayPal environment, Sandbox or Live

$ci = & get_instance();

$payment_data = $ci->common_model->selectbyfield('value' , 'settings' , array('variable' => 'payment_methods'))->row();
	


$payment_data = json_decode($payment_data->value);
 
if($payment_data->paypal_payment_method == 1 ){
	    
	 if($payment_data->paypal_mode == "sandbox") {
	     
	    $config['sandbox'] = TRUE;
	    $config['business'] = $payment_data->paypal_business_email;
	                         	
     }elseif($payment_data->paypal_mode == "production") {
        $config['sandbox'] = FALSE;                 	    
		$config['business'] = $payment_data->paypal_business_email;
		                        
	}
}

// What is the default currency

$config['paypal_lib_currency_code'] = 'USD';

// Where is the button located at

$config['paypal_lib_button_path'] = 'assets/images/';

// If (and where) to log ipn response in a file

$config['paypal_lib_ipn_log'] = TRUE;
$config['paypal_lib_ipn_log_file'] = BASEPATH . 'paypal_logs/paypal_ipn.log';