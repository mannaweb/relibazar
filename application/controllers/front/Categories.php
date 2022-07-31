<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('front/categories_model');
		$this->load->library('front_ajax_pagination');
		$this->perPage = 30;
	}

	public function index(){
		$data = array('viewPage'=>'categories/list','pageTitle'=>'Singla sweets category list page','activeMenus'=>array('categories'),'jsFiles'=>array('categories'));
		$this->load->view('front/template/default',$data);
	}

	public function ajaxPaginationSearch(){
        $returnArr = array();
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $totalRec = count($this->categories_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'categories/search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->front_ajax_pagination->initialize($config);

		$data['catlist'] = $this->categories_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );
		//print_r($data['catlist']);die;
		$returnArr['html'] = $this->load->view('front/categories/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('front/categories/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	public function getCategories($alias=''){
		$data = array('viewPage'=>'categories/details','activeMenus'=>array('categories'),'jsFiles'=>array('categories','fancybox/jquery.fancybox.min'),'cssFiles'=>array('js/fancybox/jquery.fancybox.min'));
		$data['catDetails'] = $this->categories_model->getDetails($alias);
		if($data['catDetails']){
			$data['pageTitle'] = 'Singla sweets category details page | '.$data['catDetails']->name;
			$data['username'] = getUserDetails($this->session->userdata('id'),'name');
			$data['userimage'] = getUserDetails($this->session->userdata('id'),'profile');
			$this->load->view('front/template/default',$data);
		}else{
			redirect('/');
		}
		
	}

	
}
?>