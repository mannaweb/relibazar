<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_settings_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getSettings(){
		return $this->db->get_where('site_settings',array('id'=>1))->row();
	}

	public function saveData($data=array()){
		$this->db->where('id',1)->update('site_settings',$data);
		return array('status'=>1,'msg'=>'Updated successfully.');
	}

	


}
?>