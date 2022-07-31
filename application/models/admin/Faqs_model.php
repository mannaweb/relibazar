<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){
		$this->db->select('id,ordering,question,answer,status,created_at');
		$this->db->from('faqs');

		if(isset($params['status']) && $params['status']){
			$this->db->where('faqs.status',$params['status']);	
		}
		
		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(faqs.question LIKE "%'.$params['keyword'].'%")');	
		}

		if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('faqs.created_at >=',$st);
			  $this->db->where('faqs.created_at <=',$et);
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('faqs.ordering','ASC');
		}

		$this->db->where('faqs.deleted_at is NULL', NULL, FALSE);

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
		return $this->db->get_where('faqs',array('id'=>$id))->row();
	}

	public function saveData($data=array()){

		

		if(isset($data['id']) && !empty($data['id'])){
			$id = $data['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
			unset($data['id']);
			$this->db->where('id',$id)->update('faqs',$data);
		} else {
			$ordering = $this->db->query('Select faqs.ordering from faqs order by ordering desc')->row();	
			if($ordering){
				$data['ordering'] = $ordering->ordering+1;
			}else{
				$data['ordering'] = 1;
			}
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('faqs',$data);
		}
		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	public function deleteData($data=array()){
		if($data['ids']){
			$ids = explode(',', $data['ids']);
			$this->db->where_in('id',$ids)->update('faqs',array('status'=>3,'deleted_by'=>$this->session->userdata('user_id'),'deleted_at'=>date('Y-m-d H:i:s')));
			return array('status'=>1,'msg'=>'Deleted successfully.');
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}

	public function statusChange($data=array()){
		$this->db->where('id',$data['id'])->update('faqs',array('status'=>$data['status']));
		return array('status'=>1,'msg'=>'Status changed successfully.');
	}

	public function changeFeaturedForum($data=array()){
		$this->db->where('id',$data['id'])->update('faqs',array('featured'=>$data['featured']));
		return array('status'=>1,'msg'=>'Forum featured successfully.');
	}

	public function saveOrdering($data=array()){
		if($data['ids']){
			foreach ($data['ids'] as $key => $value) {
				$this->db->where('id',$value)->update('faqs',array('ordering'=>$data['ordering'][$key]));
			}
			return array('status'=>1,'msg'=>'Updated successfully.');
		}
	}

}