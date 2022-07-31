<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallerys extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		}
		$this->load->model('admin/gallerys_model');
		
	}

	public function manageGallery($alias=''){

		$data = array('viewPage'=>'gallerys/manage','cssFiles'=>array('dropzone.min'),'jsFiles'=>array('gallerys','dropzone.min'));
		$data['post_type'] = $this->uri->segment(3);
		$data['alias'] = $alias;
		$post_id = getPostDetailsByAlias($alias,$data['post_type'],'id');
		$data['post_id'] = $post_id;
			$data['pageTitle'] = 'Gallery page';
			$data['activeMenus'] = array();
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){

		$data = $this->input->post();
		$data['created_by'] = $this->session->userdata('user_id');
		$data['created_at'] = date('Y-m-d H:i:s');
		
		$uploadFile = $this->doUpload($_FILES,$_FILES['file']['name']);
		if($uploadFile['status'] == 1){
			$data['image'] = ($uploadFile['file'])?$uploadFile['file']:$_FILES['file']['name'];
			$data['file_size'] = ($uploadFile['file_size'])?$uploadFile['file_size']:'';
			$data['type '] = 1;
			$data['original_name'] = $_FILES['file']['name'];
				$return = $this->gallerys_model->saveData($data);
		
		} else {
			$return = $uploadFile;
		}
		echo json_encode($return);
	}

	public function GateData(){
		$post_type = $this->uri->segment(3);
		$post_id = $this->uri->segment(4);
		$value = $this->db->get_where('gallery',array('post_id'=>$post_id,'post_type' =>$post_type,'type'=>1))->result_array();
		echo json_encode($value);
	}

	public function RemoveData(){
		$data = $this->input->post();
		$return = $this->gallerys_model->RemoveData($data);
		echo json_encode($return);
	}

	
	public function doUpload($FILES,$file){
		if($FILES['file']['name']){

			$config['upload_path']          = 'uploads/post/gallery';

			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}
			if(!is_dir('uploads/post/gallery/150x150')){
				mkdir('uploads/post/gallery/150x150',0777,TRUE);
			}

			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 10000;
			$config['max_width']            = 20000;
			$config['max_height']           = 10000;
			$config['file_name'] 			= time().$FILES['file']['name'];

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('file')){
				return array('status'=>2,'msg'=>$this->upload->display_errors()); 
			}else{
				
				@unlink('uploads/post/gallery/150x150/'.$file);

				
				
					$this->load->library('image_lib');
				    $config['image_library'] = 'GD2';
				    $config['source_image'] = 'uploads/post/gallery/'.$this->upload->data()['file_name'];
				    $config['maintain_ratio'] = TRUE;
				    $config['width']     = '150';
				    $config['height']   = '150';
				    $config['new_image']   = 'uploads/post/gallery/150x150/'.$this->upload->data()['file_name'];

				    $this->image_lib->clear();
				    $this->image_lib->initialize($config);
				    $this->image_lib->resize();
				return array('status'=>1,'file_size'=>$this->upload->data()['file_size'],'file'=>$this->upload->data()['file_name']);
			}
		} else {

			return array('status'=>1,'file'=>'');
		}

	}


}
?>