<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('products','add-product','edit-product');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/products_model');
		$this->perPage = 10;
	}

	public function index(){
		$data = array('viewPage'=>'products/list','pageTitle'=>'Products','jsFiles'=>array('products','moment.min','daterangepicker.min'),'cssFiles'=>array('daterangepicker'),'activeMenus'=>array('all-products','products'));
		$data['main_cat'] = $this->db->select('id,name')->get_where('categories', array('status'=>1))->result();
		$this->load->view('admin/template/default',$data);
	}


	public function ajaxLoadDiv(){
		$data['ptype'] = $this->input->post('ptype');
		$data['last_id'] = $this->input->post('last_id');
		$returnArr['html'] = $this->load->view('admin/products/ajax_load',$data,true);
        echo json_encode($returnArr);
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
        $totalRec = count($this->products_model->getList($this->input->post() ));

        $config['base_url']    = base_url().'admin/product-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['products'] = $this->products_model->getList($this->input->post(),array('start'=>$offset,'limit'=>$this->perPage));
		
		if( ( $offset + $this->perPage ) < ( $totalRec -1 ) )
        $end = $offset + $this->perPage;
        else
        $end = $totalRec;

		$data['start'] = $offset+1;
		$data['end'] = $end;
		$data['total'] = $totalRec;

		$returnArr['html'] = $this->load->view('admin/products/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/products/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	public function manageProduct($alias=''){
		$data = array('viewPage'=>'products/manage','jsFiles'=>array('products'));
		    $getUser = $this->db->get_where('users',array('id'=>$this->session->userdata('user_id')))->row();
		   //echo '<pre>';print_r($getUser);die;
		    if($getUser->role == 'vendor'){
		    	$data['all_cat'] = $this->db->where_in('id',explode(',', $getUser->category))->get_where('categories', array('status'=>1,'type'=>1))->result();
		    }else{
		    	$data['all_cat'] = $this->db->get_where('categories', array('status'=>1,'type'=>1))->result();
		    }
			
			
			$data['all_sub_cat'] = $this->db->get_where('categories', array('status'=>1,'type'=>2))->result();
		$data['business_types'] = $this->db->get_where('business_types', array('status'=>1))->result();
		
		if($alias){
			$data['pageTitle'] = 'Edit Product';
			$data['activeMenus'] = array('all-products','edit-product');
			$data['products'] = $this->products_model->getData($alias);
			$data['price'] = json_decode($data['products']->selling_price);
			//echo '<pre>';print_r(json_decode($data['products']->selling_price));die;
		} else {
			$data['pageTitle'] = 'Add Product';
			$data['activeMenus'] = array('all-products','add-product');
			$data['products'] = array();
		}
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){
		$data = $this->input->post();

		$mainArray = array();
		if($data['ptype'] == 2){

		if($data['weight']){
			foreach ($data['weight'] as $key => $value) {
				$mainArray['weight'][] = $value;
			    $mainArray['price'][]= $data['price'][$key];
			     $mainArray['product_price'][]= $data['product_price'][$key];
				 $mainArray['stock'][]= $data['stock'][$key];
			}

			$encodeJson =  json_encode($mainArray);
			$data['selling_price'] = $encodeJson;
			

		} }


		if($data['ptype'] == 3){

		if($data['piece']){
			foreach ($data['piece'] as $key => $value) {
				$mainArray['piece'][] = $value;
				  $mainArray['product_price'][]= $data['product_price'][$key];
			    $mainArray['price'][]= $data['price'][$key];
			    $mainArray['stock'][]= $data['stock'][$key];
				
			}

			$encodeJson =  json_encode($mainArray);
			$data['selling_price'] = $encodeJson;
			

		} }
$data['product_type'] = $data['ptype'];
		//echo '<pre>';print_r($mainArray);die;
      unset($data['product_price']);
           unset($data['stock']);
		   unset($data['piece']);
			unset($data['ptype']);
			unset($data['weight']);
			unset($data['price']);
			unset($data['primary_id']);


		

		$user_id = $this->session->userdata('user_id');

		if(isset($data['category']) && !empty($data['category'])){			
			$data['category_ids'] = implode(',', $data['category']);
		}

		if(isset($data['subcategory']) && !empty($data['subcategory'])){			
			$data['subcategory_ids'] = implode(',', $data['subcategory']);
		}
		unset($data['subcategory']);
		$data['long_description'] = $data['description'];
		//echo '<pre>';print_r($data);die();
		
		$uploadFile = $this->doUpload($_FILES,$data['logo']);

		if($uploadFile['status'] == 1){
			$data['image'] = ($uploadFile['logo'])?$uploadFile['logo']:$data['logo'];
			if($data['id']){
				$data['modified_by'] = $this->session->userdata('user_id');
				$alaisCheckWhere = array('id != '=>$data['id'],'slug'=>$data['slug']);
			}else{
				$data['created_by'] = $this->session->userdata('user_id');
				$alaisCheckWhere = array('slug'=>$data['slug']);
			}
			$aliasCheck = $this->products_model->aliasCheck($alaisCheckWhere);
			if($aliasCheck['status'] == 1){
				$return = $this->products_model->saveData($data);
			}else{
				$return = $aliasCheck;
			}
		}else{
			$return = $uploadFile;
		}
		echo json_encode($return);
	}


	public function doUpload($FILES,$logo){
		if($FILES['image']['name']){
			$config['upload_path']          = 'uploads/products';
			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}

			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 100000;
			$config['max_width']            = 200000;
			$config['max_height']           = 100000;
			$config['file_name'] 			= 'product_'.rand(10,99).time();

			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('image')){
				return array('status'=>2,'msg'=>$this->upload->display_errors()); 
			}else{
				@unlink('./uploads/post/'.$logo);
				return array('status'=>1,'logo'=>$this->upload->data()['file_name']);
			}
		} else {
			return array('status'=>1,'logo'=>'');
		}

	}

	public function statusChange(){
		$return = $this->products_model->statusChange($this->input->post());
		echo json_encode($return);
	}

	public function deleteData(){
		$return = $this->products_model->deleteData($this->input->post());
		echo json_encode($return);
	}
	
	public function changeFeaturedProduct(){
		$return = $this->products_model->changeFeaturedProduct($this->input->post());
		echo json_encode($return);
	}

	public function saveOrdering(){
		$return = $this->products_model->saveOrdering($this->input->post());
		echo json_encode($return);
	}


}
?>