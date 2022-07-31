<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('reviews');
		$userPermissions = getUserDetails($this->session->userdata('user_id'));		
		$userPermission = json_decode($userPermissions->access_management, true);
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/reviews_model');
		$this->perPage = 10;
	}

	public function index(){

		$data = array('viewPage'=>'reviews/list','pageTitle'=>'Reviews','jsFiles'=>array('reviews','moment.min','daterangepicker.min'),'cssFiles'=>array('daterangepicker'),'activeMenus'=>array('all-reviews','reviews'));

		$data['users'] =  $this->db->select('users.name,users.id')->get_where('users', array('role !='=>'admin'))->result();

		$data['listings'] = $this->db->select('listings.id,JSON_UNQUOTE(JSON_EXTRACT(listings.title, "$.en")) as title')->get('listings')->result();

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
        $totalRec = count($this->reviews_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'admin/reviews-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['reviews'] = $this->reviews_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );

		$returnArr['html'] = $this->load->view('admin/reviews/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/reviews/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	
	public function manageReview($id=''){
		
		$data = array('viewPage'=>'reviews/manage','jsFiles'=>array('reviews'));		
			$data['pageTitle'] = 'Edit How It Works';
			$data['activeMenus'] = array('all-reviews','edit-reviews');
			$data['reviews'] = $this->reviews_model->getData($id);		
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){

		$data = $this->input->post();
		$return = $this->reviews_model->saveData($data);		
		echo json_encode($return);
	}

	public function statusChange(){

		$return = $this->reviews_model->statusChange($this->input->post());
		echo json_encode($return);
	}

}
?>