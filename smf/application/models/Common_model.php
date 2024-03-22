<?php
class Common_model extends CI_Model {
    
    
    
    public function send_email($to,$subject,$message){
		
	$settings = $this->get_configurations();


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

    $this->load->library('email');
	$this->email->initialize($config); 
	$this->email->set_newline("\r\n");  
	$this->email->from($settings['from_mail'],$settings['app_name']);
	$this->email->to($to);
	$this->email->subject($subject);
	$this->email->message($message);
		
  
    if(!$this->email->send()){
		return 0;
    }else{
        return 1;
    }
    //print_r($this->email->print_debugger());die;
  }
    
    
    
    
    


//-- select function by field name
function selectbyfield($field = '*'  , $table='' , $where = array() ,$sort='DESC',$sort_by='id' , $where_in = ''){

    $this->db->select($field);
    $this->db->from($table);

    if($where){
    $this->db->where($where);
    }
    
    if(!empty($where_in)){
    $this->db->where_in('id' , $where_in);
    }

    $this->db->order_by($sort_by,$sort);
    
    $query = $this->db->get();

    return $query;
}

   // get table count
    public function get_count($table){

        return $this->db->count_all($table);
    }

    // count by field
    public function count_rows($table='' , $field = '*' ,  $where=''){

        $this->db->select($field);
        $this->db->from($table);

        if(!empty($where)){
        $this->db->where($where);
        }

        $query = $this->db->count_all_results();
      
        return $query;
    }


    public function get_configurations(){

        $con = array('variable'=> 'system_timezone');
        $res = $this->selectbyfield( 'value' , 'settings' , $con)->row();
    
        if(!empty($res)){
            return json_decode($res->value,true);
        }else{
            return false;
        }
    }
    
    public function get_settings($variable,$is_json = false){

        $con = array('variable'=> $variable);
        $res = $this->selectbyfield('value','settings' , $con)->row();
       
        if(!empty($res) && isset($res->value)){
            if($is_json)
                return json_decode($res->value,true);
            else
                return $res->value;
        }else{
            return false;
        }
    }


    public function transaction_list($where = array()){

        $this->db->select('t.txn_id,c.name as category, t.amount, t.status, t.transaction_date');
        $this->db->from('transactions t');
        $this->db->join('users u' , 't.user_id = u.id');
        $this->db->join('category c' , 't.category = c.id');
        $this->db->order_by('t.id',' DESC');
        if(!empty($where)){
        $this->db->where($where); 
        }
        $query = $this->db->get();
        //return $this->db->last_query();
        $row=$query->result();  
        return $row;
    }

    public function get_gallery(){

        $query = $this->db->select('gallery.* , category.name as category_name')
                          ->from('gallery')
                          ->join('category', 'category.id = gallery.category')
                          ->get();
        return $query;
    }
    
      public function set_timezone(){
    
        $config=$this->get_configurations();

        if(isset($config['system_timezone']) && isset($config['system_timezone_gmt'])){

          date_default_timezone_set($config['system_timezone']);
          $this->db->query("SET `time_zone` = '".$config['system_timezone_gmt']."'");
          
        }else{

	      date_default_timezone_set('Asia/Kolkata');
	      $this->db->query("SET `time_zone` = '+05:30'");
    }
}

    public function update_table($table,$data,$where){

		if($this->db->update($table,$data,$where)) {
			return true;
            
		} else {

			return false;
		}
	}
      

}