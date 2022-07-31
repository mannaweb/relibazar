<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends CI_Controller {



	public function __construct(){

		parent::__construct();

		$this->load->model('front/categories_model');

		$this->load->model('front/home_model');

		$this->load->model('front/cms_model');

		$this->load->model('front/common_model');

	}



	public function index(){

              //echo "Frontend Under construction";die;

 

		if(get_cookie('session_id') == ''){   

            $uniqueId = uniqid(rand(), TRUE);

            $cookie = array(

              'name'   => 'session_id',

              'value'  => md5($uniqueId),

               'expire' => time() + 172800,//'86500',

            );

            $this->input->set_cookie($cookie);

        } 

		$data = array('viewPage'=>'home/index','jsFiles'=>array('jquery.cookie','cms'),'pageTitle'=>'Singla sweets','activeMenus'=>array('home'));

		$data['category_info'] = $this->categories_model->getList(array(),array('start'=>0,'limit'=>9));

		
		$data['banners'] = $this->db->get_where('banners',array('type'=>'home','status'=>1))->result();
		$data['about'] = $this->db->get_where('pages',array('slug'=>'about'))->row();
		//echo '<pre>';print_r($data['about']);die();
        $data['products'] = $this->db->limit(12)->get_where('products',array('status'=>1,'featured'=>1))->result();
		$data['testimonials'] = $this->home_model->testimonials();

		$this->load->view('front/template/default',$data);

	}





	public function getAny($param1 = ''){



		

		if($this->session->userdata('id') && $param1 =='signup'){

			redirect('profile');

		}



		$checkPage = getPageDetailsByAlias($param1);

		if($checkPage){

			$data = array('viewPage'=>'cms/index','jsFiles'=>array('jquery.cookie','cms'),'param1'=>$param1,'details'=>$checkPage);

			$data['pageDetails'] = $this->cms_model->getDetails($param1);



			$page_type_id = $this->common_model->getPagesDetailsByAlias($param1,'id');

			$data['getBanner'] = $this->common_model->getBanner(array('type'=>'pages','page_type_id'=>$page_type_id));

			//echo "<pre>"; print_r($data['getBanner']); die;

			$data['getSeo'] = $this->common_model->getSeo(array('type'=>'pages','type_id'=>$page_type_id));



			if($param1 == 'faqs'){

				$data['faqs'] = $this->cms_model->getFaqs();



			} else if($param1 == 'contact-us'){

				$data['contact'] = $this->cms_model->getContact();

			}

			$this->load->view('front/template/default',$data);

		} else {

			$this->load->view('err404');

		}

	}





	public function saveContactData(){

         $capt = $this->input->post('g-recaptcha-response');

		$recaptchaResponse = trim($capt);

 

    $userIp=$this->input->ip_address();

 

    $secret = '6Lfc3sMUAAAAADJUgjfJNPPkrgJYnwSPgvCtDTGo';



    $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;



    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_URL, $url); 

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    $output = curl_exec($ch); 

    curl_close($ch);      

     

    $status= json_decode($output, true);

  if ($status['success']) {

      

		//echo 'hi';die;

		$alldata = $this->input->post();

		unset($alldata['g-recaptcha-response']);

		unset($alldata['hiddenRecaptcha']);

		

		$return = $this->cms_model->saveContact($alldata);

	}else{

        $return = array('status'=>2,'message'=>'Captcha is missing,please try again');

	}

		echo json_encode($return);

	}





	public function saveEnquiryData(){

       $alldata = $this->input->post();

		$return = $this->cms_model->saveEnquiry($alldata);

	     echo json_encode($return);

	}



	public function logout(){

		$this->session->unset_userdata('id');

		$this->session->unset_userdata('email');

        $this->session->unset_userdata('role');

        $this->session->unset_userdata('name');

		redirect(base_url());

	}



	public function sendotp(){

		$data = $this->input->post();

		$return = $this->cms_model->sendotp($data);

		echo json_encode($return);

	}



	public function checkotp(){

		$data = $this->input->post();

		$return = $this->cms_model->checkotp($data);

		echo json_encode($return);

	}



	public function changeForgotPassword(){

		$data = $this->input->post();

		$return = $this->cms_model->changeForgotPassword($data);

		echo json_encode($return);

	}



	

}

?>