<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitesettings extends CI_Controller {
	public function __construct(){
		parent::__construct();

		$urlPermission = array('site-settings');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}		
		$this->load->model('admin/site_settings_model');
	}

	public function manageSettings(){
		$data = array('viewPage'=>'site-settings/manage','jsFiles'=>array('site-settings'),'pageTitle'=>'Site Settings','activeMenus'=>array('settings','site-settings'));
		$data['social_logins'] = $this->db->get_where('social_links',array('status'=>1))->result();
		$data['settings_info'] = $this->site_settings_model->getSettings();
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){
		$data = $this->input->post();
		
		$social_logins = $this->db->get_where('social_links',array('status'=>1))->result();
		$social_links = array();
		if($social_logins){
			foreach($social_logins as $val){
				$social_links[$val->code] = $data[$val->code];
				unset($data[$val->code]);
			}
		}
		$data['social_links'] = ($social_links)?json_encode($social_links):NULL;
		$data['modified_by'] = $this->session->userdata('user_id');
		$data['modified_at'] = date('Y-m-d H:i:s');
		$uploadFile = $this->doUpload($_FILES,$data['logo']);
		if($uploadFile['status'] == 1){
			$data['logo'] = ($uploadFile['logo'])?$uploadFile['logo']:$data['logo'];
			$return = $this->site_settings_model->saveData($data);
		}else{
			$return = $uploadFile;
		}
		echo json_encode($return);
	}

	public function doUpload($FILES,$logo){
		if($FILES['logo']['name']){
			$config['upload_path']          = 'uploads/settings/logo';
			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 10000;
			$config['max_width']            = 20000;
			$config['max_height']           = 10000;
			$config['file_name'] 			= 'logo';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('logo')){
				return array('status'=>2,'msg'=>$this->upload->display_errors()); 
			}else{
				@unlink($logo);
				return array('status'=>1,'logo'=>$config['upload_path'].'/' . $this->upload->data()['file_name']);
			}
		} else {
			return array('status'=>1,'logo'=>'');
		}

	}


}
?>