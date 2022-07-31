<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){
		$this->db->select('id,category_ids,name,slug,regular_price,selling_price,stock_status,status,featured,image,ordering,created_at,product_type,tax');
		$this->db->from('products');
		$this->db->where('deleted_at',NULL);
		if(isset($params['status']) && $params['status']){
			$this->db->where('products.status',$params['status']);	
		}
		if(isset($params['category']) && $params['category']){
			$this->db->where("FIND_IN_SET(".$params['category'].",products.category_ids) !=", 0);	
		}
		if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			  $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			  $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('products.created_at >=',$st);
			  $this->db->where('products.created_at <=',$et);
		}

		if($this->session->userdata('role')== 'vendor'){
			$this->db->where('products.created_by',$this->session->userdata('user_id'));
		}
		
		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(products.name LIKE "%'.$params['keyword'].'%")');	
		}

		if(isset($params['featured']) && $params['featured']){
			$this->db->where('products.featured',$params['featured']);	
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('products.ordering','ASC');
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
		return $this->db->get_where('products',array('slug'=>$alias))->row();
	}

	public function saveData($data=array()){
	    
		if(isset($data['category'])){
			unset($data['category']);
		}
		if(isset($data['logo'])){
			unset($data['logo']);
		}
		if(isset($data['description'])){
			unset($data['description']);
		}	
        //print_r($data);die;
		if($data['id']){
			$id = $data['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
			unset($data['id']);
			$this->db->where('id',$id)->update('products',$data);
		}else{
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('products',array('name'=>$data['name'],'slug'=>$data['slug'],'sku'=>$data['sku'],'short_description'=>$data['short_description'],'stock_status'=>$data['stock_status'],'tax_status'=>$data['tax_status'],'regular_price'=>$data['regular_price'],'tax'=>$data['tax'],'selling_price'=>$data['selling_price'],'product_type'=>$data['product_type'],'category_ids'=>$data['category_ids'],'long_description'=>$data['long_description'],'image'=>$data['image'],'created_by'=>$data['created_by'],'created_at'=>date('Y-m-d h:i:s')));
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	public function aliasCheck($where=array()){
		$return = $this->db->get_where('products',$where)->num_rows();
		if($return > 0){
			return array('status'=>2,'msg'=>'Category alias already exists.');
		} else {
			return array('status'=>1);
		}
	}

	public function statusChange($data=array()){
		$updateData = $this->db->where('id',$data['id'])->update('products',array('status'=>$data['status']));
		return array('status'=>1,'msg'=>'Status changed successfully.');
	}

	public function deleteData($data=array()){
		if($data['ids']){
			$ids = explode(',', $data['ids']);
			$getData = $this->db->where_in('id',$ids)->get('products')->result();
			// if($getData){
			// 	foreach ($getData as $key => $value) {
			// 		@unlink('./uploads/products/'.$value->image);
			// 		$getgallery = $this->db->where('product_id',$value->id)->get('product_galleries')->result();
			// 		if($getgallery){
			// 			foreach ($getgallery as $key1 => $value1) {
			// 				@unlink('./uploads/products/gallery/'.$value1->image);
			// 				@unlink('./uploads/post/gallery/150x150/'.$value1->image);
			// 			}
			// 		}

			// 	}
				
			// }
			//$this->db->where_in('post_id',$ids)->delete('gallery');
			$this->db->where_in('id',$ids)->update('products',array('deleted_by'=>$this->session->userdata('user_id'),'deleted_at'=>date('Y-m-d h:i:s')));
			return array('status'=>1,'msg'=>'Deleted successfully.');
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}
	
	public function changeFeaturedProduct($data=array()){
		$this->db->where('id',$data['id'])->update('products',array('featured'=>$data['featured']));
		return array('status'=>1,'msg'=>'product featured successfully.');
	}

	public function saveOrdering($data=array()){
		if($data['ids']){
			foreach ($data['ids'] as $key => $value) {
				$this->db->where('id',$value)->update('products',array('ordering'=>$data['ordering'][$key]));
			}
			return array('status'=>1,'msg'=>'Updated successfully.');
		}
	}


}
?>