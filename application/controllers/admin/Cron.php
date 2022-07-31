<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function remove_data(){
		$tables = array('post','category','pages','faqs','email','banner','gallery','seo','user');
		foreach ($tables as $key => $value) {
			$ids = '';
			$query = $this->db->query("SELECT GROUP_CONCAT(t.id) as id FROM ".$value." as t LEFT JOIN user as u on t.created_by = u.id WHERE t.created_by != '' AND t.created_by IS NOT NULL AND u.demo_admin = 1 AND u.usertype = 'admins'");
			$result = $query->row();
			if(isset($result->id) && !empty($result->id)){
				$ids = explode(',', $result->id);
				$delete = $this->db->where_in('id',$ids)->delete($value);
			}
		}
	}
}
?>