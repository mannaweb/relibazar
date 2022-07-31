<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

		$this->db->select('users.id,users.name,users.email,users.created_at,users.status,user_profiles.profile_image,users.phone,users.email_verified,users.phone_verified');
		$this->db->from('users');
		$this->db->join('user_profiles','user_profiles.user_id = users.id AND user_profiles.logged_using=users.logged_using','left');
		$this->db->where('users.deleted_at', NULL);
		$this->db->where_in('role',array('user'));

		if(isset($params['status']) && $params['status']){
			$this->db->where('users.status',$params['status']);	
		}
		if(isset($params['email_verified']) && $params['email_verified']){
			$this->db->where('users.email_verified',$params['email_verified']);	
		}
		if(isset($params['phone_verified']) && $params['phone_verified']){
			$this->db->where('users.phone_verified',$params['phone_verified']);	
		}
		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(users.name LIKE "%'.$params['keyword'].'%" OR users.email LIKE "%'.$params['keyword'].'%" OR users.phone LIKE "%'.$params['keyword'].'%")');	
		}

		if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('users.created_at >=',$st);
			  $this->db->where('users.created_at <=',$et);
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('users.id','DESC');
		}

		if(array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit'],$limit['start']);
		}elseif(!array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit']);
		}

		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return ($query->num_rows() > 0)?$query->result():array();

	}

	public function getData($id=''){

		// $this->db->select('user_profiles.*,users.*');
		// $this->db->from('users');
		// $this->db->join('user_profiles','user_profiles.user_id = users.id AND user_profiles.logged_using=users.logged_using','left');
		// $this->db->where('users.id',$id);
		
		// return $this->db->get()->row();

		$this->db->select('users.*');
		$this->db->from('users');
		$this->db->where('users.id',$id);
		$user_info = $this->db->get()->row();
		
		$this->db->select('address,city,state,country,pin_code,latitude,longitude,profile_image,user_profiles.logged_using as profile_type');
		$this->db->where('user_id',$id);
		$this->db->from('user_profiles');
		$profile_info = $this->db->get()->result();
		if ($profile_info != '' && count($profile_info) == 1) {
			$data = (object) array_merge((array) $user_info, (array) $profile_info[0]); 
		}else{
			foreach ($profile_info as $key => $value) {
				if ($value->profile_type == 'system') {
					$data = (object) array_merge((array) $user_info, (array) $profile_info[$key]); 
				}else if($user_info->logged_using == $value->profile_type){
					$data = (object) array_merge((array) $user_info, (array) $profile_info[$key]); 
				}
			}
		}
		return $data;
	}

	public function saveData($data=array()){
			
		if($data['id']){
			$data['modified_at'] = date('Y-m-d H:i:s');
			if($data['password'] == ''){
				unset($data['password']);
				$data['name'] = $data['firstname'].' '.$data['lastname'];
			} else {
				$data['name'] = $data['firstname'].' '.$data['lastname'];
				$data['password'] = md5($data['password']);
			}
			$id = $data['id'];
			unset($data['id']);
			$this->db->where('id',$id)->update('user',$data);
		} else {
			$data['name'] = $data['firstname'].' '.$data['lastname'];
			$data['password'] = md5($data['password']);
			$data['created_date'] = date('Y-m-d H:i:s');
			$this->db->insert('user',$data);
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	public function emailCheck($where=array()){

		$return = $this->db->get_where('user',$where)->num_rows();
		if($return > 0){
			return array('status'=>2,'msg'=>'Email already exists.');
		} else {
			return array('status'=>1);
		}
	}

	public function statusChange($data=array()){

		$this->db->where('id',$data['id'])->update('users',array('status'=>$data['status']));
		return array('status'=>1,'msg'=>'Status changed successfully.');
	}


	public function statusPhone($data=array()){

		$this->db->where('id',$data['id'])->update('users',array('phone_verified'=>$data['phone_verified']));
		return array('status'=>1,'msg'=>'Update successfully.');
	}

	public function statusEmail($data=array()){

		$this->db->where('id',$data['id'])->update('users',array('email_verified'=>$data['email_verified']));
		return array('status'=>1,'msg'=>'Update successfully.');
	}

	public function deleteData($data=array()){

		if($data['ids']){
			$ids = explode(',', $data['ids']);
			if($data['status'] == 3 ){
			$getData = $this->db->where_in('id',$ids)->get('user')->result();
			if($getData){
				foreach ($getData as $key => $value) {
					@unlink($value->profile);
				}
				
			}
			$this->db->where_in('id',$ids)->delete('user');
			$this->db->where_in('user_id',$ids)->delete('user_profiles');
			return array('status'=>1,'msg'=>'Deleted successfully.');

		}else{
			$this->db->where_in('id',$ids)->update('users',array('status'=>3,'deleted_at'=>date('Y-m-d H:i:s'),'deleted_by'=>$this->session->userdata('user_id')));
			return array('status'=>1,'msg'=>'Trash successfully.');
		}
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}
}
?>