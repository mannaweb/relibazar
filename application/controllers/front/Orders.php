<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('front/orders_model');
		$this->load->library('front_ajax_pagination');
		$this->perPage = 15;
	}

	public function index(){

		if(get_cookie('session_id') !=''){
			$data = array('viewPage'=>'orders/list','pageTitle'=>'Singla sweets Orders','activeMenus'=>array('orders'),'cssFiles'=>array('css/daterangepicker'),'jsFiles'=>array('orders','moment.min','daterangepicker.min'));
			$data['order_status'] = $this->db->get_where('order_status',array('status'=>1))->result();
			$this->load->view('front/template/default',$data);
	   }else{
	   	 redirect(base_url());
	   }
	}

	public function ajaxPaginationSearch(){
        $returnArr = array();
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $totalRec = count($this->orders_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'orders/search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->front_ajax_pagination->initialize($config);

		$data['orders'] = $this->orders_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage));
		$returnArr['html'] = $this->load->view('front/orders/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('front/orders/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}





	
}
?>