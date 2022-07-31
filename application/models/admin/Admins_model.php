<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

			$this->db->select('users.id,users.name,users.email,users.created_at,users.status,user_profiles.profile_image');
			$this->db->from('users');
			$this->db->join('user_profiles','user_profiles.user_id = users.id','left');
			$this->db->where_in('role',array('admin','vendor'));

		if(isset($params['status']) && $params['status']){
			$this->db->where('users.status',$params['status']);	
		}

		if(isset($params['role']) && $params['role']){
			$this->db->where('users.role',$params['role']);	
		}

		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(users.name LIKE "%'.$params['keyword'].'%" OR users.email LIKE "%'.$params['keyword'].'%")');	
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
		// echo $this->db->last_query();die();
		return ($query->num_rows() > 0)?$query->result():array();

	}

	public function getData($id=''){
		$this->db->select('users.*,user_profiles.profile_image');
		$this->db->from('users');
		$this->db->join('user_profiles','user_profiles.user_id = users.id','left');
		$this->db->where('users.id',$id);
		
		return $this->db->get()->row();
	}

	public function saveData($data=array()){
         //echo '<pre>';print_r($data);die;
          $getRole = $this->db->get_where('users',array('id'=>1))->row();
          $permission = json_decode($getRole->access_management,true);
          //echo '<pre>';print_r($permission);die;
          if($data['role'] == 'vendor'){
          unset($permission[0]);
           unset($permission[15]);
           unset($permission[16]);
            unset($permission[17]);
             unset($permission[18]);
              unset($permission[66]);
              unset($permission[67]);
               unset($permission[68]);
                unset($permission[69]);
                 unset($permission[70]);
         }
            // echo '<pre>';print_r($permission);die;
          $data['access_management'] = json_encode($permission);

		if(isset($data['role_parent'])){
			unset($data['role_parent']);
		}

		if(isset($data['profile_image'])){
			$profile_image = $data['profile_image'];
			unset($data['profile_image']);
		}else{
			$profile_image = '';
		}

		if(isset($data['role_sub'])){
			unset($data['role_sub']);
		}

		if($data['id']){
			$data['modified_at'] = date('Y-m-d H:i:s');
			if($data['password'] == ''){
				unset($data['password']);
			} else {
				$data['password'] = md5($data['password']);
			}
			$id = $data['id'];
			unset($data['id']);
			$this->db->where('id',$id)->update('users',$data);

			$getUser = $this->db->get_where('user_profiles', array('user_id'=>$id))->row();
			if($getUser){
				$this->db->where('id',$getUser->id)->update('user_profiles',array('profile_image'=>$profile_image));
			}else{
				$this->db->insert('user_profiles',array('user_id'=>$id,'profile_image'=>$profile_image));
			}
		} else {
			$data['password'] = md5($data['password']);
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('users',$data);
			$lastId = $this->db->insert_id();
			$username = strstr($data['email'], '@', true); 

			$check = $this->db->get_where('users',array('username'=>$username))->result_array();
			// if(count($check)>0){
			// 	$username = $username.''.$lastID;
			// }
			// $update = $this->db->where('id',$lastID)->update('users',array('username'=>$username));
			$this->db->insert('user_profiles',array('user_id'=>$lastId,'profile_image'=>$profile_image));
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	

	public function emailCheck($where=array()){

		$return = $this->db->get_where('users',$where)->num_rows();
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

	public function deleteData($data=array()){

		if($data['ids']){
			$ids = explode(',', $data['ids']);
			$getData = $this->db->where_in('id',$ids)->get('users')->result();
			if($getData){
				foreach ($getData as $key => $value) {
					@unlink($value->profile);
				}
				
			}
			$this->db->where_in('id',$ids)->delete('users');
			return array('status'=>1,'msg'=>'Deleted successfully.');
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}
}
?>