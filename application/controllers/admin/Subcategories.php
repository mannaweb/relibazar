<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategories extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('subcategories','add-category','edit-category');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/subcategories_model');
		$this->perPage = 10;
	}

	public function index(){

		$data = array('viewPage'=>'subcategories/list','pageTitle'=>'subcategories','cssFiles'=>array('daterangepicker'),'jsFiles'=>array('subcategories','moment.min','daterangepicker.min'),'activeMenus'=>array('all-subcategories','subcategories'));
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
        $totalRec = count($this->subcategories_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'admin/category-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['categories'] = $this->subcategories_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );
		if( ( $offset + $this->perPage ) < ( $totalRec -1 ) )
        $end = $offset + $this->perPage;
        else
        $end = $totalRec;

		$data['start'] = $offset+1;
		$data['end'] = $end;
		$data['total'] = $totalRec;
       // print_r($data['subcategories']);die;
		$returnArr['html'] = $this->load->view('admin/subcategories/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/subcategories/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	public function manageCategory($alias=''){

		$data = array('viewPage'=>'subcategories/manage','jsFiles'=>array('subcategories'));
		$data['maincategories'] = $this->db->get_where('categories',array('type'=>1,'status'=>1))->result();
		//print_r($data['categories']);die;
		if($alias){
			$data['pageTitle'] = 'Edit Sub Category';
			$data['activeMenus'] = array('all-subcategories','edit-category');
			$data['categories'] = $this->subcategories_model->getData($alias);
		} else {
			$data['pageTitle'] = 'Add Sub Category';
			$data['activeMenus'] = array('all-subcategories','add-category');
			$data['categories'] = array();
		}
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){

		$data = $this->input->post();
		$data['type'] = 2;
		//print_r($data);die;
		$uploadFile = $this->doUpload($_FILES,$data['image']);

		if($uploadFile['status'] == 1){
			$data['image'] = ($uploadFile['logo'])?$uploadFile['logo']:$data['image'];
			if($data['id']){
				$data['modified_by'] = $this->session->userdata('user_id');
				$alaisCheckWhere = array('id != '=>$data['id'],'slug'=>$data['slug']);
			}else{
				$data['created_by'] = $this->session->userdata('user_id');
				$alaisCheckWhere = array('slug'=>$data['slug']);
			}
			$aliasCheck = $this->subcategories_model->aliasCheck($alaisCheckWhere);
			if($aliasCheck['status'] == 1){
				$return = $this->subcategories_model->saveData($data);
			}else{
				$return = $aliasCheck;
			}
		}else{
			$return = $uploadFile;
		}
		echo json_encode($return);
	}


	public function doUpload($FILES,$logo){

		if($FILES['img']['name']){

			$config['upload_path']          = 'uploads/category';

			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}

			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 10000;
			$config['max_width']            = 20000;
			$config['max_height']           = 10000;
			$config['file_name'] 			= time().$FILES['img']['name'];

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('img')){
				return array('status'=>2,'msg'=>$this->upload->display_errors()); 
			}else{
				@unlink($logo);
				return array('status'=>1,'logo'=>$config['upload_path'].'/' . $this->upload->data()['file_name']);
			}
		} else {

			return array('status'=>1,'logo'=>'');
		}

	}

	public function statusChange(){

		$return = $this->subcategories_model->statusChange($this->input->post());
		echo json_encode($return);
	}



	public function deleteData(){

		$return = $this->subcategories_model->deleteData($this->input->post());
		echo json_encode($return);
	}

	public function changeFeaturedCategory(){
		$return = $this->subcategories_model->changeFeaturedCategory($this->input->post());
		echo json_encode($return);
	}

	public function AliasManage(){
		$all_data = $this->input->post();
		$alias = $this->format_uri($all_data['title']);
		$return['alias'] = $alias;
		echo json_encode($return);        
	}

	function format_uri( $string, $separator = '-' ){
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array( '&' => 'and', "'" => '');
        $string = mb_strtolower( trim( $string ), 'UTF-8' );
        $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
        $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }

    public function saveOrdering(){
		$return = $this->subcategories_model->saveOrdering($this->input->post());
		echo json_encode($return);
	}

}
?>