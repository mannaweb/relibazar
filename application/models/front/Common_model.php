<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	function getPagesDetailsByAlias($slug='/',$column='id'){    

		$this->db->from('pages');
		$this->db->select($column);
		$this->db->where('slug',$slug);
		$query = $this->db->get();
		$row = $query->result_array();
		if($row){
			return $row[0][$column];	
		}

	}

	function getBanner($array=array()){    

		$this->db->from('banners');
		$this->db->select('title,description,image');
		if(isset($array['type']) && $array['type']){
			$this->db->where('banners.type',$array['type']);
		}
		if(isset($array['page_type_id']) && $array['page_type_id']){
			$this->db->where('banners.type_id',$array['page_type_id']);
		}
		$query = $this->db->get();
		$row = $query->row();
		return $row;
		
	}

	function getSeo($array=array()){

		$this->db->from('seo');
		$this->db->select('title,keywords,description,author');
		if(isset($array['type']) && $array['type']){
			$this->db->where('seo.type',$array['type']);
		}
		if(isset($array['type_id']) && $array['type_id']){
			$this->db->where('seo.type_id',$array['type_id']);
		}
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	

	}

	

}
?>