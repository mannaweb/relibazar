<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videourls extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		}
		$this->load->model('admin/videourls_model');
	}

	public function manageVideoUrl($alias=''){
		$data = array('viewPage'=>'video-url/manage','jsFiles'=>array('videoUrl'));
		$data['post_type'] = $this->uri->segment(3);
		$data['alias'] = $alias;
		$post_id = getPostDetailsByAlias($alias,$data['post_type'],'id');
		$data['post_id'] = $post_id;
		$data['videoInfo'] = $this->videourls_model->getData($post_id);
		$data['pageTitle'] = 'Video url page';
		$data['activeMenus'] = array();
		$this->load->view('admin/template/default',$data);
	}

	public function ajaxLoadDiv(){
		$data['last_id'] = $this->input->post('last_id');
		$returnArr['html'] = $this->load->view('admin/video-url/ajax_load',$data,true);
        echo json_encode($returnArr);
	}

	public function saveData(){
		$data = $this->input->post();
		
		$data['user_id'] = $this->session->userdata('user_id');
		$allData = $this->videourls_model->getData($data['post_id']);
		if(isset($allData) && !empty($allData)){
			foreach ($allData as $k => $val){
				 if(in_array($val->id, $data['primary_id'])){

	             }else{
	                $this->videourls_model->deleteData($val->id);
	             }
			}
		}

		$result = array();
		if(isset($data['original_name']) && !empty($data['original_name'])){
			foreach ($data['original_name'] as $key => $value){
				if(!empty($data['primary_id'][$key])){
					$result['image'] = $data['image'][$key];
					$result['original_name'] = $value;
					$return = $this->videourls_model->saveData($result,$data['primary_id'][$key]);
				}else{
					$result['type'] = 2;
					$result['post_id'] = $data['post_id'];
					$result['post_type'] = $data['post_type'];
					$result['image'] = $data['image'][$key];
					$result['original_name'] = $value;
					$result['created_at'] = date('Y-m-d h:i:s');
					$return = $this->videourls_model->saveData($result);
				}
				
			}
		}
		echo json_encode($return);

	}
}
?>