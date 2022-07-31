<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('front/categories_model');
		$this->load->model('front/products_model');
		$this->load->library('front_ajax_pagination');
		$this->perPage = 15;
	}

	public function index(){
		if(get_cookie('session_id') !=''){
			$data = array('viewPage'=>'products/list','pageTitle'=>'Singla sweets category list page','activeMenus'=>array('products'),'jsFiles'=>array('products'));
			$data['category_info'] = $this->categories_model->getList();
			//echo '<pre>';print_r($data['category_info']);die();
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

        $totalRec = count($this->products_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'products/search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->front_ajax_pagination->initialize($config);

		$data['products'] = $this->products_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage));
		$returnArr['html'] = $this->load->view('front/products/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('front/products/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	public function productDetails(){
		$data = $this->input->post();
		$data['productDetails'] = $this->products_model->getDetails($data['product_id']);
		//print_r($data['productDetails']);die;
		$expl = explode(',',$data['productDetails']->category_ids);
		foreach ($expl as $key => $value) {
			$cats = $this->db->get_where('categories',array('id'=>$value))->row();
			$cat_name[] = $cats->name;
		}
         $data['impCat'] = implode(',', $cat_name);
        // echo $impCat;die;
		$data['productgalery'] = $this->db->get_where('product_galleries',array('product_id'=>$data['product_id']))->result();
		$returnArr['html'] = $this->load->view('front/products/ajax_details',$data,true);
		echo json_encode($returnArr);
		
	}



	
}
?>