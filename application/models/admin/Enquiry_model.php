<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

$this->db->select('enquiries.id,enquiries.product_id,users.id as user_id,enquiries.name,enquiries.email,enquiries.message,enquiries.phone,enquiries.created_at,products.name as product_name,products.slug as pro_slug');
		$this->db->from('enquiries');

		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(enquiries.name LIKE "%'.$params['keyword'].'%" OR enquiries.email LIKE "%'.$params['keyword'].'%" OR enquiries.phone LIKE "%'.$params['keyword'].'%")');	
		}

		if(isset($params['products']) && $params['products']){
			$this->db->where('enquiries.product_id',$params['products']);	
		}

		if(isset($params['users']) && $params['users']){
			$this->db->where('enquiries.user_id',$params['users']);	
		}

		if(isset($params['user_id']) && $params['user_id']){
			$this->db->where('enquiries.user_id',$params['user_id']);	
		}
       //echo $params['product_id'];die;
		if(isset($params['product_id']) && $params['product_id']){
			$this->db->where('enquiries.product_id',$params['product_id']);	
		}



			if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('enquiries.created_at >=',$st);
			  $this->db->where('enquiries.created_at <=',$et);
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('enquiries.id','DESC');
		}

		if(array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit'],$limit['start']);
		}elseif(!array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit']);
		}
		$this->db->join('products','products.id = enquiries.product_id','left');
        $this->db->join('users','users.id = enquiries.user_id','left');
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return ($query->num_rows() > 0)?$query->result():array();

	}


	public function deleteData($data=array()){
		//print_r($data['ids']);die;
		if($data['ids']){
			$ids = explode(',', $data['ids']);
			//$getData = $this->db->where_in('id',$ids)->get('products')->result();
			// if($getData){
			// 	foreach ($getData as $key => $value) {
			// 		@unlink('./uploads/products/'.$value->image);
			// 		$getgallery = $this->db->where('post_id',$value->id)->where('type',1)->get('gallery')->result();
			// 		if($getgallery){
			// 			foreach ($getgallery as $key1 => $value1) {
			// 				@unlink('./uploads/products/gallery/'.$value1->image);
			// 				@unlink('./uploads/post/gallery/150x150/'.$value1->image);
			// 			}
			// 		}

			// 	}
				
			// }
			//$this->db->where_in('post_id',$ids)->delete('gallery');
				$this->db->where_in('id',$ids)->delete('enquiries');
			return array('status'=>1,'msg'=>'Deleted successfully.');
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}

	

	
}
?>