<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('Front_ajax_pagination');
		$this->load->model('front/users_model');
		$this->load->model('front/profile_model');
		$this->perPage = 10;
	}

	
	public function loginview(){
		$data = array('viewPage'=>'users/login','jsFiles'=>array('login'));
		$this->load->view('front/template/default',$data);
	}

	public function signupview(){
		$data = array('viewPage'=>'users/signup','jsFiles'=>array('login'));
		$this->load->view('front/template/default',$data);
	}

	public function login(){
		$return = $this->users_model->loginData($this->input->post());
		echo json_encode($return);
	}

	public function signup(){
		//echo 'hi';die;
		$data = $this->input->post();
		if(!empty($data['category'])){
			$data['category'] = implode(',',$data['category']);
		}else{
			 $return = array('status'=>2,'message'=>'Please choose a category'); 
			 echo json_encode($return);die;
		}
       $type = $data['type'];
       unset($data['type']);
		if( $type  == 'vendor'){
			$data['role'] = 'vendor';
		}else{
			$data['role'] ='user';
		}
		
		//echo '<pre>';print_r($data);die;
		$emailCheckWhere = array('email'=>$data['email']);
		$emailCheck = $this->users_model->emailCheck($emailCheckWhere);

		if($emailCheck['status'] == 1){
			$phoneCheckWhere = array('phone'=>$data['phone']);
			$phoneCheck = $this->users_model->phoneCheck($phoneCheckWhere);
			if($phoneCheck['status'] == 1){
				$return = $this->users_model->signupData($data);
			}else{
				$return = $phoneCheck;
			}
		} else {
			$return = $emailCheck;
		}
		
		echo json_encode($return);
	}

	public function checkSignupOTP(){
		$return = $this->users_model->checkSignupOTP($this->input->post());
		echo json_encode($return);
	}

	public function sendLoginOtp(){
		$return = $this->users_model->sendLoginOtp($this->input->post());
		echo json_encode($return);
	}

	public function checkLoginOTP(){
		$return = $this->users_model->checkLoginOTP($this->input->post());
		echo json_encode($return);
	}

	public function sendPhoneOtp(){
		$return = $this->users_model->sendPhoneOtp($this->input->post());
		echo json_encode($return);
	}

	public function checkPhoneLoginOTP(){
		$return = $this->users_model->checkPhoneLoginOTP($this->input->post());
		echo json_encode($return);
	}

	public function comission(){
		 $user_id =  $this->session->userdata('id');
        if($user_id){
        $data = array('viewPage'=>'users/comission','jsFiles'=>array('profile'));
        $data['user'] =  $this->profile_model->getData($user_id);//$query->row();
        //print_r($data['user']);die;
        $this->load->view('front/template/default',$data);
        }else{
        	redirect('/');
        }
	}

	


	

	
}
?>