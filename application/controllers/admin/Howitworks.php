<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Howitworks extends CI_Controller {



	public function __construct(){

		parent::__construct();



		$urlPermission = array('how-it-works','add-how-it-works','edit-how-it-works');

		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');

		if(!$this->session->userdata('user_id')){

			redirect('admin/logout');

		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){

			redirect('admin/logout');

		}

		$this->load->library('Admin_ajax_pagination');

		$this->load->model('admin/howitworks_model');

		$this->perPage = 10;

	}



	public function index(){

		$data = array('viewPage'=>'howitworks/list','pageTitle'=>'How It Works','cssFiles'=>array('daterangepicker'),'jsFiles'=>array('howitworks','moment.min','daterangepicker.min'),'activeMenus'=>array('all-how-it-works','how-it-works'));

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

        $totalRec = count($this->howitworks_model->getList( $this->input->post() ));



        $config['base_url']    = base_url().'admin/how-it-works-search-data';

        $config['total_rows']  = $totalRec;

        $config['per_page']    = $this->perPage;

        $config['link_func']   = 'searchFilter';

        $this->admin_ajax_pagination->initialize($config);



		$data['howitworks'] = $this->howitworks_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );



		$data['start'] = ($offset == 0)?1:$offset+1;

		$data['end'] = $data['start']+$this->perPage;



		$returnArr['html'] = $this->load->view('admin/howitworks/ajax_list',$data,true);

		$returnArr['pagination'] = $this->load->view('admin/howitworks/ajax_list_pagination',$data,true);

        echo json_encode($returnArr);



	}



	public function manageHowitworks($id=''){

		$data = array('viewPage'=>'howitworks/manage','jsFiles'=>array('howitworks'));
		$site_langs = getsitelanguages(1);
		if($id){

			$data['pageTitle'] = 'Edit How It Works';

			$data['activeMenus'] = array('all-how-it-works','edit-how-it-works');

			$data['howitworks'] = $this->howitworks_model->getData($id);

			$data['site_langs'] = $site_langs;

		} else {

			$data['pageTitle'] = 'Add How It Works';

			$data['activeMenus'] = array('all-how-it-works','add-how-it-works');

			$data['howitworks'] = array();

			$data['site_langs'] = $site_langs;
		}

		$this->load->view('admin/template/default',$data);

	}



	public function saveData(){



		$data = $this->input->post();
		$default_lang_arr = getsitelanguages(2);
		
		$default_lang = $default_lang_arr->lang_code;

		$titles = $data['title'];
		$description = $data['description'];

		foreach ($titles as $key => $value) {
			if ($key != $default_lang && ($value == '' || $value == NULL)) {
				$titles[$key] = $titles[$default_lang];
			}
		}

		foreach ($description as $key => $value) {
			if ($key != $default_lang && ($value == '' || $value == NULL)) {
				$description[$key] = $description[$default_lang];
			}
		}

		$data['title'] = json_encode($titles);
		$data['description'] = json_encode($description);

		$uploadFile = $this->doUpload($_FILES,$data['logo']);



		if($uploadFile['status'] == 1){

			$data['logo'] = ($uploadFile['logo'])?$uploadFile['logo']:$data['logo'];

			$return = $this->howitworks_model->saveData($data);

		}else{

			$return = $uploadFile;

		}

		echo json_encode($return);

	}





	public function doUpload($FILES,$logo){



		if($FILES['image']['name']){



			$config['upload_path']          = 'uploads/howitworks';



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

				@unlink($logo);

				return array('status'=>1,'logo'=>$config['upload_path'].'/' . $this->upload->data()['file_name']);

			}

		} else {



			return array('status'=>1,'logo'=>'');

		}



	}



	public function statusChange(){



		$return = $this->howitworks_model->statusChange($this->input->post());

		echo json_encode($return);

	}







	public function deleteData(){



		$return = $this->howitworks_model->deleteData($this->input->post());

		echo json_encode($return);

	}



	public function saveOrdering(){

		$data = $this->input->post();

		$return = $this->howitworks_model->saveOrdering($data);

		echo json_encode($return);

	}



	





}

?>