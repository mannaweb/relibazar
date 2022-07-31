<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallerys_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function saveData($data=array()){
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('gallery',$data);
		

		return array('status'=>1,'msg'=>'Data successfully saved','id'=>$this->db->insert_id());
	}

	public function RemoveData($data=array()){

		$getData = $this->db->where('id',$data['id'])->get('gallery')->row();
		if($getData){
			@unlink('./uploads/post/gallery/'.$getData->image);
			@unlink('./uploads/post/gallery/150x150/'.$getData->image);
		}

		$this->db->where('id',$data['id'])->delete('gallery');
		return array('status'=>1,'msg'=>'Deleted successfully.');		
	}

}
?>