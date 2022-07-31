<?php

 header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct(){
		 header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->library('Front_ajax_pagination');
		$this->load->model('front/users_model');
		$this->perPage = 10;
	}

	public function login(){
		$return = $this->users_model->loginData($this->input->post());
		echo json_encode($return);
	}

	public function register(){

		
$data = json_decode(file_get_contents('php://input'),true);
$data_encode=json_encode($data);
print_r($data_encode);die;
		$data = $this->input->get();
		print_r($data);die;
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

	


	

	
}
?>