<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

		$this->db->select('id,title,slug,page_type,type,is_delete,created_at');
		$this->db->from('pages');

		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(pages.title LIKE "%'.$params['keyword'].'%")');	
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('pages.id','DESC');
		}

		
		if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('pages.created_at >=',$st);
			  $this->db->where('pages.created_at <=',$et);
		}

		$this->db->where('pages.deleted_at is NULL', NULL, FALSE);


		if(array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit'],$limit['start']);
		}elseif(!array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit']);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return ($query->num_rows() > 0)?$query->result():array();

	}

	public function getData($alias=''){

		return $this->db->get_where('pages',array('slug'=>$alias))->row();
	}

	public function saveData($data=array()){
		if($data['id']){
			$id = $data['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
			unset($data['id']);
			$this->db->where('id',$id)->update('pages',$data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('pages',$data);
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	public function aliasCheck($where=array()){

		$return = $this->db->where('deleted_at is NULL', NULL, FALSE)->get_where('pages',$where)->num_rows();
		if($return > 0){
			return array('status'=>2,'msg'=>'Page alias already exists.');
		} else {
			return array('status'=>1);
		}
	}

	public function deleteData($data=array()){

		if($data['ids']){
			$ids = explode(',', $data['ids']);
			$this->db->where_in('id',$ids)->update('pages',array('deleted_by'=>$this->session->userdata('user_id'),'deleted_at'=>date('Y-m-d H:i:s')));
			return array('status'=>1,'msg'=>'Deleted successfully.');
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}


}
?>