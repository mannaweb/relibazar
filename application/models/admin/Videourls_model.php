<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videourls_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getData($post_id){
		return $this->db->get_where('gallery',array('post_id'=>$post_id,'type'=>2))->result();
	}

	public function saveData($data=array(),$id=''){
		if(!empty($id)){
			  $data['modified_at'] = date('Y-m-d H:i:s');
			  $data['modified_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$id)->update('gallery',$data);
		}else{
			 $data['created_at'] = date('Y-m-d H:i:s');
			 $data['created_by'] = $this->session->userdata('user_id');
			$this->db->insert('gallery',$data);
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	public function deleteData($id){
		if($id){
			$this->db->where('id',$id)->delete('gallery');
			return array('status'=>1,'msg'=>'Deleted successfully.');
		}else{
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}

	

}
