<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){
		$this->db->select('contact.*');
		$this->db->from('contact');

		

		
		
		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(contact.name LIKE "%'.$params['keyword'].'%")');	
			$this->db->where('(contact.email LIKE "%'.$params['keyword'].'%")');
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('contact.id','DESC');
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
		return $this->db->get_where('contact',array('id'=>$id))->row();
	}

	
}