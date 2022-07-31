<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seoes extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('seo');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/seoes_model');
		$this->perPage = 10;
	}

	

	public function SeoesManage(){
		$data = array('viewPage'=>'seoes/manage','jsFiles'=>array('seoes'));		
		
		$type = $this->uri->segment(3);
		$type_id = $this->uri->segment(4);

		$pagetitle = '';
		if($type == 'categories'){
			$pagetitle = ' for '.getCatImage($type_id,'name').' category';
		} else if($type == 'subcategories'){
			$pagetitle = ' for '.getCatImage($type_id,'name').' sub category';
		} else if($type == 'blog'){
			$pagetitle = ' for '.getBlogImage($type_id,'title').' blog';
		} else if($type == 'pages'){
			$pagetitle = ' for '.getPageDetails($type_id,'title').' page';
		}
		$data['breadcrumb'] = $pagetitle;
		$data['type'] = $type;
		$data['type_id'] = $type_id;
		$data['seoes'] = $this->db->get_where('seo',array('type_id'=>$type_id,'type'=>$type))->row();
		if($data['seoes']){
			$data['pageTitle'] = 'Edit SEO';
			$data['activeMenus'] = array();
		} else {
			$data['pageTitle'] = 'Add SEO';
			$data['activeMenus'] = array();
			$data['seoes'] = array();
		}
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){

		$data = $this->input->post();

		if($data['id']){
          $data['modified_by'] = $this->session->userdata('user_id');
          $data['modified_at'] = date('Y-m-d H:i:s');
		}else{
          $data['created_by'] = $this->session->userdata('user_id');
          $data['created_at'] = date('Y-m-d H:i:s');
		}
		$return = $this->seoes_model->saveData($data);
			
		echo json_encode($return);
	}

}
?>