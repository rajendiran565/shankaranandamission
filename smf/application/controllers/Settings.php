<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

	function formatOffset($offset) {
		$hours = $offset / 3600;
		$remainder = $offset % 3600;
		$sign = $hours > 0 ? '+' : '-';
		$hour = (int) abs($hours);
		$minutes = (int) abs($remainder / 60);
	
		if ($hour == 0 AND $minutes == 0) {
			$sign = ' ';
		}
		return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT).':'. str_pad($minutes,2, '0');
	}


	function getTimezoneOptions(){
		$list = DateTimeZone::listAbbreviations();
		$idents = DateTimeZone::listIdentifiers();
		
		$data = $offset = $added = array();

		foreach ($list as $abbr => $info) {
			foreach ($info as $zone) {
				if ( ! empty($zone['timezone_id'])
					AND
					! in_array($zone['timezone_id'], $added)
					AND 
					  in_array($zone['timezone_id'], $idents)) {

					$z = new DateTimeZone($zone['timezone_id']);
					$c = new DateTime(null, $z);

					$zone['time'] = $c->format('H:i a');

					$offset[] = $zone['offset'] = $z->getOffset($c);
					$data[] = $zone;
					$added[] = $zone['timezone_id'];
				}
			}
		}
	
		array_multisort($offset, SORT_ASC, $data);
		
		$i = 0;$temp = array();

		foreach ($data as $key => $row) {
			$temp[0] = $row['time'];
			$temp[1] = $this->formatOffset($row['offset']);
			$temp[2] = $row['timezone_id'];
			$options[$i++] = $temp;
		}
	
		return $options;
	}


	
	public function app_settings()
	{
		$data['page']="App Settings";
		$data['view']='app_setting';
        $data['data'] =  $this->common_model->get_configurations();
		$data['options']=  $this->getTimezoneOptions();
		$this->template($data);
	}


	public function add_settings(){
	
		$permissions = $this->get_permissions();
	
		if($permissions['settings']['update']==0){
			echo '<label class="alert alert-danger">You have no permission to update settings</label>';
			return false;
		}
		
		$date = date('Y-m-d');
	
		$currency = empty($this->security->xss_clean($_POST['currency']))?'₹':$this->security->xss_clean($_POST['currency']);
	
		$this->common_model->update_table('settings',array('value' => $currency),array('variable' => 'currency'));
			
		$message = "<div class='alert alert-success'> Settings updated successfully!</div>";
			
		$_POST['system_timezone_gmt'] = (trim($this->security->xss_clean($_POST['system_timezone_gmt'])) == '00:00') ? "+".trim($this->security->xss_clean($_POST['system_timezone_gmt'])) : $this->security->xss_clean($_POST['system_timezone_gmt']);
			
		if(preg_match("/[a-z]/i", $this->security->xss_clean($_POST['current_version']))){
				$_POST['current_version']=0;
		}
		
		$settings_value = json_encode($this->security->xss_clean($_POST));
	
		$this->common_model->update_table('settings',array('value' => $settings_value),array('variable' => 'system_timezone'));
	
	
		if(isset($_FILES['logo'])  &&  $_FILES['logo']['size'] > 0 )
		{
			$logo = $this->common_model->get_settings('logo');
			$path = 'assets/img/';

			$old_image = $path.$logo;

			$upload['upload_path'] =  'assets/img/';
            $upload['allowed_types'] = 'jpg|jpeg|pdf|png';
            $image = 'logo'.date('dmYhis').pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $upload['file_name'] = $image;

            $this->load->library('upload');
            $this->upload->initialize($upload);

            if (!$this->upload->do_upload('logo')) {
				$message = "Image could not be uploaded<br/>";
            }else{ 
				$upload_data = $this->upload->data();
                $filename=$upload_data['file_name']; 

				if(file_exists($old_image)){
					unlink($old_image);
				}

                $this->common_model->update_table('settings',array('value' => $filename),array('variable' => 'logo'));
			}
	}
		
		echo "<p class='alert alert-success'>Settings Saved!</p>";
	}




	public function payment_methods(){

		$con = array('variable'=> 'payment_methods');
        $res = $this->common_model->selectbyfield('value','settings' , $con)->row();

		$payment_setting =json_decode($res->value);
        $data['data'] = (array)$payment_setting;
		$data['page']="Payment Methods Settings";
		$data['view']='payment_methods';
		$this->template($data);
	}


	public function add_payment_methods(){
	
		$permissions = $this->get_permissions();
	
		if($permissions['settings']['update']==0){
			echo '<label class="alert alert-danger">You have no permission to update settings</label>';
			return false;
		}
	
		$settings_value = json_encode($this->security->xss_clean($_POST));
		
		$result = $this->common_model->update_table('settings',array('value' => $settings_value),array('variable' => 'payment_methods'));
	
		if($result){
	
		   echo "<p class='alert alert-success'>Settings Saved!</p>";
	
		}else{
	
			echo "<p class='alert alert-danger'>Settings Not Saved!</p>";	
		}
	}


	public function notification_settings(){

		$permissions = $this->get_permissions();

		$con = array('variable'=> 'fcm_server_key');
        $res = $this->common_model->selectbyfield('value','settings' , $con)->row();
		$data['res']=$res->value;
		$data['page']="Notification Setting";
		$data['view']='notification_setting';

		$message = '';

		if(isset($_POST['btn_update'])){

			if($permissions['settings']['update']==1){
				
				$fcm_server_key = $this->security->xss_clean($_POST['fcm_server_key']);
				
				$update_data = array('value' => $fcm_server_key);

				$result = $this->db->update('settings',$update_data, $con);
				
				$sql = "SELECT * FROM settings WHERE variable='fcm_server_key'";

				$data['res']= $this->db->query($sql)->row()->value;
			
			  
				$message .= "<div class='alert alert-success'> FCM Server Key Updated Successfully!</div>";

				}else{

				$message .= "<label class='alert alert-danger'>You have no permission to update settings</label>";

			}
			$data['success'] = $message;
		}

		$this->template($data);
	}


	public function contact_us(){

		$permissions = $this->get_permissions();

		$con = array('variable'=> 'contact_us');
        $res = $this->common_model->selectbyfield('*','settings' , $con)->row();
		$data['res']= $res->value;
		$data['page']="Contact US";
		$data['view']='contact_us';

		$message = '';

		if(isset($_POST['btn_update'])){

			if($permissions['settings']['update']==1){
				
				$contact_us = $this->security->xss_clean($_POST['contact_us']);
				
				$update_data = array('value' => $contact_us);

				$result = $this->db->update('settings',$update_data, $con);
				
				$sql = "SELECT * FROM settings WHERE variable='contact_us'";

				$data['res']= $this->db->query($sql)->row()->value;
			
			  
				$message .= "<div class='alert alert-success'> Contact detail Updated Successfully!</div>";

				}else{

				$message .= "<label class='alert alert-danger'>You have no permission to update settings</label>";

			}
			$data['success'] = $message;
		}

		$this->template($data);
	}


	public function privacy_policy(){

		$permissions = $this->get_permissions();

		$sql="SELECT * FROM settings";
		$data['res']=$this->db->query($sql)->result();
		$data['page']="Privacy Policy";
		$data['view']='privacy_policy';

		$message = '';

		if(isset($_POST['btn_update'])){

			if($permissions['settings']['update']==1){
				
				$privacy_policy = $this->security->xss_clean($_POST['privacy_policy']);
				$terms_conditions = $this->security->xss_clean($_POST['terms_conditions']);
				
				$update_data1 = array('value' => $privacy_policy);
				$update_data2 = array('value' => $terms_conditions);
				$con1 = array('variable' => 'privacy_policy');
				$con2 = array('variable' => 'terms_conditions');

				$result1 = $this->db->update('settings',$update_data1, $con1);
				$result2 = $this->db->update('settings',$update_data2, $con2);
				
				$sql="SELECT * FROM settings";
				$data['res']=$this->db->query($sql)->result();
	
				$message .= "<div class='alert alert-success'> Policy Updated Successfully!</div>";

				}else{

				$message .= "<label class='alert alert-danger'>You have no permission to update settings</label>";

			}
			$data['success'] = $message;
		}

		$this->template($data);
	}
		


	public function faq(){
		$data['page']="Frequently Asked Questions";
		$data['view']='faq';
		$fields = 'id, question, answer,status';
		$data['faqs'] = $this->common_model->selectbyfield($fields,'faq')->result();
		$this->template($data);
	}
	
	public function add_faq(){
		$permissions = $this->get_permissions();
	
		if($permissions['faqs']['update']==0){
			echo 2; 
			return false;
		}
	
		if($this->input->post('query') && $this->input->post('answer')) {
	
			$question = $this->security->xss_clean($_POST['query']);
			$answer = $this->security->xss_clean($_POST['answer']);
	
			if(isset($_POST['status'])){
			  $status = $this->security->xss_clean($_POST['status']);
			}else{
			   $status = 1;
			}
	
			$insert_data = array('question' => $question, 'answer' => $answer, 'status' => $status);
	
			if($this->input->post('faq_id')){
				$id = $this->security->xss_clean($_POST['faq_id']);
	
				$result = $this->common_model->update_table('faq', $insert_data , array('id' => $id));
	
			}else{	
	
				$result = $this->db->insert('faq',$insert_data);
	
			}
	
			if($result){
				echo 0;
			}else{
				echo 1;
			}
			
		}else{
			echo 3;
		}
	
	}
	
	
	
	public function delete_faq(){
	
		$permissions = $this->get_permissions();
	
			if($permissions['faqs']['update']==0){
			   echo 2; 
			   return false;
			}
	
		$id= $this->security->xss_clean($_POST['faq_id']);
	
		$sql = "DELETE FROM `faq` WHERE id=".$id;
		
		if($this->db->query($sql)){
			echo 0;
		}else{
			echo 1;
		}
	}




	public function notification(){
		$data['page']="Push Notification";
		$data['view']='notification';
		$data['categories_result'] = $this->common_model->selectbyfield('*','category');
		$data['products_result'] = $this->common_model->selectbyfield('*','products');
		$data['table_link'] = "settings/notification_list";
	
		$this->template($data);
	}



	public function notification_list(){
		$draw = intval($this->input->get("draw"));

		$start = intval($this->input->get("start"));

		$length = intval($this->input->get("length"));
	
		
		$constant = $this->db->query("SELECT * FROM `notifications`");

		$data = array();
		$i=1;
        foreach($constant->result() as $r) {
			$operate = " <a class='btn btn-xs btn-danger delete-notification' data-id='".$r->id."' data-image='".$r->image."' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>";
			
			$data[] = array($r->id,$r->title,$r->message, $r->type, (!empty($r->image))?"<a data-lightbox='slider' href='".base_url().$r->image."' data-caption='".$r->title."'><img src='".base_url().$r->image."' title='".$r->title."' width='50' /></a>" : "No Image", $operate);
			$i++;
		}
		$output = array(

		   "draw" => $draw,

			 "recordsTotal" => $constant->num_rows(),

			 "recordsFiltered" => $constant->num_rows(),

			 "data" => $data

		);

		

	  echo json_encode($output);

	  exit();		
	}


	public function add_push_notification(){

      $permissions = $this->get_permissions();


	  if(isset($_POST['title']) and isset($_POST['message'])) {

		if($permissions['notifications']['create']==0){

			echo '<p class="alert alert-danger">You have no permission to send notifications</p>';
			return false;

		}

		
		$title = $this->security->xss_clean($_POST['title']);
		$message = $this->security->xss_clean($_POST['message']);
		$type = $this->security->xss_clean($_POST['type']);

		$id = ($type != 'default')?$_POST[$type]:"0";
		
		
		$include_image = (isset($_POST['include_image']) && $this->security->xss_clean($_POST['include_image']) == 'on') ? TRUE : FALSE;
		
		$insert_data = array('title' => $title,
		                     'message' =>$message,
							 'type' => $type,
							 'type_id'=> $id 
	                        );

		if($include_image){
			
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$extension = explode(".", $_FILES["image"]["name"]);
			$extension = end($extension);

			if(!(in_array($extension, $allowedExts))){
				echo '<p class="alert alert-danger">Image type is invalid</p>';
				return false;
			}

			$target_path = 'upload/notifications/';

			$filename = microtime(true).'.'. strtolower($extension);

			$full_path = $target_path."".$filename;

			if(!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)){

				echo '<p class="alert alert-danger">Image type is invalid</p>';
				return false;
			}

			$insert_data = array_merge($insert_data , array('image' =>$full_path));

		}

		$this->db->insert('notifications',$insert_data);

	
		$server_url =base_url();
		
		//first check if the push has an image with it
		if($include_image){

			$mPushNotification = $this->getPush( $title,$message, $server_url.''.$full_path,$type,$id);

		}else{

			//if the push don't have an image give null in place of image
			$mPushNotification = $this->getPush( $title,$message,null,$type,$id);
		
		}

		$res = $this->common_model->selectbyfield('fcm_id','users');

		$devicetoken = array(); 

		if($res){
			foreach($res as $row){
				array_push($devicetoken, $row->fcm_id);
			}

		    $this->sendPushNotification($devicetoken, $mPushNotification);

            echo '<p class="alert alert-success">Notification Sent Successfully!</p>';


		}else{
		    echo '<p class="alert alert-danger">Fcm id not fount</p>';

		}
		
    }else{
		echo '<p class="alert alert-danger">Notification title and message required !!</p>';
	}
}



	
    public function delete_notification(){

		$id= $this->security->xss_clean($_POST['id']);

        if($id==104){
              echo 3;
              return false;
        }

        $sql = "DELETE FROM `notifications` WHERE id=".$id;
        
		if($this->db->query($sql)){
			echo 1;
		}else{
			echo 2;
		}
	}


public function transactions(){
	$data['page']="Transactions";
	$data['view']='transactions';
	$data['table_link']='settings/transaction_list';
	$this->template($data);
}


public function transaction_list(){

	$where = array();
	$currency=$this->get_settings('currency');
	
	$draw = intval($this->input->get("draw"));

	$start = intval($this->input->get("start"));

	$length = intval($this->input->get("length"));


	if($this->input->post('start_date') != '' && $this->input->post('end_date') !=''){

		$from_date = $this->input->post('start_date');
		$to_date = $this->input->post('end_date');

		$where = array('t.date_created <= ' => $to_date , 't.date_created >=' => $from_date);
	
		$transactions = $this->setting_model->transaction_list($where);

		$total_records = count((array)$transactions);

	}else{


	$transactions = $this->setting_model->transaction_list();

	$total_records = count((array)$transactions);

	}
	
	$data = array();
	$i=1;

	foreach($transactions as $key => $value) {
		$data[] = array($i , $value->id, $value->name, $value->order_id, $value->type , $value->payu_txn_id , $value->amount, $value->status, $value->message, $value->transaction_date);
		$i++;
	}

	

	$output = array(

	   "draw" => $draw,

		 "recordsTotal" => $total_records,

		 "recordsFiltered" => $total_records,

		 "data" => $data

	);	

  echo json_encode($output);

  exit();
}







}


