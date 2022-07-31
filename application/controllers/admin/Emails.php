<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emails extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('emails','edit-email');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/emails_model');
		$this->perPage = 10;
	}

	public function index(){

		$data = array('viewPage'=>'emails/list','pageTitle'=>'Email Templates','jsFiles'=>array('emails','moment.min','daterangepicker.min'),'cssFiles'=>array('daterangepicker'),'activeMenus'=>array('settings','emails'));
		$this->load->view('admin/template/default',$data);
	}

	public function ajaxPaginationSearch(){

        $returnArr = array();
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $this->perPage = $this->input->post('perPage');
        $totalRec = count($this->emails_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'admin/admin-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['emails'] = $this->emails_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );

		$returnArr['html'] = $this->load->view('admin/emails/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/emails/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	public function manageEmail($id=''){
		$data = array('viewPage'=>'emails/manage','jsFiles'=>array('emails'));
		if($id){
			$data['pageTitle'] = 'Edit Email';
			$data['activeMenus'] = array('settings','edit-email');
			$data['emails'] = $this->emails_model->getData($id);
		} else {
			$data['pageTitle'] = 'Add Email';
			$data['activeMenus'] = array('settings','add-email');
			$data['emails'] = array();
		}
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){

		$data = $this->input->post();
		if($data['id']){
	         $data['modified_by'] = $this->session->userdata('user_id');
		}else{
			$data['created_by'] = $this->session->userdata('user_id');
		}
		$return = $this->emails_model->saveData($data);
			
		
		echo json_encode($return);
	}

	
	

	

}
?>