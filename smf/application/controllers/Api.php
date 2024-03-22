<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Api extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
	    $this->common_model->set_timezone();
    }

    public function JSONResponse($result){
		echo exit(json_encode($result));
	}
	
	public function play_store_privacy_policy(){
		$this->load->view('play_store_policy');
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
    
    
    
    public function phone_verification(){
        
        $this->form_validation->set_rules('phone' , 'Provide mobile number' , 'trim|required');
        $this->form_validation->set_rules('access_key', 'Provide access_key', 'trim|required');
        $this->form_validation->set_rules('country_code', 'Provide country_code', 'trim|required');
        
        if($this->form_validation->run())
		{
            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

               $phone = $this->input->post('phone');
               $country_code = $this->input->post('country_code');
             
               $phone_check = $this->common_model->selectbyfield('id' , 'users' ,  array('phone' => $phone , 'country_code' => $country_code))->row();
               
               if(!empty($phone_check)){
			       
                  return $this->JSONResponse(array('status'=>0,'message'=>'Phone number already exist in number field'));
		
		       }else{
		           
		         $username_check = $this->common_model->selectbyfield('id' , 'users' ,  array('username' => $phone))->row();

			     if(!empty($username_check)){
			         
			         return $this->JSONResponse(array('status'=>0,'message'=>'Phone number already exist as username'));
			         
			     }
				  return $this->JSONResponse(array('status'=>1,'message'=>'Phone number not exist'));
		       }
		       
            }else{
                
            return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
        }
        
		}else{
		    
		    $error = validation_errors();
			$error = trim(strip_tags($error));
			return $this->JSONResponse(array('status'=>0,'message'=>$error));
		}
        
    }
    
    
    public function email_verification(){
        
        $this->form_validation->set_rules('email' , 'Provide email' , 'trim|required');
        $this->form_validation->set_rules('access_key', 'Provide access_key', 'trim|required');
        
        if($this->form_validation->run())
		{
            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

               $email = $this->input->post('email');
             
               $email_check = $this->common_model->selectbyfield('id' , 'users' ,  array('email' => $email))->row();

			   if(!empty($email_check)){
			       
                  return $this->JSONResponse(array('status'=>0,'message'=>'Email id already exist'));
		
		       }else{
		           
		           $username_check = $this->common_model->selectbyfield('id' , 'users' ,  array('username' => $email))->row();

			       if(!empty($username_check)){
			         
			         return $this->JSONResponse(array('status'=>0,'message'=>'Email already exist as username'));
			         
			       }
		           
				  return $this->JSONResponse(array('status'=>1,'message'=>'Email id  not exist'));
		       }
		       
            }else{
                
            return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
        }
        
		}else{
		    
		    $error = validation_errors();
			$error = trim(strip_tags($error));
			return $this->JSONResponse(array('status'=>0,'message'=>$error));
		}
        
    }
    
    public function token_verification(){
        
        $this->form_validation->set_rules('token_id' , 'Provide token' , 'trim|required');
        $this->form_validation->set_rules('access_key', 'Provide access_key', 'trim|required');
        
        if($this->form_validation->run())
		{
            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

               $token = $this->input->post('token_id');
             
               $token_check = $this->common_model->selectbyfield('id' , 'users' ,  array('username' => $token))->row();

			   if(!empty($token_check)){
			       
                  return $this->JSONResponse(array('status'=>0,'message'=>'Token already exist'));
		
		       }else{
		           
				  return $this->JSONResponse(array('status'=>1,'message'=>'Token  not exist'));
		       }
		       
            }else{
                
            return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
        }
        
		}else{
		    
		    $error = validation_errors();
			$error = trim(strip_tags($error));
			return $this->JSONResponse(array('status'=>0,'message'=>$error));
		}
        
    }
    
    
    //Delete account
    public function delete_user_account(){
        
        $new_saved_arr = $pre_saved_arr = array();
        $this->form_validation->set_rules('access_key', 'Provide access key', 'required');
        $this->form_validation->set_rules('user_id', 'Provide user id', 'required');
        
        if($this->form_validation->run()){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
                
                $user_id = $this->input->post('user_id');

                $result = $this->db->delete('users' , array('id' => $user_id));
                if($result){

                    return $this->JSONResponse(array('status'=>1,'message'=>'Account deleted successfully'));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'Account not deleted'));
                }

            }else{
                
               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
            }
        }else{
            
            	$error = validation_errors();
				$error = trim(strip_tags($error));
				
				return $this->JSONResponse(array('status'=>0,'message'=>$error));
        }
    }
    


    /* $login_type = 1 for gmail login , 2 for facebook login , 3 for simple login , 4 for apple login*/

    public function app_login_old(){
        
        $this->form_validation->set_rules('username', 'Provide username', 'trim|required');
	    $this->form_validation->set_rules('access_key', 'Provide access_key', 'trim|required');
	    $this->form_validation->set_rules('fcm_id', 'Provide fcm_id ', 'trim|required');
	    $this->form_validation->set_rules('login_type', 'Provide login_type ', 'trim|required');
	    
		if($this->form_validation->run())
		{
            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

            $username = $this->input->post('username');
            $fcm_id = $this->input->post('fcm_id');
            $login_type = $this->input->post('login_type');

            $email_check = $this->common_model->selectbyfield('*' , 'users' ,  array('username' => $username))->row();
            
			if(!empty($email_check)){

                $id = $email_check->id;

                if($login_type == 3){
                
                    $password = $this->input->post('password');
                    
                    if($password == ''){
                        return $this->JSONResponse(array('status'=>0,'message'=>'Password Required !!','data'=>array()));  
                    }

                    $pass = $email_check->password;

                    $pass_check = password_verify($password, $pass);

                    if($pass_check){

                        $result = $this->db->update("users", array('fcm_id' => $fcm_id), array('id' => $id));

                        if($result){

                            $login_data = $this->common_model->selectbyfield('*' , 'users' ,  array('id' => $id))->result();

                            return $this->JSONResponse(array('status'=>1,'message'=>'Successfully Logged IN','data'=>$login_data));
                        
                        }else{

                            return $this->JSONResponse(array('status'=>0,'message'=>'Some problem occured try again !!','data'=>array()));    
                        }

                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'Password wrong !!','data'=>array()));  

                    }

                }elseif($login_type == 4){
                    
                    $token = $this->input->post('token_id');
                    
                    if($token == ''){
                        return $this->JSONResponse(array('status'=>0,'message'=>'Token Required !!','data'=>array()));  
                    }

                    $token_id = $email_check->token_id;

                    if($token_id == $token){

                        $result = $this->db->update("users", array('fcm_id' => $fcm_id), array('id' => $id));

                        if($result){

                            $login_data = $this->common_model->selectbyfield('*' , 'users' ,  array('id' => $id))->result();

                            return $this->JSONResponse(array('status'=>1,'message'=>'Successfully Logged IN','data'=>$login_data));
                        
                        }else{

                            return $this->JSONResponse(array('status'=>0,'message'=>'Some problem occured try again !!','data'=>array()));    
                        }

                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'Token wrong !!','data'=>array()));  

                    }
                    
                    
                }else{

                    $result = $this->db->update("users", array('fcm_id' => $fcm_id), array('id' => $id));

                    if($result){
                        
                        $login_data = $this->common_model->selectbyfield('*' , 'users' ,  array('id' => $id))->result();
                        
                        return $this->JSONResponse(array('status'=>1,'message'=>'Successfully Logged IN','data'=>$login_data));
                        
                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'Some problem occured try again !!','data'=>array()));  

                    }

                }
		
		    }else{
				return $this->JSONResponse(array('status'=>0,'message'=>'User Not Registered','data'=>array()));
		    }
        }else{
            return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!','data'=>array()));
        }
        
		}else{
		    
		    $error = validation_errors();
			$error = trim(strip_tags($error));
			return $this->JSONResponse(array('status'=>0,'message'=>$error));
		}	
	}
	
	
	
	public function app_login(){
        
        $this->form_validation->set_rules('username', 'Provide username', 'trim|required');
	    $this->form_validation->set_rules('access_key', 'Provide access_key', 'trim|required');
	    $this->form_validation->set_rules('fcm_id', 'Provide fcm_id ', 'trim|required');
	    $this->form_validation->set_rules('login_type', 'Provide login_type ', 'trim|required');
	    
		if($this->form_validation->run())
		{
            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

            $username = $this->input->post('username');
            $fcm_id = $this->input->post('fcm_id');
            $login_type = $this->input->post('login_type');

            $email_check = $this->common_model->selectbyfield('*' , 'users' ,  array('username' => $username))->row();
            
			if(!empty($email_check)){

                $id = $email_check->id;

                if($login_type == 3){
                
                    $result = $this->db->update("users", array('fcm_id' => $fcm_id), array('id' => $id));

                    if($result){

                        $login_data = $this->common_model->selectbyfield('*' , 'users' ,  array('id' => $id))->result();

                        return $this->JSONResponse(array('status'=>1,'message'=>'User exist','data'=>$login_data));
                    
                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'Some problem occured try again !!','data'=>array()));    
                    }

                }elseif($login_type == 4){
                    
                    $token = $this->input->post('token_id');
                    
                    if($token == ''){
                        return $this->JSONResponse(array('status'=>0,'message'=>'Token Required !!','data'=>array()));  
                    }

                    $token_id = $email_check->token_id;

                    if($token_id == $token){

                        $result = $this->db->update("users", array('fcm_id' => $fcm_id), array('id' => $id));

                        if($result){

                            $login_data = $this->common_model->selectbyfield('*' , 'users' ,  array('id' => $id))->result();

                            return $this->JSONResponse(array('status'=>1,'message'=>'Successfully Logged IN','data'=>$login_data,'user_exist'=>true));
                        
                        }else{

                            return $this->JSONResponse(array('status'=>0,'message'=>'Some problem occured try again !!','data'=>array()));    
                        }

                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'Token wrong !!','data'=>array()));  

                    }
                    
                    
                }else{

                    $result = $this->db->update("users", array('fcm_id' => $fcm_id), array('id' => $id));

                    if($result){
                        
                        $login_data = $this->common_model->selectbyfield('*' , 'users' ,  array('id' => $id))->result();
                        
                        return $this->JSONResponse(array('status'=>1,'message'=>'Successfully Logged IN','data'=>$login_data,'user_exist'=>true));
                        
                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'Some problem occured try again !!','data'=>array()));  

                    }

                }
		
		    }else{
				return $this->JSONResponse(array('status'=>0,'message'=>'User Not Registered','data'=>array(),'user_exist'=>false));
		    }
        }else{
            return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!','data'=>array()));
        }
        
		}else{
		    
		    $error = validation_errors();
			$error = trim(strip_tags($error));
			return $this->JSONResponse(array('status'=>0,'message'=>$error));
		}	
	}





	public function app_logout(){
	    
		if(!empty($this->input->post('user_id')) && !empty($this->input->post('access_key'))){

		    $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

                $id = $this->input->post('user_id');

		        $result = $this->db->update('users',array('fcm_id' => ''), array('id'=> $id));
			 
			    if(!empty($result)){

			        return $this->JSONResponse(array('status'=>1,'message'=>'Successfully Logged Out')); 

		        }else{

				    return $this->JSONResponse(array('status'=>0,'message'=>'Not Logged Out'));
		        }

            }else{

               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!','data'=>array()));
            }

		}else{

			return $this->JSONResponse(array('status'=>0,'message'=>'User id Required'));
		}	
	}

    /* $signup_type = 1 for gmail sign up , 2 for facebook sign up , 3 for simple sign up , 4 for apple sign up*/

    public function user_register_old(){
        
        //return $this->JSONResponse(array('status'=>1,'message'=>'Test','data'=> $this->post()));
        
        $this->form_validation->set_rules('email', 'Provide email', 'trim|required');
        $this->form_validation->set_rules('username', 'Provide username', 'trim|required');
        $this->form_validation->set_rules('fullname', 'Provide fullname', 'trim|required');
        $this->form_validation->set_rules('phone', 'Provide phone', 'trim|required');
	    $this->form_validation->set_rules('access_key', 'Provide access_key', 'trim|required');
	    $this->form_validation->set_rules('signup_type', 'Provide signup_type', 'trim|required');
	    $this->form_validation->set_rules('country_code', 'Provide Country code', 'trim|required');
	    
	    $signup_type = $this->input->post('signup_type');
	    
	    if($signup_type == 3){
           $this->form_validation->set_rules('password', 'Provide password', 'trim|required');
        }
        
	    if($this->form_validation->run())
		{
            $token_id = $password =  $pass = '';
            
            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
               
               $username = $this->input->post('username');
               $fullname = $this->input->post('fullname');
               $email = $this->input->post('email');
               $phone = $this->input->post('phone');
              
               
               $fcm_id = $this->input->post('fcm_id');
               $country_code = $this->input->post('country_code');

               if(isset($_POST['token_id'])){
                  $token_id = $this->input->post('token_id');
               }
               
			   $con = array('email' => $email);
			   $check = $this->common_model->selectbyfield('id' , 'users' , $con)->row();

			   if(!$check){
			       
			       $con = array('username' => $username);
			       $checks = $this->common_model->selectbyfield('id' , 'users' , $con)->row();
			       
			       if(!$checks){
			           
			           if($this->input->post('password')){
			              $password = $this->input->post('password');
			              $pass = password_hash($password, PASSWORD_BCRYPT);
			           }

	               $data = array('fullname' => $fullname , 'username' =>$username ,'email' => $email , 'phone' => $phone , 'fcm_id' => $fcm_id , 'token_id' => $token_id , 'password' => $pass , 'country_code' =>$country_code , 'status' => 1 , 'signup_type' => $signup_type);
			       
			       $data =  $this->security->xss_clean($data);
                   
                   $result = $this->db->insert('users', $data);

                    if($result){

			           $id = $this->db->insert_id();

                       $registered_data = $this->common_model->selectbyfield('*' , 'users' , array('id' => $id))->result();

    	               return $this->JSONResponse(array('status'=>1,'message'=>'Registered Successfully','data'=>$registered_data));

                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'Some problem occured try again!!','data'=>array())); 
                    }
                    
			       }else{
			           
			           return $this->JSONResponse(array('status'=>0,'message'=>'Username already Registered','data'=>array()));
			           
			       }

                }else{

			        return $this->JSONResponse(array('status'=>0,'message'=>'Email already Registered','data'=>array()));
		        }

            }else{

                return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!','data'=>array()));
            }

	    }else{
	        $error = validation_errors();
			$error = trim(strip_tags($error));
	        return $this->JSONResponse(array('status'=>0,'message'=>$error,'data'=>array()));
	    }
	}
	
	
	public function user_register(){
        
        //return $this->JSONResponse(array('status'=>1,'message'=>'Test','data'=> $this->post()));
        
        $this->form_validation->set_rules('email', 'Provide email', 'trim|required');
        $this->form_validation->set_rules('username', 'Provide username', 'trim|required');
        $this->form_validation->set_rules('fullname', 'Provide fullname', 'trim|required');
        $this->form_validation->set_rules('phone', 'Provide phone', 'trim|required');
	    $this->form_validation->set_rules('access_key', 'Provide access_key', 'trim|required');
	    $this->form_validation->set_rules('signup_type', 'Provide signup_type', 'trim|required');
	    $this->form_validation->set_rules('country_code', 'Provide Country code', 'trim|required');
	    
	    $signup_type = $this->input->post('signup_type');
	    
	    if($signup_type == 3){
           //$this->form_validation->set_rules('password', 'Provide password', 'trim|required');
        }
        
	    if($this->form_validation->run())
		{
            $token_id = $password =  $pass = '';
            
            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
               
               $username = $this->input->post('username');
               $fullname = $this->input->post('fullname');
               $email = $this->input->post('email');
               $phone = $this->input->post('phone');
              
               
               $fcm_id = $this->input->post('fcm_id');
               $country_code = $this->input->post('country_code');

               if(isset($_POST['token_id'])){
                  $token_id = $this->input->post('token_id');
               }
               
			   $con = array('email' => $email);
			   $check = $this->common_model->selectbyfield('id' , 'users' , $con)->row();

			   if(!$check){
			       
			       $con = array('username' => $username);
			       $checks = $this->common_model->selectbyfield('id' , 'users' , $con)->row();
			       
			       if(!$checks){
			           $pass = '';
			         //  if($this->input->post('password')){
			         //     $password = $this->input->post('password');
			         //     $pass = password_hash($password, PASSWORD_BCRYPT);
			         //  }

	               $data = array('fullname' => $fullname , 'username' =>$username ,'email' => $email , 'phone' => $phone , 'fcm_id' => $fcm_id , 'token_id' => $token_id , 'password' => $pass , 'country_code' =>$country_code , 'status' => 1 , 'signup_type' => $signup_type);
			       
			       $data =  $this->security->xss_clean($data);
                   
                   $result = $this->db->insert('users', $data);

                    if($result){

			           $id = $this->db->insert_id();

                       $registered_data = $this->common_model->selectbyfield('*' , 'users' , array('id' => $id))->result();

    	               return $this->JSONResponse(array('status'=>1,'message'=>'Registered Successfully','data'=>$registered_data));

                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'Some problem occured try again!!','data'=>array())); 
                    }
                    
			       }else{
			           
			           return $this->JSONResponse(array('status'=>0,'message'=>'Username already Registered','data'=>array()));
			           
			       }

                }else{

			        return $this->JSONResponse(array('status'=>0,'message'=>'Email already Registered','data'=>array()));
		        }

            }else{

                return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!','data'=>array()));
            }

	    }else{
	        $error = validation_errors();
			$error = trim(strip_tags($error));
	        return $this->JSONResponse(array('status'=>0,'message'=>$error,'data'=>array()));
	    }
	}


    public function all_events(){
        $con = array();
        if(!empty($this->input->post('access_key'))){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

                if(!empty($this->input->post('event_id'))){

                    $event_id = $this->input->post('event_id');
                    $event_data = $this->common_model->selectbyfield('*' , 'events' , array('id' => $event_id))->result();
                    
                }elseif(!empty($this->input->post('date'))){
                    
                   $currentDateTime = date("Y-m-d H:i:s");
                   $currentDate = date("Y-m-d");
                    
                   $event_date = $this->input->post('date');
                   $nextDate = date('Y-m-d',strtotime($event_date . "+1 days"));
                   
                   if($event_date == $currentDate){
                       $con = array('concat(STR_TO_DATE(events.event_date ,"%Y-%m-%d") ," ",STR_TO_DATE(events.event_time, "%l:%i %p")) >=' => $currentDate, 'str_to_date(events.event_date ,"%Y-%m-%d") <' => $nextDate);
                   }else{
                       $con = array('str_to_date(events.event_date ,"%Y-%m-%d") >=' => $event_date, 'str_to_date(events.event_date ,"%Y-%m-%d") <' => $nextDate); 
                   }
                   
                   $event_data = $this->common_model->selectbyfield('*' , 'events' , $con)->result();
                  // print_r($this->db->last_query());die;
                   
                }else{
                    
                   $event_data = $this->common_model->selectbyfield('*' , 'events')->result(); 
                }
                
                
                if($event_data){
                    if(!empty($event_data)){
                        foreach($event_data as $row){
                            $row->event_saved=false;
                            $row->rsvp=false;
                        }
                    }
                    
                    if(!empty($this->input->post('user_id'))){
                        $user_id = $this->input->post('user_id');
                        $event_data = $this->getFavoriteEvent($event_data , $user_id);
                    }

                    return $this->JSONResponse(array('status'=>1,'message'=>'Event data','data'=>$event_data));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'No event was found','data'=>array()));
                }

            }else{

               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!','data'=>array()));
            }
        }
    }


    public function all_blogs(){

        if(!empty($this->input->post('access_key'))){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){

                if(!empty($this->input->post('blog_id'))){

                    $blog_id = $this->input->post('blog_id');

                    $blog_data = $this->common_model->selectbyfield('blogs.* , DATE_FORMAT(blogs.celebrated_date, "%M %d %Y") as celebrated_date' , 'blogs' , array('id' => $blog_id))->result();
                
                }else{

                    $blog_data = $this->common_model->selectbyfield('blogs.* , DATE_FORMAT(blogs.celebrated_date, "%M %d %Y") as celebrated_date'  , 'blogs')->result();
                }

                
                if($blog_data){

                    return $this->JSONResponse(array('status'=>1,'message'=>'News','data'=>$blog_data));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'No News was found','data'=>array()));
                }

            }else{

               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!','data'=>array()));
            }
        }
    }
    
    
    public function save_event(){
        
        $new_saved_arr = $pre_saved_arr = array();
        $this->form_validation->set_rules('access_key', 'Provide access key', 'required');
        $this->form_validation->set_rules('event_id', 'Provide event id', 'required');
        $this->form_validation->set_rules('user_id', 'Provide user id', 'required');
        
        if($this->form_validation->run()){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
                
                $user_id = $this->input->post('user_id');
                
                $check_user = $this->common_model->selectbyfield('id' , 'users' , array('id' => $user_id))->row();

                if($check_user){

                    $event_id = $this->input->post('event_id');

                    $check_event = $this->common_model->selectbyfield('*' , 'favorite' , array('user_id' => $user_id))->row();
                    
                    if(empty($check_event)){
                        
                        $data = array('user_id' => $user_id , 'event_id' => $event_id);
                        
                        $data =  $this->security->xss_clean($data);
                        
                        $result = $this->db->insert('favorite', $data );
                        
                    }else{
                        
                        $pre_saved_arr = explode(',' , $check_event->event_id);
                        
                        if (in_array($event_id, $pre_saved_arr)){
                            
                            return $this->JSONResponse(array('status'=>0,'message'=>'Event allready saved !!'));
                            
                        }else{
                            $new_saved_arr = explode(',' , $event_id);
                            $new_saved_arr = array_merge($new_saved_arr , $pre_saved_arr);
                            
                            $save_event_data = implode(',' , $new_saved_arr);
                            
                            $save_event_data = ltrim($save_event_data , ',');
                            $save_event_data = rtrim($save_event_data , ',');
                            
                            $result = $this->db->update('favorite', array('user_id' => $user_id , 'event_id' => $save_event_data) , array('user_id' => $user_id));
                             
                         }
                    }
                
                }else{

                     return $this->JSONResponse(array('status'=>0,'message'=>'User not exist'));
                }
                
                if($result){

                    return $this->JSONResponse(array('status'=>1,'message'=>'Event saved'));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'Event not saved'));
                }

            }else{
                
               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
            }
        }else{
            
            	$error = validation_errors();
				$error = trim(strip_tags($error));
				
				return $this->JSONResponse(array('status'=>0,'message'=>$error));
        }
    }
    
    public function unsave_event(){
        
        $new_saved_arr = $pre_saved_arr = array();
        $this->form_validation->set_rules('access_key', 'Provide access key', 'required');
        $this->form_validation->set_rules('event_id', 'Provide event id', 'required');
        $this->form_validation->set_rules('user_id', 'Provide user id', 'required');
        
        if($this->form_validation->run()){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
                
                $user_id = $this->input->post('user_id');
                
                $check_user = $this->common_model->selectbyfield('id' , 'users' , array('id' => $user_id))->row();

                if($check_user){

                    $event_id = $this->input->post('event_id');

                    $check_event = $this->common_model->selectbyfield('*' , 'favorite' , array('user_id' => $user_id))->row();
                    
                    if(empty($check_event)){
                        
                        return $this->JSONResponse(array('status'=>0,'message'=>'Event not exist'));
                        
                    }else{
                        
                        $pre_saved_arr = explode(',' , $check_event->event_id);
                        
                        if (in_array($event_id, $pre_saved_arr)){
                            
                            $new_saved_arr = explode(',' , $event_id);
                            $new_saved_arr = array_diff($pre_saved_arr,$new_saved_arr);
                            $save_event_data = implode(',' , $new_saved_arr);
                            
                            $save_event_data = ltrim($save_event_data , ',');
                            $save_event_data = rtrim($save_event_data , ',');
                            
                            $result = $this->db->update('favorite', array('user_id' => $user_id , 'event_id' => $save_event_data) , array('user_id' => $user_id));
                            
                            $check_users_events = $this->common_model->selectbyfield('*' , 'favorite' , array('user_id' => $user_id))->row();
                            
                            if(empty($check_users_events->event_id)){
                                
                                $this->db->delete('favorite' , array('user_id' => $user_id));
                            }
                             
                        }else{
                              return $this->JSONResponse(array('status'=>0,'message'=>'Event not exist'));
                         }
                    }
                
                }else{

                     return $this->JSONResponse(array('status'=>0,'message'=>'User not exist'));
                }
                
                if($result){

                    return $this->JSONResponse(array('status'=>1,'message'=>'Event unsaved'));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'Event not unsaved'));
                }

            }else{
                
               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
            }
        }else{
            
            	$error = validation_errors();
				$error = trim(strip_tags($error));
				
				return $this->JSONResponse(array('status'=>0,'message'=>$error));
        }
    }
    
    public function get_saved_event(){
        $result = array();
        $this->form_validation->set_rules('access_key', 'Provide access key', 'required');
        $this->form_validation->set_rules('user_id', 'Provide user id', 'required');
        
        if($this->form_validation->run()){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
                
                $user_id = $this->input->post('user_id');
                
                $check_user = $this->common_model->selectbyfield('id' , 'users' , array('id' => $user_id))->row();

                if($check_user){
                    
                    $check_event = $this->common_model->selectbyfield('*' , 'favorite' , array('user_id' => $user_id))->row();  
                    
                    if(!empty($check_event)){
                        
                        $pre_saved_arr = explode(',' , $check_event->event_id);
                        
                        $result = $this->common_model->selectbyfield('*' , 'events' , $where = array() ,$sort='DESC',$sort_by='id' , $pre_saved_arr)->result();  
                        
                    }else{
                        
                       return $this->JSONResponse(array('status'=>0,'message'=>'No Event was found' , 'data' => array()));  
                    }
                
                }else{

                     return $this->JSONResponse(array('status'=>0,'message'=>'User not exist', 'data' => array()));
                }
                
                if($result){
                    
                    if(!empty($this->input->post('user_id'))){
                        $user_id = $this->input->post('user_id');
                        $result = $this->getFavoriteEvent($result , $user_id);
                    }

                    return $this->JSONResponse(array('status'=>1,'message'=>'Events', 'data' => $result));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'No Event was found', 'data' => array()));
                }

            }else{
                
               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!', 'data' => array()));
            }
        }else{
            
            	$error = validation_errors();
				$error = trim(strip_tags($error));
				return $this->JSONResponse(array('status'=>0,'message'=>$error));
        }
    }
    
    


    
    public function settings(){

        if(!empty($this->input->post('access_key'))){

            $access_key = $this->input->post('access_key');
            $check_key = $this->check_access($access_key);

            if($check_key){

                if(!empty($this->input->post('get_payment_methods'))){

                   $payment_data = $this->common_model->selectbyfield('value' , 'settings' , array('variable' => 'payment_methods'))->row();

                    if(!empty($payment_data)){
                        
                       $payment_data = json_decode($payment_data->value);

                       return $this->JSONResponse(array('status'=>1,'message'=>'','payment_methods'=>$payment_data));
                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }

                }

                if(!empty($this->input->post('get_privacy'))){
          
                    $privecy_data = $this->common_model->selectbyfield('value' , 'settings' , array('variable' => 'privacy_policy'))->row();
        
                    if(!empty($privecy_data)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','privacy'=>$privecy_data->value));
                    }else{

                     return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_terms'))){

                    $terms_data = $this->common_model->selectbyfield('value' , 'settings' , array('variable' => 'terms_conditions'))->row();  
          
                    if(!empty($terms_data)){

                        return $this->JSONResponse(array('status'=>1,'message'=>'','terms'=>$terms_data->value));
                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_logo'))){

                    $logo = $this->common_model->selectbyfield('value' , 'settings' , array('variable' => 'logo'))->row();  

                    if(!empty($logo)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','logo'=>base_url().$logo->value));
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_contact'))){

                    $contact_us = $this->common_model->selectbyfield('value' , 'settings' , array('variable' => 'contact_us'))->row();  

                    if(!empty($contact_us)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','contact'=>$contact_us->value));
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_about_aashram'))){

                   $aashram_data = $this->common_model->selectbyfield('*' , 'about_aashram')->row();
                 
                    if(!empty($aashram_data)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','about_aashram'=>$aashram_data));
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                
                if(!empty($this->input->post('get_timezone'))){

                    $timezone_data = $this->common_model->selectbyfield('value' , 'settings' , array('variable' => 'system_timezone'))->row();
                    
                    $timezone_data = json_decode($timezone_data->value,1);
                    
                    $data = array('system_timezone_gmt' => $timezone_data['system_timezone_gmt'] , 'system_timezone' => $timezone_data['system_timezone']);
                    
                    if(!empty($data)){

                        return $this->JSONResponse(array('status'=>1,'message'=>'','settings'=>$data));
                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_fcm_key'))){
         
                    $fcm_data = $this->common_model->selectbyfield('value' , 'settings' , array('variable' => 'fcm_server_key'))->row();
                    
                    if(!empty($fcm_data)){

                        return $this->JSONResponse(array('status'=>1,'message'=>'','fcm'=>$fcm_data->value));
                    }else{

                        return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_about_swamiji'))){
       
                    $swamiji_data = $this->common_model->selectbyfield('*' , 'about_swamiji')->row();
           
                    if(!empty($swamiji_data)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','about_swamiji'=>$swamiji_data));          
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_currency'))){
       
                    $currency_data = $this->common_model->selectbyfield('value' , 'settings' , array('variable' => 'currency'))->row();
           
                    if(!empty($currency_data)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','currency'=>$currency_data->value));          
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_donation_category'))){
       
                    $donation_category = $this->common_model->selectbyfield('*' , 'donation_type')->result();
           
                    if(!empty($donation_category)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','donation_category'=>$donation_category));          
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_blessings'))){
       
                    $blessings = $this->common_model->selectbyfield('*' , 'blessings')->row();
           
                    if(!empty($blessings)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','blessings'=>$blessings));          
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_banner'))){
       
                    $banners = $this->common_model->selectbyfield('*' , 'banners')->result();
           
                    if(!empty($banners)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','banners'=>$banners));          
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

                if(!empty($this->input->post('get_gallery'))){
       
                    $gallery = $this->common_model->get_gallery()->result();
           
                    if(!empty($gallery)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','gallery'=>$gallery));          
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }
                
                if(!empty($this->input->post('get_country_code'))){
       
                    $country_code = $this->common_model->selectbyfield('*' , 'country_code')->result();
           
                    if(!empty($country_code)){

                       return $this->JSONResponse(array('status'=>1,'message'=>'','data'=>$country_code));          
                    }else{

                       return $this->JSONResponse(array('status'=>0,'message'=>'No Records Found','data'=>array()));
                    }
                }

            }else{

                return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!','data'=>array()));
            }
	    }else{
            return $this->JSONResponse(array('status'=>0,'message'=>'Access key required !!','data'=>array()));
        }
    }

   
    
    public function add_rsvp(){
        
        $new_saved_arr = $pre_saved_arr = array();
        $this->form_validation->set_rules('access_key', 'Provide access key', 'required');
        $this->form_validation->set_rules('event_id', 'Provide event id', 'required');
        $this->form_validation->set_rules('user_id', 'Provide user id', 'required');
        
        if($this->form_validation->run()){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
                
                $user_id = $this->input->post('user_id');
                
                $check_user = $this->common_model->selectbyfield('id' , 'users' , array('id' => $user_id))->row();

                if($check_user){

                    $event_id = $this->input->post('event_id');
                   
                    $event_attendence = $this->common_model->selectbyfield('attendence' , 'events' , array('id' => $event_id))->row();
                    
                    $count = $event_attendence->attendence;
                    
                    $check_event = $this->common_model->selectbyfield('*' , 'tbl_rsvp' , array('user_id' => $user_id))->row();
                    
                    if(empty($check_event)){
                        
                        $data = array('user_id' => $user_id , 'event_id' => $event_id) ;
                        
                        $data =  $this->security->xss_clean($data);
                        
                        $result = $this->db->insert('tbl_rsvp', $data);
                        
                        $attendence = $count + 1;
                        
                        $result1 = $this->db->update('events', array('attendence' => $attendence) , array('id' => $event_id));
                        
                    }else{
                        
                        $pre_saved_arr = explode(',' , $check_event->event_id);
                        
                        if (in_array($event_id, $pre_saved_arr)){
                            
                            return $this->JSONResponse(array('status'=>0,'message'=>'Allready attends !!'));
                            
                        }else{
                            
                            $new_saved_arr = explode(',' , $event_id);
                            $new_saved_arr = array_merge($new_saved_arr , $pre_saved_arr);
                            
                            $save_event_data = implode(',' , $new_saved_arr);
                            
                            $save_event_data = ltrim($save_event_data , ',');
                            $save_event_data = rtrim($save_event_data , ',');
                            
                            $attendence = $count + 1;
                            
                            $result = $this->db->update('tbl_rsvp', array('event_id' => $save_event_data) , array('user_id' => $user_id));
                            $result1 = $this->db->update('events', array('attendence' => $attendence) , array('id' => $event_id));
                             
                         }
                    }
                
                }else{

                     return $this->JSONResponse(array('status'=>0,'message'=>'User not exist'));
                }
                
                if($result && $result1 ){

                    return $this->JSONResponse(array('status'=>1,'message'=>'Event Added'));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'Event not Added'));
                }

            }else{
                
               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
            }
            
        }else{
            
            	$error = validation_errors();
				$error = trim(strip_tags($error));
				
				return $this->JSONResponse(array('status'=>0,'message'=>$error));
        }
    }


    public function delete_rsvp(){
        
        $new_saved_arr = $pre_saved_arr = array();
        $this->form_validation->set_rules('access_key', 'Provide access key', 'required');
        $this->form_validation->set_rules('event_id', 'Provide event id', 'required');
        $this->form_validation->set_rules('user_id', 'Provide user id', 'required');
        
        if($this->form_validation->run()){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
                
                $user_id = $this->input->post('user_id');
                
                $check_user = $this->common_model->selectbyfield('id' , 'users' , array('id' => $user_id))->row();

                if($check_user){

                    $event_id = $this->input->post('event_id');
                    
                    $event_attendence = $this->common_model->selectbyfield('attendence' , 'events' , array('id' => $event_id))->row();
                    
                    $count = $event_attendence->attendence;

                    $check_event = $this->common_model->selectbyfield('*' , 'tbl_rsvp' , array('user_id' => $user_id))->row();
                    
                    if(empty($check_event)){
                        
                        return $this->JSONResponse(array('status'=>0,'message'=>'Event not exist'));
                        
                    }else{
                        
                        $pre_saved_arr = explode(',' , $check_event->event_id);
                        
                        if (in_array($event_id, $pre_saved_arr)){
                            
                            $new_saved_arr = explode(',' , $event_id);
                            $new_saved_arr = array_diff($pre_saved_arr,$new_saved_arr);
                            $save_event_data = implode(',' , $new_saved_arr);
                            
                            $save_event_data = ltrim($save_event_data , ',');
                            $save_event_data = rtrim($save_event_data , ',');
                            
                            $result = $this->db->update('tbl_rsvp', array('event_id' => $save_event_data) , array('user_id' => $user_id));
                            
                            $check_users_events = $this->common_model->selectbyfield('*' , 'tbl_rsvp' , array('user_id' => $user_id))->row();
                            
                            if(empty($check_users_events->event_id)){
                                
                                $this->db->delete('tbl_rsvp' , array('user_id' => $user_id));
                            }
                            
                            if($count > 0){
                                
                                $attendence = $count - 1;
                                
                            }else{
                                
                                $attendence = 0;
                            }
                            
                            $result1 = $this->db->update('events', array('attendence' => $attendence) , array('id' => $event_id));
                             
                        }else{
                              return $this->JSONResponse(array('status'=>0,'message'=>'Event not exist'));
                        }
                    }
                
                }else{

                     return $this->JSONResponse(array('status'=>0,'message'=>'User not exist'));
                }
                
                if($result && $result1){

                    return $this->JSONResponse(array('status'=>1,'message'=>'Event Addendence removed'));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'Event addendence not removed'));
                }

            }else{
                
               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
            }
        }else{
            
            	$error = validation_errors();
				$error = trim(strip_tags($error));
				
				return $this->JSONResponse(array('status'=>0,'message'=>$error));
        }
    }
    
    
  public function add_transaction(){
      
        
        $this->form_validation->set_rules('access_key', 'Provide access key', 'required');
        $this->form_validation->set_rules('txn_id', 'Provide txn_id', 'required');
        $this->form_validation->set_rules('user_id', 'Provide user id', 'required');
        $this->form_validation->set_rules('status', 'Provide status', 'required');
        $this->form_validation->set_rules('amount', 'Provide amount', 'required');
        $this->form_validation->set_rules('transaction_date', 'Provide transaction_date', 'required');
        $this->form_validation->set_rules('category', 'Provide category', 'required');
        
        if($this->form_validation->run()){

            $access_key = $this->input->post('access_key');

            $check_key = $this->check_access($access_key);

            if($check_key){
                
                $user_id = $this->input->post('user_id');
                
                $check_user = $this->common_model->selectbyfield('id' , 'users' , array('id' => $user_id))->row();

                if($check_user){
                    
                    $insert_data = array(
                                       'txn_id' => $this->input->post('txn_id'),
                                       'status' => $this->input->post('status'),
                                       'amount' => $this->input->post('amount'),
                                       'transaction_date' => $this->input->post('transaction_date'),
                                       'category' => $this->input->post('category'),
                                    );

                    $insert_data =  $this->security->xss_clean($insert_data);
                    
                    $result = $this->db->insert('transactions', $insert_data);
                        
                }else{

                     return $this->JSONResponse(array('status'=>0,'message'=>'User not exist'));
                }
                
                if($result){

                    return $this->JSONResponse(array('status'=>1,'message'=>'Event Added'));
                
                }else{

                    return $this->JSONResponse(array('status'=>0,'message'=>'Event not Added'));
                }

            }else{
                
               return $this->JSONResponse(array('status'=>0,'message'=>'Access denied !!'));
            }
            
        }else{
            
            	$error = validation_errors();
				$error = trim(strip_tags($error));
				
				return $this->JSONResponse(array('status'=>0,'message'=>$error));
        }
    }
  
    private function getFavoriteEvent($event_data , $user_id){
 
        $saved_events = $this->common_model->selectbyfield('*' , 'favorite' , array('user_id' => $user_id))->row();
                        
        if(!empty($saved_events)){
            $saved_arr = explode(',' , $saved_events->event_id);
        }
                        
        $rsvp_events = $this->common_model->selectbyfield('*' , 'tbl_rsvp' , array('user_id' => $user_id))->row();
                        
        if(!empty($rsvp_events)){
            $rsvp_arr = explode(',' , $rsvp_events->event_id);
        }
                        
        $i = 0;
                        
        foreach($event_data as $key => $value){
                            
            if (!empty($saved_events) && in_array($value->id, $saved_arr)){
                               
                $event_data[$i]->event_saved = true;
                               
            }else{
                               
                $event_data[$i]->event_saved = false;
                               
            }
            
           if (!empty($rsvp_events) &&  in_array($value->id, $rsvp_arr)){
                               
                $event_data[$i]->rsvp = true;
                               
            }else{
                               
                $event_data[$i]->rsvp = false;
                               
            }
            $i++;   
        }
        return $event_data;
    }
    
    public function test_alert(){
        
      $data['view']='test_alert';
	  $data['page']='test_alert';
      $this->load->view('test_alert'); 
      
    }
    
    public function web_view(){
        return $this->JSONResponse(array('status'=>1,'message'=>'https://shankaranandamissionfoundation.com/test_alert'));
    }
    
    

}