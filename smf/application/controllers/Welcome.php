<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends MY_Controller {


	public function index()
	{
		$session = $this->session->userdata('userdata');
		if(empty($session)){ 
			$this->load->view('index');
		}else{
			redirect('dashboard');
		}
	}


	public function dashboard()
	{
		$data['view']='dashboard';
		$data['page']='Dashboard';
		$data['users']=$this->common_model->get_count('users');
		$data['events']=$this->common_model->count_rows('events' , 'id' , array('status' => 1));
		$data['blogs']=$this->common_model->count_rows('blogs' , 'id' , array('status' => 1));
		$this->template($data);
	}



	public function login()
	{
	    
	    
		$Return = array('result'=>'', 'error'=>'');

		if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){

		    if($this->input->post('username')){
		        
		        //echo password_hash('swami@!1234', PASSWORD_DEFAULT);die;
	
		        $secretKey = '6LfHu5kpAAAAADQftnkvQfI_elkHQffl3elSBgl0'; 

		        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 

		        $responseData = json_decode($verifyResponse); 
			
		        if($responseData->success){ 

		           $username = $this->input->post('username');
		           $password = $this->input->post('password');
		
		           $currentTime = time() + 25200;
		           $expired = 3600;
		
		            if(!empty($username) && !empty($password)){

			            $field = "*";
			            $table = 'admin';
			            $where  = array('username' => $username);
		
			            $result = $this->common_model->selectbyfield($field , $table , $where)->row();

			            $res =  $result;

                        $num = count(array($result));

			            if($num == 1){

				            $pass = $res->password;

				            $pass_check = password_verify($password, $pass);

				            if($pass_check){

					           $secretkey=rand();

					            $session_data = array(
						             'user_id' => $res->id,
						              'role' => $res->role,
						              'secretkey' => $secretkey,
						              'username' => $username,
						              'timeout' => ($currentTime + $expired)
					           );

					            $this->session->set_userdata('userdata', $session_data);

					            $this->db->update('admin' , array('web_login' => $secretkey) , array('id' => $res->id));

					            $Return['result']="Login Success";

				            }else{
					            $Return['error']= "Password Incorrect!";
				            }
                        }else{
				           $Return['error']= "Username Incorrect!";
			            }
		            }else{
			           $Return['error']= "Enter Username or Password!";
		            }
		        }else{
			       $Return['error']= "captcha not Verified !";
		        }
	        }else{
		       $Return['error']= "Enter Username and Password!";
	        }
        }else{
	       $Return['error']= "Check  Recaptcha checkbox !";
        }
		
		$this->output($Return);
    }


	public function logout() {
		$session = $this->session->userdata('userdata');
		$sess_array = array('username' => '');
		$this->session->sess_destroy();
		$Return['result'] = 'Successfully Logout.';
		redirect('', 'refresh');
	}

	public function category(){
		$data['view']='category';
		$data['page']='Donation Category';
		$data['table_link'] = 'welcome/category_list';
		$this->template($data);
	}

	public function category_list(){

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$constant = $this->common_model->selectbyfield('*','donation_type');
		
		$data = array();
		$i=1;

        foreach($constant->result() as $r) {
			
			$operate = "<a class='btn-xs btn-info  edit-category' data-id='".$r->id."' data-name='".$r->name."' data-toggle='modal' title='Edit' data-target='#editCategoryModal'><i class='fa fa-edit'></i></a> ";
			$operate .= "<a class='btn-xs btn-danger delete-category' data-id='".$r->id."' title='Delete'><i class='fa fa-trash-o'></i></a>";
			$data[] = array($i,$r->name ,$operate);
			$i++;
		}

		$output = array("draw" => $draw,
                        "recordsTotal" => $constant->num_rows(),
			            "recordsFiltered" => $constant->num_rows(),
                        "data" => $data
					);

	  echo json_encode($output);

	  exit();

	}

	public function add_category(){

		$name = $this->security->xss_clean($_POST['name']);

		$result = $this->db->insert('donation_type' , array('name' => $name , 'status' => 1));

		if($result){
			echo '<label class="alert alert-success">Category Added Successfully!</label>';
		}else{
			echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
		}
	}	

	public function update_category(){

		$id = $this->security->xss_clean($_POST['category_id']);
		$name = $this->security->xss_clean($_POST['category_name']);

		$result = $this->db->update('donation_type' , array('name' => $name) , array('id' => $id));
	
		if($result){
			echo "<label class='alert alert-success'>Category Updated Successfully.</label>";
		}else{
			echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";

		}
	}


	public function delete_category(){

		$id = $this->security->xss_clean($_POST['category_id']);
		$result = $this->db->delete('donation_type', array('id' => $id));
        
		if($result){
			echo 0;
		}else{
			echo 1;
		}
	}

	public function users(){
		$data['view']='users';
		$data['page']='Users';
		$data['table_link']='welcome/user_list';
		$this->template($data);
	}

	public function user_list(){

	  $draw = intval($this->input->get('draw'));
	  $start  = intval($this->input->get('start'));
	  $length = intval($this->input->get('lenght'));

	  $users = $this->common_model->selectbyfield('*' ,'users');

	  $data =  array();
	  $i=1;

	  foreach($users->result() as $r){
		$data[] = array($i ,$r->email , $r->created_at);
		$i++;
	  }

	  $output = array("draw" => $draw,"recordsTotal" => $users->num_rows(),"recordsFiltered" => $users->num_rows(),"data" => $data);
      echo json_encode($output);
      exit();
	}



	public function blogs(){

		$message = '';
		$result = '';
		$data['view']='blogs';
		$data['page']='Blogs';
		$data['table_link']='welcome/blog_list';

		if($this->input->post('blog_id')){

			if($this->input->post('title') && $this->input->post('description')){
			    
			   $celebrated_dates = $this->input->post('celebrated_date');
			   $date=date_create($celebrated_dates);
               $celebrated_date = date_format($date,"Y-m-d");

			$id = $this->input->post('blog_id');
			$title = $this->input->post('title');
		
			$description = $this->input->post('description');

			$update_data = array('title' => $title , 'description' => $description , 'celebrated_date'=>$celebrated_date , 'status' => 1);

			if(is_numeric($id)){

				$old_img = $this->common_model->selectbyfield('image' , 'blogs' , array('id' => $id))->row();
				$old_image = $old_img->image ;

			    if(isset($_FILES['image']['name']) && $_FILES['image']['size'] > 0 ){
				    $path = 'upload/blog_images/';
				    $upload['allowed_types'] = "jpg|jpeg|png|gif";
				    $upload['upload_path'] = $path;
			
				    $image_name = 'blog'.date('dmYhis');
				    $upload['file_name'] = $image_name;
				
				    $this->load->library('upload');
                    $this->upload->initialize($upload);

                    if (!$this->upload->do_upload('image')) {
					   $this->session->set_flashdata('message', "<div class='alert alert-danger'>Image could not be uploaded</div>");
					   redirect('blogs');
                    }else{ 
				       $upload_data = $this->upload->data();
                       $filename = $path.$upload_data['file_name']; 
                       $update_data = array_merge($update_data , array('image' => $filename));
                        
                        if(file_exists($old_image)){
							unlink($old_image);
					    }  
				    }
			    }
		    }elseif(!is_numeric($id) && $id == 'add'){

				if(isset($_FILES['image']['name']) && $_FILES['image']['size'] > 0 ){
					$path = 'upload/blog_images/';
					$upload['allowed_types'] = "jpg|jpeg|png|gif";
					$upload['upload_path'] = $path;
			 
					$image_name = 'blog'.date('dmYhis');
					$upload['file_name'] = $image_name;
				 
					$this->load->library('upload');
					$this->upload->initialize($upload);
 
					if (!$this->upload->do_upload('image')) {
						$this->session->set_flashdata('message', "<div class='alert alert-danger'>Image could not be uploaded</div>");
					    redirect('blogs');
					}else{ 
						$upload_data = $this->upload->data();
						$filename = $path.$upload_data['file_name']; 
						$update_data = array_merge($update_data , array('image' => $filename));
					}
				}else{
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>Blog not Updated , Image Required</div>");
					redirect('blogs');
				}
			}

			$update_data = $this->security->xss_clean($update_data);

			if(is_numeric($id)){
              $result = $this->db->update('blogs' , $update_data , array('id' => $id));
			}else if(!is_numeric($id) && $id == 'add'){
			  $result = $this->db->insert('blogs' , $update_data);
			}

			if($result){
				$message = "<div class='alert alert-success'> Blog Updated successfully!</div>";
			}else{
				$message = "<div class='alert alert-danger'> Blog not Updated try again !!</div>";
			}	
	    }else{
			$message = "<div class='alert alert-danger'> Blog not Updated , Tilte and description is required!!</div>";
	    }
		$data['success'] = $message;
	}
		
		$this->template($data);
	}


	public function blog_list(){

	$draw = intval($this->input->get('draw'));
	$length = intval($this->input->get('length'));
	$start = intval($this->input->get('start'));

	$blogs = $this->common_model->selectbyfield('*' , 'blogs');

	$data = array();

	$i = 1;

	foreach($blogs->result() as $r){

		$operate = "<a href ='".base_url('update_blogs/'.$r->id)."' class='btn-xs btn-info' title='Edit'><i class='fa fa-edit'></i></a>";
	    $operate .= "<a class='btn-xs btn-danger delete-blog' data-id='".$r->id."'><i class='fa fa-trash-o'></i></a>";
		$img = "<img src='".base_url().$r->image."' style='height:60px !important'/>";

	    $date=date_create($r->celebrated_date);
		$celebrated_date = date_format($date,"m/d/Y");
			
		$data[] = array($i , $r->title , $img , $celebrated_date , $r->created ,$operate);
        $i++;
	}

	$output = array('draw' => $draw , 'recordsTotal' => $blogs->num_rows() , 'recordsFiltered' => $blogs->num_rows() , 'data' => $data);
    echo json_encode($output);
    exit();

	}

	public function update_blogs($id = null){

		$data['view']='update_blogs';
		$data['page']='Update Blogs';
		$data['blog_id']=$id;
		
		if($id != '' && $id != 'add' && is_numeric($id)){

			$blog_data = $this->common_model->selectbyfield('*' , 'blogs' , array('id' => $id))->row();
			$data['blog_title'] = $blog_data->title;
			$data['description'] = $blog_data->description;
			$data['blog_image'] = $blog_data->image;
			
			$date=date_create($blog_data->celebrated_date);
			$celebrated_date = date_format($date,"m/d/Y");
			
			$data['celebrated_date'] = $celebrated_date;

		}

		$this->template($data);
	}

	public function delete_blogs(){

		$id = $this->security->xss_clean($_POST['blog_id']);
		$old_img = $this->common_model->selectbyfield('image' , 'blogs' , array('id' => $id))->row();
		$old_image = $old_img->image ;
			
		$result = $this->db->delete('blogs', array('id' => $id));
		if($result){

			if(file_exists($old_image)){
				unlink($old_image);
			}

			echo 0;

		}else{
			echo 1;
		}
	}

	public function events(){

		$message = '';
		$result = '';
		$data['view']='events';
		$data['page']='Events';
		$data['table_link']='welcome/event_list';
		$filename = '';

		if($this->input->post('event_id')){

			if($this->input->post('title') && $this->input->post('description') && $this->input->post('event_place')
			&& $this->input->post('event_date') && $this->input->post('event_time') && $this->input->post('hosted_by')
			){
			    $event_dates = $this->input->post('event_date');
			    
			    $date=date_create($event_dates);
			    
                $event_date = date_format($date,"Y-m-d");

			   $id = $this->input->post('event_id');
			   $title = $this->input->post('title');
			   $description = $this->input->post('description');
			   $event_place = $this->input->post('event_place');
			   $event_time = $this->input->post('event_time');
			   $hosted_by = $this->input->post('hosted_by');

			$update_data = array('title' => $title , 
			                    'description' => $description , 
								'place' => $event_place , 
								'event_date' => $event_date , 
								'event_time' => $event_time , 
								'hosted_by' => $hosted_by , 
								'status' => 1);

			if(is_numeric($id)){
				
				$old_img = $this->common_model->selectbyfield('image' , 'events' , array('id' => $id))->row();
				$old_image = $old_img->image ;

			    if(isset($_FILES['image']['name']) && $_FILES['image']['size'] > 0 ){
				    $path = 'upload/event_images/';
				    $upload['allowed_types'] = "jpg|jpeg|png|gif";
				    $upload['upload_path'] = $path;
				
				    $image_name = 'event'.date('dmYhis');

				    $upload['file_name'] = $image_name;
				
				    $this->load->library('upload');
                    $this->upload->initialize($upload);

                    if (!$this->upload->do_upload('image')) {
						$this->session->set_flashdata('message', "<div class='alert alert-danger'>Image could not be uploaded</div>");
						redirect('events');
                    }else{ 
				       $upload_data = $this->upload->data();
                       $filename = $path.$upload_data['file_name']; 
                       $update_data = array_merge($update_data , array('image' => $filename));

					    if(file_exists($old_image)){
							unlink($old_image);
					    }
					}
			    }
		    }elseif(!is_numeric($id) && $id == 'add'){

				if(isset($_FILES['image']['name']) && $_FILES['image']['size'] > 0 ){
					$path = 'upload/event_images/';
					$upload['allowed_types'] = "jpg|jpeg|png|gif";
					$upload['upload_path'] = $path;
			 
					$image_name = 'event'.date('dmYhis');
					$upload['file_name'] = $image_name;
				 
					$this->load->library('upload');
					$this->upload->initialize($upload);
 
					if (!$this->upload->do_upload('image')) {
						$this->session->set_flashdata('message', "<div class='alert alert-danger'>Image could not be uploaded</div>");
					    redirect('events');
					}else{ 
						$upload_data = $this->upload->data();
						$filename = $path.$upload_data['file_name']; 
						$update_data = array_merge($update_data , array('image' => $filename));
					}
				}else{
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>Event not Updated , Image Required</div>");
					redirect('events');
				}
			}
			$update_data = $this->security->xss_clean($update_data);
			if(is_numeric($id)){
              $result = $this->db->update('events' , $update_data , array('id' => $id));
			  $event_id = $id;
			}else if(!is_numeric($id) && $id == 'add'){
			  $result = $this->db->insert('events' , $update_data);
			  $event_id = $this->db->insert_id();
			}

			if($result){

				//$message = 'New Event announced , click for view more info';
				
				//$this->send_push($title, $message, 'Event' , $event_id  , $filename);

				$message .= "<div class='alert alert-success'> event Updated successfully!</div>";
			}else{
				$message .= "<div class='alert alert-danger'> event not Updated try again !!</div>";
			}	
	    }else{
			$message .= "<div class='alert alert-danger'> event not Updated , Tilte and description is required!!</div>";
	    }
		$data['success'] = $message;
	}

		$this->template($data);
	}


	

	public function event_list(){

		$draw = intval($this->input->get('draw'));
		$length = intval($this->input->get('length'));
		$start = intval($this->input->get('start'));
	
		$events = $this->common_model->selectbyfield('*' , 'events');
	
		$data = array();
	
		$i = 1;
	
		foreach($events->result() as $r){
	
			$operate = "<a href ='".base_url('update_events/'.$r->id)."' class='btn-xs btn-info' title='Edit'><i class='fa fa-edit'></i></a>";
			$operate .= "<a class='btn-xs btn-danger delete-event' data-id='".$r->id."'><i class='fa fa-trash-o'></i></a>";
			$img = "<img src='".base_url().$r->image."' style='height:60px !important'/>";
			
			$date=date_create($r->event_date);
			$event_date = date_format($date,"m/d/Y");
			
			$data[] = array($i , $r->title , $img , $r->place , $r->event_date , $r->event_time , $r->hosted_by , $operate);
			$i++;
		}
	
		$output = array('draw' => $draw , 'recordsTotal' => $events->num_rows() , 'recordsFiltered' => $events->num_rows() , 'data' => $data);
		echo json_encode($output);
		exit();	
	}

	public function update_events($id = null){

		$data['view']='update_events';
		$data['page']='Update events';
		$data['event_id']=$id;
		
		if($id != '' && $id != 'add' && is_numeric($id)){
			$event_data = $this->common_model->selectbyfield('*' , 'events' , array('id' => $id))->row();
			$data['event_title'] = $event_data->title;
			$data['description'] = $event_data->description;
			$data['event_image'] = $event_data->image;
			
			$date=date_create($event_data->event_date);
			$event_date = date_format($date,"m/d/Y");
			
			$data['event_date'] = $event_date;
			$data['event_time'] = $event_data->event_time;
			$data['event_place'] = $event_data->place;
			$data['hosted_by'] = $event_data->hosted_by;
		}

		$this->template($data);
	}

	public function delete_event(){

		$id = $this->security->xss_clean($_POST['event_id']);

		$old_img = $this->common_model->selectbyfield('image' , 'events' , array('id' => $id))->row();
		$old_image = $old_img->image ;
		
		$result = $this->db->delete('events', array('id' => $id));


		if($result){
			if(file_exists($old_image)){
				unlink($old_image);
			}
			echo 0;
		}else{
			echo 1;
		}
	}



	public function banners(){
		$data['view']='banners';
		$data['page']='Banners';
		$data['table_link'] = 'welcome/banner_list';
		$this->template($data);
	}


	public function banner_list(){

		$draw = intval($this->input->get('draw'));
		$start = intval($this->input->get('start'));
		$length = intval($this->input->get('length'));

        $banners = $this->common_model->selectbyfield('*' , 'banners');

		$data = array();
		$i=1;

		foreach($banners->result() as $r){

			$operate = "<a class='btn-xs btn-success edit-banner' data-id='".$r->id."' data-banner = '".$r->banner."'  data-toggle='modal' data-target='#editBannermodal' title='Edit'><i class='fa fa-edit'></i></a>";
			$operate .= "<a class='btn-xs btn-danger delete-banner' data-id='".$r->id."'><i class='fa fa-trash-o'></i></a>";
            $banner_img = "<img src = '".base_url().$r->banner."'  style='height:60px !important'/>";
			$data[] = array($i , $banner_img  , $operate);
			$i++;
		}

		$output = array('draw' => $draw , 'recordsTotal' => $banners->num_rows() , 'recordsFiltered' => $banners->num_rows() , 'data' => $data);
		echo json_encode($output);
		exit();	
	}

	public function add_banner(){

		if(isset($_FILES['banner']['name']) && $_FILES['banner']['size'] > 0 ){

			$path = 'upload/banners/';
			$upload['allowed_types'] = "jpg|jpeg|png|gif";
			$upload['upload_path'] = $path;

			$file_name = 'banner'.date('dmYhis');

			$upload['file_name'] = $file_name;

			$this->load->library('upload');
			$this->upload->initialize($upload);
			
			if(!$this->upload->do_upload('banner')){
	
				echo '<label class="alert alert-danger">Image not Uploaded !</label>';	

			}else{
				$upload_data = $this->upload->data();;
				$img_name = $path.$upload_data['file_name'];
				$result = $this->db->insert('banners' , array('banner' => $img_name , 'status' => 1));

				if($result){
					echo '<label class="alert alert-success">Banner Added Successfully!</label>';
				}else{
					echo '<label class="alert alert-danger">Image not Inserted !</label>';
				}
			}

		}else{
        echo '<label class="alert alert-danger">Image not provided !</label>';
		}
	}

	public function update_banner(){

		if($this->input->post('banner_id')){

		  $id = $this->input->post('banner_id');

		    if(isset($_FILES['banner']['name']) && $_FILES['banner']['size'] > 0){

			  $path = 'upload/banners/';
			  $upload['upload_path'] = $path;
			  $upload['allowed_types'] = 'jpg|jpeg|png|gif';
			  $filename = 'banner'.date('dmYhis');

			  $upload['file_name'] =  $filename;

			  $this->load->library('upload');
			  $this->upload->initialize($upload);

			  if(!$this->upload->do_upload('banner')){

				echo '<label class="alert alert-danger">Image not Uploaded !</label>';

			  }else{

				$upload_data = $this->upload->data();;
				$img_name = $path.$upload_data['file_name'];

				$old_img = $this->common_model->selectbyfield('banner' , 'banners' , array('id' => $id))->row();
				$old_image = $old_img->banner ;

				$result = $this->db->update('banners' , array('banner' => $img_name , 'status' => 1) , array('id' => $id));

				if($result){
					
					if(file_exists($old_image)){
						unlink($old_image);
					}

					echo '<label class="alert alert-success">Banner Updated Successfully!</label>';
				}else{
					echo '<label class="alert alert-danger">Image not Inserted !</label>';
				}

			  } 
		    }
		}else{
			echo "<lebel class='alert alert-danger'>Banner id not privided </lebel>";
		}	
	}

	public function delete_banner(){

		if($this->input->post('banner_id')){

		  $id = $this->input->post('banner_id');

		  $old_banner = $this->common_model->selectbyfield('banner' , 'banners' , array('id' => $id))->row();
		  $old_banner = $old_banner->banner;

		  $result = $this->db->delete('banners' , array('id' => $id));

		  if($result){
			  if(file_exists($old_banner)){
				  unlink($old_banner);
			  }
			  echo 0;
		  }
		}else{
			echo 1;
		}
	}


	public function image_gallery(){
		$data['view']='image_gallery';
		$data['page']='Image Gallery';
		$data['table_link'] = 'welcome/gallery_list';
		$data['category_link'] = 'welcome/gallery_category_list';
		$data['options'] = $this->common_model->selectbyfield('*' , 'category')->result();
		$this->template($data);
	}

	public function gallery_list(){

		$draw = intval($this->input->get('draw'));
		$start = intval($this->input->get('start'));
		$length = intval($this->input->get('length'));

		$gallery = $this->common_model->get_gallery();

		$data = array();
		$i = 1;

		foreach($gallery->result() as $r){
			$operate = "<a class='btn-xs  btn-success edit-gallery' data-id = '".$r->id."' data-gallery = '".$r->image."' data-category = '".$r->category."' title='Edit' data-toggle = 'modal' data-target = '#editGallerymodal'><i class='fa fa-edit'></i></a>";
			$operate .= "<a class='btn-xs btn-danger delete-gallery' data-id='".$r->id."'><i class='fa fa-trash-o'></i></a>";
			$gal_img = "<img src='".base_url().$r->image."' style='height:60px !important'/>";
			$data[] = array($i , $gal_img , $r->category_name , $operate);
			$i++;
		}
		
		$output = array('draw' => $draw , 'recordsTotal' => $gallery->num_rows() , 'recordsFiltered' => $gallery->num_rows() , 'data' => $data);
		echo json_encode($output);
		exit();	
	}

	public function gallery_category_list(){

		$draw = intval($this->input->get('draw'));
		$start = intval($this->input->get('start'));
		$length = intval($this->input->get('length'));

		$cat = $this->common_model->selectbyfield('*' , 'category');

		$data = array();
		$i = 1;

		foreach($cat->result() as $r){
			$operate = "<a class='btn-xs  btn-success edit-cat' data-id = '".$r->id."' data-title = '".$r->name."' title='Edit' data-toggle = 'modal' data-target = '#editGall_Catmodal'><i class='fa fa-edit'></i></a>";
			$operate .= "<a class='btn-xs btn-danger delete-cat' data-id='".$r->id."'><i class='fa fa-trash-o'></i></a>";
			$data[] = array($i , $r->name , $operate);
			$i++;
		}
		
		$output = array('draw' => $draw , 'recordsTotal' => $cat->num_rows() , 'recordsFiltered' => $cat->num_rows() , 'data' => $data);
		echo json_encode($output);
		exit();	

	}

	public function gallery_category(){

		$name = $this->security->xss_clean($_POST['gallery_category_name']);

		$result = $this->db->insert('category' , array('name' => $name , 'status' => 1));

		if($result){
			echo '<label class="alert alert-success">Category Added Successfully!</label>';
		}else{
			echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
		}
	}
	

	public function update_gallery_category(){

		$id = $this->security->xss_clean($_POST['cat_id']);
		$name = $this->security->xss_clean($_POST['gallery_category_name']);

		$result = $this->db->update('category' , array('name' => $name) , array('id' => $id));
	
		if($result){
			echo "<label class='alert alert-success'>Category Updated Successfully.</label>";
		}else{
			echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";

		}
	}


	public function delete_gallery_category(){

		$id = $this->security->xss_clean($_POST['cat_id']);
		$result = $this->db->delete('category', array('id' => $id));
        
		if($result){
			echo 0;
		}else{
			echo 1;
		}
	}



	public function add_gallery(){

		$insert_data = array();

		$category = $this->security->xss_clean($_POST['category']);


		if(!empty($category) && isset($_FILES['gallery']['name']) && $_FILES['gallery']['size'] > 0){

			$path = 'upload/gallery/';
			$upload['upload_path'] = $path;
			$upload['allowed_types'] = 'jpg|jpeg|png|gif';
			$file_name = 'gallery'.date('dmYhis');
			$upload['file_name'] = $file_name;

			$this->load->library('upload');
			$this->upload->initialize($upload);

			if(!$this->upload->do_upload('gallery')){

				echo "<label class='alert alert-danger'>Gallery Image not uploaded</label>";

			}else{

				$upload_data = $this->upload->data();

				$img_name = $path.$upload_data['file_name'];

				$insert_data = array('category' => $category , 'image' => $img_name);

                $insert_data = $this->security->xss_clean($insert_data);

				$result = $this->db->insert('gallery' , $insert_data);

				if($result){
					echo '<label class="alert alert-success">Gallery Image Updated Successfully!</label>';
				}else{
					echo '<label class="alert alert-danger">Gallery Image not Inserted !</label>';
				}
			}
		}else{

			echo "<label class='alert alert-danger'> Gallery Image not provided</label>";
		}
	}

	public function update_gallery(){

		if($this->input->post('gallery_id')){

			$id = $this->input->post('gallery_id');

			$old_img = $this->common_model->selectbyfield('image' , 'gallery' , array('id' => $id))->row();
			$old_image = $old_img->image ;

			$update_data = array();

            $category = $this->security->xss_clean($_POST['gall_category']);

			if(!empty($category)){

				$update_data = array('category' => $category);
			}

			if(isset($_FILES['gallery']['name']) && $_FILES['gallery']['size'] > 0){

				$path = 'upload/gallery/';
				$upload['upload_path'] = $path;
				$upload['allowed_types'] = 'jpg|jpeg|png|gif';
				$file_name = 'gallery'.date('dmYhis');
				$upload['file_name'] = $file_name;

				$this->load->library('upload');
			    $this->upload->initialize($upload);

			    if(!$this->upload->do_upload('gallery')){

				   echo "<label class='alert alert-danger'>Gallery Image not uploaded</label>";

			    }else{

				   $upload_data = $this->upload->data();
				   $img_name = $path.$upload_data['file_name'];
				  
				   $update_data = array_merge($update_data , array('image' => $img_name)); 
			    }

			}

			$update_data = $this->security->xss_clean($update_data);

			$result = $this->db->update('gallery' , $update_data , array('id' => $id));

			if($result){

				if(file_exists($old_image)){
					unlink($old_image);
				}

				echo '<label class="alert alert-success">Gallery Image Updated Successfully!</label>';

			}else{

				echo '<label class="alert alert-danger">Gallery Image not Inserted !</label>';
			}
		}else{
			echo '<label class="alert alert-danger"> Gallery not updated, ID Required!</label>';
		}
	}

	public function delete_gallery(){

		if($this->input->post('id')){

		  $id = $this->input->post('id');

		  $old_img = $this->common_model->selectbyfield('image' , 'gallery' , array('id' => $id))->row();
		  $old_image = $old_img->image;

		  $result = $this->db->delete('gallery' , array('id' => $id));

		  if($result){
			  if(file_exists($old_image)){
				  unlink($old_image);
			  }
			  echo 0;
		  }
		}else{
			echo 1;
		}
	}

	



	public function blessings(){

		$permissions = $this->get_permissions();
		$data['view']='blessings';
		$data['page']='Blessings';
		$message = '';
		

		if(isset($_POST['btn_update'])){

			if($permissions['blessings']['update']==1){
				
				$blessings = $this->security->xss_clean($_POST['blessings']);
				
				$update_data = array('blessing' => $blessings , 'created' => date('Y-m-d'));

				$bless_data = $this->common_model->selectbyfield('*' , 'blessings')->row();
				
			    $update_data = $this->security->xss_clean($update_data);

			    if(!empty($bless_data) && $bless_data->id){
				   $id = $bless_data->id;
                   $result = $this->db->update('blessings',$update_data, array('id' => $id));
			    }else{
                   $result = $this->db->insert('blessings',$update_data);
			    }	

                $message .= "<div class='alert alert-success'>Daily Blessings Updated Successfully!</div>";
            }else{
				$message .= "<label class='alert alert-danger'>You have no permission to update Blessings</label>";
			}
			$data['success'] = $message;
		}

		$bless_data = $this->common_model->selectbyfield('*' , 'blessings')->row();
		$data['res']= $bless_data;
		$this->template($data);
	}


	public function about_aashram(){
		$permissions = $this->get_permissions();
		$data['view']='about_aashram';
		$data['page']='About Aashram';
		$message = '';
		$old_image= '';

		if(isset($_POST['btn_update'])){

			if($permissions['about_aashram']['update']==1){
				
				$about_aashram = $this->security->xss_clean($_POST['about_aashram']);
				
				$update_data = array('description' => $about_aashram);

				$old_img = $this->common_model->selectbyfield('*' , 'about_aashram')->row();

				if(!empty($old_img) && $old_img->image){
					$old_image = $old_img->image;
				}
	
				if(isset($_FILES['image']['name']) && $_FILES['image']['size'] > 0 ){
					$path = 'upload/blessings/';
					$upload['allowed_types'] = "jpg|jpeg|png|gif";
					$upload['upload_path'] = $path;
				
					$image_name = 'aashram'.date('dmYhis');
					$upload['file_name'] = $image_name;
					
					$this->load->library('upload');
					$this->upload->initialize($upload);
	
					if (!$this->upload->do_upload('image')) {
						$this->session->set_flashdata('message', "<div class='alert alert-danger'>Image could not be uploaded</div>");
						redirect('about_aashram');
					}else{ 
						$upload_data = $this->upload->data();
						$filename = $path.$upload_data['file_name']; 
						$update_data = array_merge($update_data , array('image' => $filename));
						if(file_exists($old_image)){
							unlink($old_image);
						}  
					}
				}

				if(!empty($old_img) && $old_img->id){
					$id = $old_img->id;
					$result = $this->db->update('about_aashram',$update_data, array('id' => $id));
				}else{
					$result = $this->db->insert('about_aashram',$update_data);
				}	

				$message .= "<div class='alert alert-success'>About Aashram Updated Successfully!</div>";

				}else{

				$message .= "<label class='alert alert-danger'>You have no permission to update About Aashram</label>";

			}
			$data['success'] = $message;
		}

		$bless_data = $this->common_model->selectbyfield('*' , 'about_aashram')->row();
		$data['res']=$bless_data;
		$this->template($data);
	}

	public function about_swamiji(){
		$permissions = $this->get_permissions();
		$data['view']='about_swamiji';
		$data['page']='About Swamiji';
		$message = '';
		$old_image= '';

		if(isset($_POST['btn_update'])){

			if($permissions['about_swamiji']['update']==1){
				
				$about_swamiji = $this->security->xss_clean($_POST['about_swamiji']);
				
				$update_data = array('description' => $about_swamiji);
			
				$old_img = $this->common_model->selectbyfield('*' , 'about_swamiji')->row();

				if(!empty($old_img) && $old_img->image){
					$old_image = $old_img->image;
				}
	
				if(isset($_FILES['image']['name']) && $_FILES['image']['size'] > 0 ){
					$path = 'upload/blessings/';
					$upload['allowed_types'] = "jpg|jpeg|png|gif";
					$upload['upload_path'] = $path;
				
					$image_name = 'swamiji'.date('dmYhis');
					$upload['file_name'] = $image_name;
					
					$this->load->library('upload');
					$this->upload->initialize($upload);
	
					if (!$this->upload->do_upload('image')) {
						$this->session->set_flashdata('message', "<div class='alert alert-danger'>Image could not be uploaded</div>");
						redirect('about_swamiji');
					}else{ 
						$upload_data = $this->upload->data();
						$filename = $path.$upload_data['file_name']; 
						$update_data = array_merge($update_data , array('image' => $filename));
						if(file_exists($old_image)){
							unlink($old_image);
						}  
					}
				}

				if(!empty($old_img) && $old_img->id){
					$id = $old_img->id;
					$result = $this->db->update('about_swamiji',$update_data, array('id' => $id));
				}else{
					$result = $this->db->insert('about_swamiji',$update_data);
				}	

				$message .= "<div class='alert alert-success'>About Swami ji Updated Successfully!</div>";

				}else{

				$message .= "<label class='alert alert-danger'>You have no permission to update About Swami ji</label>";

			}
			$data['success'] = $message;
		}

		$bless_data = $this->common_model->selectbyfield('*' , 'about_swamiji')->row();
		$data['res']=$bless_data;
		$this->template($data);
	}


	

	public function transactions(){
		$data['view']='transactions';
		$data['page']='Transactions';
		$data['table_link']='welcome/transaction_list';
		$this->template($data);
	}

	public function transaction_list(){

		$where = array();

		$currency= $this->common_model->get_settings('currency');
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	
		if($this->input->post('start_date') != '' && $this->input->post('end_date') !=''){
	
			$from_date = $this->input->post('start_date');
			$to_date = $this->input->post('end_date');
	
			$where = array('DATE(t.transaction_date) <= ' => $to_date , 'DATE(t.transaction_date) >=' => $from_date);
		
			$transactions = $this->common_model->transaction_list($where);
			//print_r($transactions);die;
			$total_records = count((array)$transactions);
	
		}else{
	
		$transactions = $this->common_model->transaction_list();
	
		$total_records = count((array)$transactions);
	
		}
		
		$data = array();
		$i=1;
	
		foreach($transactions as $key => $value) {
			$data[] = array($i , $value->txn_id, $value->category, $value->amount, $value->status, $value->transaction_date);
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


