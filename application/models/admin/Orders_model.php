<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){
		$this->db->select('orders.order_id,orders.user_id,orders.user_info,orders.total_amount,orders.product_info,orders.order_status,orders.created_at,order_status.title as status_name,orders.payment_status');
		

		$this->db->from('orders');

		

		$this->db->join('order_status','order_status.id = orders.order_status','left');
		$this->db->where('orders.deleted_at',NULL);
		if(isset($params['status']) && $params['status']){
			$this->db->where('orders.order_status',$params['status']);	
		}
		// if(isset($params['product_id']) && $params['product_id']){
		// 	$this->db->where('JSON_UNQUOTE(JSON_EXTRACT(orders.product_info, "$.product_id")) as product_id',$params['product_id']);	
		// }

		if($this->session->userdata('role')== 'vendor'){
			$this->db->where('orders.created_by',$this->session->userdata('user_id'));
		}
		if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			  $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			  $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('orders.created_at >=',$st);
			  $this->db->where('orders.created_at <=',$et);
		}
		if(isset($params['user_id']) && $params['user_id']){
				
		}

		if(isset($params['user_phone']) && $params['user_phone']){
			
		}
		
		if(isset($params['keyword']) && $params['keyword']){
			$this->db->like('orders.order_id',$params['keyword']);	
			$this->db->or_like('orders.total_amount',$params['keyword']);	
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('orders.id','DESC');
		}

		if(array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit'],$limit['start']);
		}elseif(!array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit']);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		//echo '<pre>';print_r($query->result());die;
		return ($query->num_rows() > 0)?$query->result():array();

	}



	public function getOrderUser($email='',$phone=''){
		$this->db->select('orders.order_id,orders.user_id,orders.user_info,orders.total_amount,orders.product_info,orders.order_status,orders.created_at,order_status.title as status_name,orders.payment_status');
		

		$this->db->from('orders');

		
		// if($phone == 1){
		// 	 $this->db->group_by("JSON_ARRAY_APPEND('orders.user_info', '$.contact_number')");
		// }else{
		// 	  $this->db->group_by("JSON_ARRAY_APPEND('orders.user_info', '$.email')");
		// }
     
		$this->db->join('order_status','order_status.id = orders.order_status','left');
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		//echo '<pre>';print_r($query->result());die;
		return ($query->num_rows() > 0)?$query->result():array();

	}

	


}
?>