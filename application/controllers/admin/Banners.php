<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('all-banners','banners','add-banner');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/banners_model');
		$this->perPage = 10;
	}

	public function index(){

		$data = array('viewPage'=>'banners/list','pageTitle'=>'Banners list page','cssFiles'=>array('daterangepicker'),'jsFiles'=>array('banners','moment.min','daterangepicker.min'),'activeMenus'=>array('banners','all-banners'));
		$this->load->view('admin/template/default',$data);
	}


	public function ajaxPaginationSearch(){
    //echo 'hi';die;
        $returnArr = array();
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $this->perPage = $this->input->post('perPage');
        $totalRec = count($this->banners_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'admin/banner-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['banners'] = $this->banners_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );
		if( ( $offset + $this->perPage ) < ( $totalRec -1 ) )
        $end = $offset + $this->perPage;
        else
        $end = $totalRec;

		$data['start'] = $offset+1;
		$data['end'] = $end;
		$data['total'] = $totalRec;
       // print_r($data['banners']);die;
		$returnArr['html'] = $this->load->view('admin/banners/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/banners/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	
	public function BannersManage($id=''){
		$data = array('viewPage'=>'banners/manage','jsFiles'=>array('banners'));
		if($id){

			$data['pageTitle'] = 'Edit Banner';
			$data['activeMenus'] = array('all-banners','edit-banner');
			$data['banners'] = $this->banners_model->getData($id);
		} else {
			$data['pageTitle'] = 'Add Banner';
			$data['activeMenus'] = array('all-banners','add-banner');
			$data['banners'] = array();
		}

		if($this->uri->segment(4)){
			$data['banners'] = $this->banners_model->getPageBanner($this->uri->segment(4));
		}
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){
		$data = $this->input->post();

		if($data['type_id'] == 5){
            $data['type'] = 'home';
		 }else{
		 	$page = $this->db->get_where('pages',array('id'=>$data['type_id']))->row();
            $data['type'] = $page->slug;
		 }
		if($data['id']){
          $data['modified_by'] = $this->session->userdata('user_id');
            $data['modified_at'] = date('Y-m-d H:i:s');
		}else{
          $data['created_by'] = $this->session->userdata('user_id');
          $data['created_at'] = date('Y-m-d H:i:s');
		}
		$uploadFile = $this->doUpload($_FILES,$data['image']);
		if($uploadFile['status'] == 1){
			$data['image'] = ($uploadFile['image'])?$uploadFile['image']:$data['image'];
			$return = $this->banners_model->saveData($data);			
		}else{
			$return = $uploadFile;
		}
		echo json_encode($return);
	}


	public function doUpload($FILES,$image){

		if($FILES['images']['name']){

			$config['upload_path']          = 'uploads/banner';

			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}

			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 10000;
			$config['max_width']            = 20000;
			$config['max_height']           = 10000;
			$config['file_name'] 			= time().$FILES['images']['name'];

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('images')){
				return array('status'=>2,'msg'=>$this->upload->display_errors()); 
			}else{
				@unlink($image);
				return array('status'=>1,'image'=>$config['upload_path'].'/' . $this->upload->data()['file_name']);
			}
		} else {

			return array('status'=>1,'image'=>'');
		}

	}


	public function statusChange(){

		$return = $this->banners_model->statusChange($this->input->post());
		echo json_encode($return);
	}



	public function deleteData(){

		$return = $this->banners_model->deleteData($this->input->post());
		echo json_encode($return);
	}

}
?>