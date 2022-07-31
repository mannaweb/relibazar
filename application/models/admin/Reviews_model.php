<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

			$this->db->select('susers.name as sname,rusers.name as rname,listings.title as list_title,listing_reviews.id,listing_reviews.title,listing_reviews.ratting,listing_reviews.description,listing_reviews.created_at,listing_reviews.is_editable,listings.id as listing_id,susers.id as sid,rusers.id as rid');
			$this->db->from('listing_reviews');
			$this->db->join('users as susers','susers.id = listing_reviews.review_by','left');
			$this->db->join('users as rusers','rusers.id = listing_reviews.review_to','left');
			$this->db->join('listings','listings.id = listing_reviews.listing_id','left');
						

		// if(isset($params['status']) && $params['status']){
		// 	$this->db->where('listing_reviews.is_editable',$params['status']);	
		// }

		if(isset($params['reviewTo_user_id']) && $params['reviewTo_user_id']){
			$this->db->where('listing_reviews.review_to',$params['reviewTo_user_id']);	
		}
		if(isset($params['reviewBy_user_id']) && $params['reviewBy_user_id']){
			$this->db->where('listing_reviews.review_by',$params['reviewBy_user_id']);	
		}
		if(isset($params['listing_id']) && $params['listing_id']){
			$this->db->where('listing_reviews.listing_id',$params['listing_id']);	
		}

		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(susers.name LIKE "%'.$params['keyword'].'%" OR listing_reviews.description LIKE "%'.$params['keyword'].'%" OR listing_reviews.title LIKE "%'.$params['keyword'].'%" OR rusers.name LIKE "%'.$params['keyword'].'%")');	
		}


         if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('listing_reviews.created_at >=',$st);
			  $this->db->where('listing_reviews.created_at <=',$et);
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('listing_reviews.id','DESC');
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
		return $this->db->get_where('listing_reviews', array('id'=>$id))->row();
	}


	public function saveData($data=array()){
		if($data['id']){

			$id = $data['id'];			
			unset($data['id']);

			$data['modified_by'] = $this->session->userdata('user_id');
			$data['modified_at'] = date('Y-m-d H:i:s');
			$this->db->where('id',$id)->update('listing_reviews',$data);
			return array('status'=>1,'msg'=>'Data successfully saved');
		} else {
			return array('status'=>2,'msg'=>'Something is worng. Please try again');
		}

		
	}

	public function statusChange($data=array()){
		$this->db->where('id',$data['id'])->update('listing_reviews',array('is_editable'=>$data['status']));
		return array('status'=>1,'msg'=>'Status changed successfully.');
	}
	
}
?>