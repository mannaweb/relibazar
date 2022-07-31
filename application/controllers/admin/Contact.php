<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$urlPermission = array('contacts');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		}else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/contact_model');
		$this->perPage = 10;
	}

	public function index(){
		$data = array('viewPage'=>'contact/list','pageTitle'=>'contact list page','jsFiles'=>array('contact'),'activeMenus'=>array('all-contact','contact'));
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
        $totalRec = count($this->contact_model->getList( $this->input->post() ));
        $config['base_url']    = base_url().'admin/forum-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['contact'] = $this->contact_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );
		//print_r($data['contact']);die;

		
		if( ( $offset + $this->perPage ) < ( $totalRec -1 ))
        $end = $offset + $this->perPage;
        else
        $end = $totalRec;

		$data['start'] = $offset+1;
		$data['end'] = $end;
		$data['total'] = $totalRec;

		$returnArr['html'] = $this->load->view('admin/contact/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/contact/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);
	}





}