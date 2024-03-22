<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class paypalandroid extends CI_Controller {
    
    public function __construct(){
        
        parent::__construct();
        
	    $this->common_model->set_timezone();
    }
    

    public function JSONResponse($result){
		echo exit(json_encode($result));
	}
	
	private function check_access($key){

        $con = array('variable'=> 'api_key');

        $res = $this->common_model->selectbyfield('value','settings' , $con)->row(); 

        $api_key = $res->value;

        if($api_key == $key){

            return true;

        }else{

            return false; 
        }
    }
	
	function payment_param(){
	    
	   $this->form_validation->set_rules('user_id', 'Provide user_id', 'trim|required'); 
	   $this->form_validation->set_rules('item_name' , 'Provide item_name' , 'trim|required');
       $this->form_validation->set_rules('item_number', 'Provide item_number', 'trim|required');
       $this->form_validation->set_rules('amount', 'Provide amount', 'trim|required');
       $this->form_validation->set_rules('access_key', 'Provide access_key', 'trim|required');
        
        if($this->form_validation->run())
		{
            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

               $user_id = $this->input->post('user_id');
               $item_name = $this->input->post('item_name');
               $item_number = $this->input->post('item_number');
               $amount = $this->input->post('amount');
               
               $item_number = date('dmhis').rand(99,999).'_'.$item_number;
               
               $url = "https://www.shankaranandamissionfoundation.com/paypalandroid/create_payment?user_id=".$user_id."&item_name=".$item_name."&item_number=".$item_number."&amount=".$amount;

			   return $this->JSONResponse(array('status'=>1,'message'=>'Paypal payment url' , 'data' => $url));
		       
            }else{
                
            return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
           }
		}else{
		    
		    $error = validation_errors();
			$error = trim(strip_tags($error));
			return $this->JSONResponse(array('status'=>0,'message'=>$error));
		}
	}
	
	function create_payment(){
	    
	    $this->load->library('paypal_lib');
	    
        $returnURL = base_url().'paypalandroid/success';
        $cancelURL = base_url().'paypalandroid/cancel'; 
        $notifyURL = base_url().'paypalandroid/ipn';
        
        $payment_data = $this->input->get();

        $item_name = $payment_data['item_name'];
        $item_number = $payment_data['item_number'];
        $userID = $payment_data["user_id"];
        $price = $payment_data["amount"];
     
        $logo = base_url().'assets/images/logo.png';
        
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $item_name);
        $this->paypal_lib->add_field('custom', $userID);
        $this->paypal_lib->add_field('item_number',  $item_number);
        $this->paypal_lib->add_field('amount',  $price);        
        $this->paypal_lib->image($logo);

        $this->paypal_lib->paypal_auto_form();
    }

   
    public function success() {
        
        $pay_detail = $_REQUEST;
        
        $payment_status = $_REQUEST["payment_status"];
        
        $this->sendPayment_confoirmation($pay_detail);
        
        $this->status_msg($payment_status);
    }
    
    
    public function cancel() {
        
        $data['payment_status'] = 'cancel';
        $this->load->view('paypal_cancel' , $data);
    }
    
    public function failed($status) {
        $pay_detail = $_REQUEST;
        $data['payment_status'] = $status;
        $this->sendPayment_confoirmation($pay_detail);
        $this->load->view('paypal_cancel' , $data);
    }
    

    public function ipn() {
        
        $this->load->library('paypal_lib');
      
        $paypalInfo = $this->input->post();

        $data['user_id'] = $paypalInfo['custom'];
        $data['category'] = $paypalInfo["item_number"];
        $data['txn_id'] = $paypalInfo["txn_id"];
        $data['amount'] = $paypalInfo["payment_gross"];
        $data['currency_code'] = $paypalInfo["mc_currency"];
        $data['status'] = $paypalInfo["payment_status"];
        $data['transaction_date'] = date('Y-m-d H:i:s');
        
        $insert_data =  $this->security->xss_clean($data);

        $paypalURL = $this->paypal_lib->paypal_url;
        
        $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);

        if (preg_match("/VERIFIED/i", $result)) {
            $result = $this->db->insert('transactions', $insert_data);
        }
    }
    
    private function status_msg($status){
        
        if($status == 'Completed' || $status == 'completed' ){
            $data['status'] = $status;
            $this->load->view('paypal_success' , $data);
        }else{
           $this->failed($status);
        }
        
    }
    
    
    private function sendPayment_confoirmation($pay_detail){
        
        $user_id = $pay_detail['custom'];
        
        $users_details = $this->common_model->selectbyfield('fullname,email' ,'users' , array('id' => $user_id))->row();
        
        $txn_id = $pay_detail['txn_id'];
        $payment_status = $pay_detail['payment_status'];
        $item_name = $pay_detail['item_name'];
        $amount = $pay_detail['payment_gross'];
        
        $puser_name  = $users_details->fullname;
        $puser_email = $users_details->email;
        
        $subject = 'Payment Confirmation';
        
        $message = 'Hii , you payment'.' '.$payment_status.'<br/>Transaction id:'.$txn_id.'<br/>Category:'.$item_name.'<br/>Date:'.date('d-m-Y').'<br/>Amount:'.$amount;
        
        $this->common_model->send_email($puser_email,$subject,$message);
        
        return true;
    }
    
    

}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
