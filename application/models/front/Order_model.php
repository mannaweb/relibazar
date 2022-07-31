<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getOrderData($order_id=''){
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('order_id',$order_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function updateOrderByOrderId($data=array(),$order_id=''){
		return $this->db->where('order_id',$order_id)->update('orders',$data);
	}

}
?>