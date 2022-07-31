<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategories_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

		$this->db->select('id,name,slug,status,ordering,featured,created_at');
		$this->db->from('categories');
		if(isset($params['status']) && $params['status']){
			$this->db->where('categories.status',$params['status']);	
		}

		if(isset($params['featured']) && $params['featured']){
			$this->db->where('categories.featured',$params['featured']);	
		}

		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(categories.name LIKE "%'.$params['keyword'].'%")');	
		}

		if(isset($params['startEnd']) && $params['startEnd']){
			//echo 'hi';die;
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('categories.created_at >=',$st);
			  $this->db->where('categories.created_at <=',$et);
		}

	     $this->db->where('categories.type',2);
		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('categories.ordering','ASC');
		}


		if($this->session->userdata('role')== 'vendor'){
			$this->db->where('categories.created_by',$this->session->userdata('user_id'));
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

	public function getData($alias=''){

		return $this->db->get_where('categories',array('slug'=>$alias))->row();
	}

	public function saveData($data=array()){
	    //print_r($data);die;
		if($data['id']){

			$id = $data['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
			unset($data['id']);
			$this->db->where('id',$id)->update('categories',$data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('categories',array('image'=>$data['image'],'name'=>$data['name'],'root_id'=>$data['root_id'],'type'=>2,'slug'=>$data['slug'],'short_description'=>$data['short_description'],'long_description'=>$data['long_description'],'created_by'=>$data['created_by']));
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	public function aliasCheck($where=array()){
		$return = $this->db->get_where('categories',$where)->num_rows();
		if($return > 0){
			return array('status'=>2,'msg'=>'Category alias already exists.');
		} else {
			return array('status'=>1);
		}
	}

	public function statusChange($data=array()){
		$this->db->where('id',$data['id'])->update('categories',array('status'=>$data['status']));
		return array('status'=>1,'msg'=>'Status changed successfully.');
	}

	public function deleteData($data=array()){

		if($data['ids']){
			$ids = explode(',', $data['ids']);

			$getData = $this->db->where_in('id',$ids)->get('categories')->result();
			if($getData){
				foreach ($getData as $key => $value) {
					@unlink($value->logo);
				}
				
			}
			$this->db->where_in('id',$ids)->delete('categories');
			
			return array('status'=>1,'msg'=>'Deleted successfully.');
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}

	public function saveOrdering($data=array()){
		if($data['ids']){
			foreach ($data['ids'] as $key => $value) {
				$this->db->where('id',$value)->update('categories',array('ordering'=>$data['ordering'][$key]));
			}
			return array('status'=>1,'msg'=>'Updated successfully.');
		}
	}

	public function changeFeaturedCategory($data=array()){
		$this->db->where('id',$data['id'])->update('categories',array('featured'=>$data['featured']));
		return array('status'=>1,'msg'=>'category featured successfully.');
	}



}
?>