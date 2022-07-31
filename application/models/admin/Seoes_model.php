<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seoes_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	
	public function saveData($data=array()){
		if($data['id']){
			$id = $data['id'];
			unset($data['id']);
			$this->db->where('id',$id)->update('seo',$data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('seo',$data);
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

}
?>