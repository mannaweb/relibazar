<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

		$this->db->select('id,code,product_ids,discount,discount_type,start_date,end_date,status,created_at');
		$this->db->from('coupons');
		if(isset($params['status']) && $params['status']){
			$this->db->where('coupons.status',$params['status']);	
		}

		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(coupons.code LIKE "%'.$params['keyword'].'%")');	
		}

		if(isset($params['startEnd']) && $params['startEnd']){
			//echo 'hi';die;
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('coupons.end_date >=',$st);
			  $this->db->where('coupons.end_date <=',$et);
		}

	
		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('coupons.id','DESC');
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

		return $this->db->get_where('coupons',array('id'=>$id))->row();
	}

	public function saveData($data=array()){
		if($data['id']){

			$id = $data['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
			unset($data['id']);
			$this->db->where('id',$id)->update('coupons',$data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('coupons',$data);
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	public function codeCheck($where=array()){

		$return = $this->db->get_where('coupons',$where)->num_rows();
		if($return > 0){
			return array('status'=>2,'msg'=>'Coupon Code already exists.');
		} else {
			return array('status'=>1);
		}
	}

	public function statusChange($data=array()){
		$this->db->where('id',$data['id'])->update('coupons',array('status'=>$data['status']));
		return array('status'=>1,'msg'=>'Status changed successfully.');
	}

	public function deleteData($data=array()){

		if($data['ids']){
			$ids = explode(',', $data['ids']);

			$getData = $this->db->where_in('id',$ids)->get('coupons')->result();
			if($getData){
				foreach ($getData as $key => $value) {
					@unlink($value->logo);
				}
				
			}
			$this->db->where_in('id',$ids)->delete('coupons');
			
			return array('status'=>1,'msg'=>'Deleted successfully.');
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}



}
?>