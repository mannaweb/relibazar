<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('coupons','add-coupon','edit-coupon');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/coupons_model');
		$this->perPage = 10;
	}

	public function index(){

		$data = array('viewPage'=>'coupons/list','pageTitle'=>'Coupons','cssFiles'=>array('daterangepicker'),'jsFiles'=>array('coupons','moment.min','daterangepicker.min'),'activeMenus'=>array('all-coupons','all-products','coupons'));
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
        $totalRec = count($this->coupons_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'admin/coupon-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['coupons'] = $this->coupons_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );

		$returnArr['html'] = $this->load->view('admin/coupons/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/coupons/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	public function manageCoupon($id=''){

		$data = array('viewPage'=>'coupons/manage','cssFiles'=>array('daterangepicker'),'jsFiles'=>array('coupons','moment.min','daterangepicker.min'));
		$data['all_pro'] = $this->db->get_where('products',array('status'=>1))->result();
		if($id){
			$data['pageTitle'] = 'Edit Coupon';
			$data['activeMenus'] = array('all-coupons','edit-coupon');
			$data['coupons'] = $this->coupons_model->getData($id);
		} else {
			$data['pageTitle'] = 'Add Coupon';
			$data['activeMenus'] = array('all-coupons','add-coupon');
			$data['coupons'] = array();
		}
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){
        $data = $this->input->post();
        if(isset($data['product']) && !empty($data['product'])){		
        	if($data['product'][0] == 0){
               $data['product_ids'] = 0;
        	}else{
        		$data['product_ids'] = implode(',', $data['product']);
        	}
			
			//print_r($data['product_ids']);die;
		}
		if(isset($data['end_date']) && !empty($data['end_date'])){			
			$data['end_date'] =  date('Y-m-d',strtotime($data['end_date'])).' 00:00:00';

		}
         unset($data['product']);
        if($data['id']){
				$data['modified_by'] = $this->session->userdata('user_id');
				$codeCheckWhere = array('id != '=>$data['id'],'code'=>$data['code']);
			}else{
				$data['created_by'] = $this->session->userdata('user_id');
				$codeCheckWhere = array('code'=>$data['code']);
			}
			$codeCheck = $this->coupons_model->codeCheck($codeCheckWhere);
			if($codeCheck['status'] == 1){
				$return = $this->coupons_model->saveData($data);
			}else{
				$return = $codeCheck;
			}
		
		echo json_encode($return);
	}


	

	public function statusChange(){

		$return = $this->coupons_model->statusChange($this->input->post());
		echo json_encode($return);
	}



	public function deleteData(){

		$return = $this->coupons_model->deleteData($this->input->post());
		echo json_encode($return);
	}

	

	

	

}
?>