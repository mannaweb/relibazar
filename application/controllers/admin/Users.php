<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('shippers','transporters');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) &&  ( !is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/users_model');
		$this->perPage = 10;
	}

	public function index(){
		$role = 'Users';
		$menu = 'users';
		if(isset($_GET['role']) && $_GET['role'] !=''){
			$role = ucwords($_GET['role']);
			$menu = $_GET['role'];
		}
		
		$data = array('viewPage'=>'users/list','pageTitle'=>$role,'jsFiles'=>array('users','moment.min','daterangepicker.min'),'cssFiles'=>array('daterangepicker'),'activeMenus'=>array('all-users',$menu));
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

        $totalRec = count($this->users_model->getList($this->input->post()));

        $this->perPage = $this->input->post('perPage');
        $config['base_url']    = base_url().'admin/user-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['users'] = $this->users_model->getList($this->input->post(),array('start'=>$offset,'limit'=>$this->perPage));
		//echo "<pre>"; print_r($data['vendors']); die;

		$returnArr['html'] = $this->load->view('admin/users/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/users/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	public function manageUser($id=''){

		$data = array('viewPage'=>'users/manage','jsFiles'=>array('users'));
		if($id){
			$data['pageTitle'] = 'Edit User';
			$data['activeMenus'] = array('all-users','edit-user');			
			$data['users'] = $this->users_model->getData($id);
		} else {
			$data['pageTitle'] = 'Add User';
			$data['activeMenus'] = array('all-users','add-user');
			$data['users'] = array();
		}
		$this->load->view('admin/template/default',$data);
	}

	public function viewUser($id=''){

		$data = array('viewPage'=>'users/view','jsFiles'=>array());
		if($id){
			$data['pageTitle'] = 'View User Details';
			$data['activeMenus'] = array('all-users');			
			$data['users'] = $this->users_model->getData($id);
		} else {
			$data['pageTitle'] = 'View User Details';
			$data['activeMenus'] = array('all-users');
			$data['users'] = array();
		}
		$this->load->view('admin/template/default',$data);
	}

	public function saveData(){

		
		//print_r($admin_id);die;

		$data = $this->input->post();

		
		//print_r($data);die;
		$data['socialnetwork'] = array();
		if($data['facebook']){
			$data['socialnetwork']['facebook'] = $data['facebook'];
		}
		if($data['google']){
			$data['socialnetwork']['google'] = $data['google'];
		}
		if($data['linkedin']){
			$data['socialnetwork']['linkedin'] = $data['linkedin'];
		}
		if($data['twitter']){
			$data['socialnetwork']['twitter'] = $data['twitter'];
		}
		if($data['youtube']){
			$data['socialnetwork']['youtube'] = $data['youtube'];
		}
		if($data['instagram']){
			$data['socialnetwork']['instagram'] = $data['instagram'];
		}
			
		$data['socialnetwork'] = json_encode($data['socialnetwork']);

		$uploadFile = $this->doUpload($_FILES,$data['profile']);
		if($uploadFile['status'] == 1){
			$data['profile'] = ($uploadFile['profile'])?$uploadFile['profile']:$data['profile'];
			if($data['id']){
				$data['modified_by'] = $this->session->userdata('user_id');
				$emailCheckWhere = array('id != '=>$data['id'],'email'=>$data['email']);
			} else {
				$data['created_by'] = $this->session->userdata('user_id');
				$emailCheckWhere = array('email'=>$data['email']);
			}
			$emailCheck = $this->users_model->emailCheck($emailCheckWhere);
			if($emailCheck['status'] == 1){
				$return = $this->users_model->saveData($data);
			} else {
				$return = $emailCheck;
			}
		} else {
			$return = $uploadFile;
		}
		echo json_encode($return);
	}

	public function statusChange(){

		$return = $this->users_model->statusChange($this->input->post());
		echo json_encode($return);
	}

		public function statusPhone(){

		$return = $this->users_model->statusPhone($this->input->post());
		echo json_encode($return);
	}

		public function statusEmail(){

		$return = $this->users_model->statusEmail($this->input->post());
		echo json_encode($return);
	}

	public function doUpload($FILES,$profile){

		if($FILES['image']['name']){

			$config['upload_path']          = 'uploads/user/avatars';

			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}

			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 10000;
			$config['max_width']            = 20000;
			$config['max_height']           = 10000;
			$config['file_name'] 			= time().$FILES['image']['name'];

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('image')){
				return array('status'=>2,'msg'=>$this->upload->display_errors()); 
			}else{
				@unlink($profile);
				return array('status'=>1,'profile'=>$config['upload_path'].'/' . $this->upload->data()['file_name']);
			}
		} else {

			return array('status'=>1,'profile'=>'');
		}
		
	}

	public function deleteData(){
		$return = $this->users_model->deleteData($this->input->post());
		echo json_encode($return);
	}

}
?>