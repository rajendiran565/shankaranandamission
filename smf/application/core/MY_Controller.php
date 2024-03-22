<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{


	public function get_permissions(){

		$session = $this->session->userdata('userdata');
		$id=$session['user_id'];

        $con = array('id'=> $id);

        $res = $this->common_model->selectbyfield('permissions' , 'admin' , $con)->row();
    

        if(!empty($res) && isset($res->permissions)){
            return json_decode($res->permissions,true);
        }else{
            return 0;
        }
    }

    public function get_role($id){

        $con = array('id'=> $id);
        $res = $this->common_model->selectbyfield('role','admin' , $con)->row();
        if(!empty($res)){
            return json_decode($res->role,true);
        }else{
            return false;
        }
    }

    public function template($data)
	{
		$session = $this->session->userdata('userdata');
		if(empty($session)){
			redirect(base_url(''), 'refresh');	
			exit;
		}

        $con = array('id'=> $session['user_id'] , 'web_login' => $session['secretkey']);

		$login = $this->common_model->count_rows('admin' , 'id' , $con);
        

		if($login==0){
			echo "<script>alert('This login is accessed in Another place. Please Re-login');</script>";
			$this->session->sess_destroy();
			redirect(base_url(''), 'refresh');	
			exit;
		}

		$data['permissions']=$this->get_permissions();
		$data['config'] = $this->common_model->get_configurations();
		
		$this->common_model->set_timezone();

		$data['currency'] = $this->common_model->get_settings('currency');
		$data['logo'] = $this->common_model->get_settings('logo');
		$data['role'] = $this->get_role($session['user_id']);
		
		$this->db->query("SET NAMES 'utf8'");

		$this->load->view('layout',$data);
	}

    public function output($Return=array()){

		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));

	}




  function send_email($to,$subject,$message){
		
	$settings = $this->get_configurations();

    // SMTP configuration
    $config=array('protocol'=>'smtp',
				'smtp_host'=>$settings['smtp_host'],
				'smtp_port'=>$settings['smtp_port'],
				'smtp_user'=>$settings['from_mail'],
				'smtp_pass'=>$settings['mail_password'],
                'smtp_crypto'=>$settings['smtp_secure'],
				'smtp_timeout'=>'60',
				'charset'=>'utf-8',
				'newline'=>'\r\n',
				'mailtype'=>'html',
				'validation'=>TRUE,
			);

	$this->email->initialize($config); 
	$this->email->set_newline("\r\n");  
	$this->email->from($settings['from_mail'],$settings['app_name']);
	$this->email->to($to);
	$this->email->subject($subject);
	$this->email->message($message);
		
    // Send email
    if(!$this->email->send()){
        //print_r($this->email->print_debugger());
		return 0;
    }else{
        return 1;
    }
  }


  function sendPushNotification($registration_ids,$message) {
        
	$fields = array('registration_ids' => $registration_ids,'data' => $message,);

    // firebase server url to send the curl request
    $url = 'https://fcm.googleapis.com/fcm/send';

    $con = array('variable'=> 'fcm_server_key');
    $res = $this->common_model->selectbyfield('value','settings' , $con)->row();
        
    // define("FIREBASE_API_KEY",$res->value);
        
    //building headers for the request
    $headers = array('Authorization: key=' . $res->value,'Content-Type: application/json');

   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);

    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
  }


	public function getPush($title, $message, $image=null,$type,$id=null) {
        $res = array();
        $res['data']['title'] = $title;
        $res['data']['message'] = $message;
        $res['data']['image'] = $image;
        $res['data']['type'] = $type;
        $res['data']['id'] = $id;
        return $res;
    }

    public function send_push($title, $message, $type , $event_id  , $image = null){

        if(!empty($title) && !empty($message) && !empty($type) && !empty($event_id)){

            $mPushNotification = $this->getPush($title,$message,$image,$type,$event_id);
            $res = $this->common_model->selectbyfield('fcm_id','users')->result();

            $token = array(); 
            if($res){
                foreach($res as $row){
                    array_push($token, $row->fcm_id);
                }
                //sending push notification and displaying result 
                $this->sendPushNotification($token, $mPushNotification);
                return 1;
            }else{
                return 2;
            } 
        }else{
           return 3;
        }
    }	
}
	
