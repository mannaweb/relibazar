<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiries extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('enquiries');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/enquiry_model');
		$this->load->model('admin/products_model');
		$this->load->model('admin/users_model');
		$this->perPage = 10;
	}

	public function index(){

		$data = array('viewPage'=>'enquiries/list','pageTitle'=>'Enquiries','cssFiles'=>array('daterangepicker'),'jsFiles'=>array('enquiries','moment.min','daterangepicker.min'),'activeMenus'=>array('all-enquiries','all-products','enquiries'));
		 $data['products'] = $this->products_model->getList();
		$data['users'] = $this->users_model->getList();
		 // echo '<pre>';print_r($data['users']);die;
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
        $totalRec = count($this->enquiry_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'admin/enquiry-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['enquiries'] = $this->enquiry_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );
       
        //print_r( $data['products']);die;
		$returnArr['html'] = $this->load->view('admin/enquiries/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/enquiries/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	
public function deleteData(){

		$return = $this->enquiry_model->deleteData($this->input->post());
		echo json_encode($return);
	}
	

	

	

}
?>