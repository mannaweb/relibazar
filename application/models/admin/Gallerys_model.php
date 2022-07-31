<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallerys_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function saveData($data=array()){
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert('product_galleries',$data);
	    return array('status'=>1,'msg'=>'Data successfully saved','id'=>$this->db->insert_id());
	}

	public function RemoveData($data=array()){

		$getData = $this->db->where('id',$data['id'])->get('product_galleries')->row();
		if($getData){
			@unlink('./uploads/products/gallery/'.$getData->image);
			@unlink('./uploads/products/gallery/150x150/'.$getData->image);
		}
		$this->db->where('id',$data['id'])->delete('product_galleries');
		return array('status'=>1,'msg'=>'Deleted successfully.');		
	}

}
?>