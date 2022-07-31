<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stores extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('stores','add-stores','edit-store');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/stores_model');
		$this->perPage = 10;
	}

	public function index(){

		$data = array('viewPage'=>'stores/list','pageTitle'=>'Stores','cssFiles'=>array('daterangepicker'),'jsFiles'=>array('stores','moment.min','daterangepicker.min'),'activeMenus'=>array('all-stores','stores'));
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
        $totalRec = count($this->stores_model->getList($this->input->post()));

        $config['base_url']    = base_url().'admin/store-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['stores'] = $this->stores_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );

		$returnArr['html'] = $this->load->view('admin/stores/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/stores/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	public function manageStore($id=''){

		$data = array('viewPage'=>'stores/manage','cssFiles'=>array('daterangepicker'),'jsFiles'=>array('stores','moment.min','daterangepicker.min'));
		if($id){
			$data['pageTitle'] = 'Edit Store';
			$data['activeMenus'] = array('all-stores','edit-store');
			$data['stores'] = $this->stores_model->getData($id);
		} else {
			$data['pageTitle'] = 'Add Store';
			$data['activeMenus'] = array('all-stores','add-store');
			$data['stores'] = array();
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
			
		$return = $this->stores_model->saveData($data);
		echo json_encode($return);
	}


	

	public function statusChange(){

		$return = $this->stores_model->statusChange($this->input->post());
		echo json_encode($return);
	}



	public function deleteData(){

		$return = $this->stores_model->deleteData($this->input->post());
		echo json_encode($return);
	}

	

	

	

}
?>