<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){
		$this->db->select('orders.*,users.name as username,order_status.title');
		$this->db->from('orders');
		$this->db->where('orders.user_id',$this->session->userdata('id'));
		$this->db->join('order_status','order_status.id = orders.order_status','left');
		$this->db->join('users','users.id = orders.user_id','left');

		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(orders.order_id LIKE "%'.$params['keyword'].'%")');	
		}
        //echo $params['payment_status'];die;
		// if(isset($params['payment_status']) && $params['payment_status']){
		// 	$this->db->where('orders.payment_status',$params['payment_status']);	
		// }
		
		// if(isset($params['order_status']) && $params['order_status']){
		// 	$this->db->where('orders.order_status',$params['order_status']);	
		// }
		if(isset($params['startEnd']) && $params['startEnd']){
			//echo 'hi';die;
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('orders.created_at >=',$st);
			  $this->db->where('orders.created_at <=',$et);
		}

	
		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		}else{
			$this->db->order_by('orders.id','DESC');
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