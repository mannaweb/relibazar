<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function login($data=array()){

		$querystring = 'Select * from users where (username = "' . $data['email'] . '" or email = "' . $data['email'] . '")';

		$query = $this->db->query($querystring); 
		$user_info = $query->row();
		if($user_info){
		$query1 = $this->db->where_in('role',array('admin','vendor'))->get_where('users',array('email'=>$user_info->email,'password'=>md5($data['password'])))->row();

		if($query1 && ($query1->status == 1 )){
			
			$this->session->set_userdata('user_id',$query1->id);
			$this->session->set_userdata('role',$query1->role);
			$return = array('status'=>1,'msg'=>'You have successfully logged in');
		} else if($query1 && $query1->status != 1){
			$return = array('status'=>2,'msg'=>'Your account is not activated');
		} else {
			$return = array('status'=>2,'msg'=>'Username or Email or password is incorrect');
		}
	}else{
		$return = array('status'=>2,'msg'=>'Username or Email or password is incorrect');
	}

		return $return;
	}
}
?>