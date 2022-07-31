<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){
		//echo 'hiolum';
		//echo $this->uri->segment(1);die;
		$this->db->select('id,category_ids,slug,name,short_description,image,regular_price,selling_price,product_type,tax_status,tax,ordering,created_at');
		$this->db->from('products');
		$this->db->where('status',1);
		// if($this->uri->segment(1) == 'wedding-delight'){
		// 	$this->db->where('category_ids',42);
		// }else{
		// 	$this->db->where('category_ids!=',42);
		// }
		
		$this->db->where('deleted_at',NULL);
		// if(isset($params['keyword']) && $params['keyword']){
		// 	$this->db->where('(products.name LIKE "%'.$params['keyword'].'%")');	
		// }
		// if(isset($params['category_id']) && $params['category_id']){
		// 	$this->db->where("FIND_IN_SET(".$params['category_id'].",products.category_ids) !=", 0);	
		// }
		if(isset($params['startEnd']) && $params['startEnd']){
			//echo 'hi';die;
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('products.created_at >=',$st);
			  $this->db->where('products.created_at <=',$et);
		}

	
		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		}else{
			$this->db->order_by('products.ordering','DESC');
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

	public function getDetails($id=''){
		$this->db->select('products.*,categories.name as cat_name');
		$this->db->from('products');
		$this->db->join('categories','categories.id = products.category_ids','left');
		$this->db->where('products.id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getDataByID($id=''){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	



}
?>