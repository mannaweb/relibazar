<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('user_id') && $this->uri->segment(2) != 'logout'){
			redirect('admin/dashboard');
		}
		$this->load->model('admin/login_model');
	}

	public function index(){
       //echo 'hi';die;
		$data = array('viewPage'=>'login','pageTitle'=>'Admin Login','jsFiles'=>array('login','jquery.cookie'),'cssFiles'=>array('login'));
		$this->load->view('admin/template/login',$data);
	}

	public function login(){

		$login = $this->login_model->login($this->input->post());
		echo json_encode($login);
	}

	public function sendotp(){
		$response = array();
		$data = $this->input->post();
		$email = $data['email'];
		if($data['email'] != ""){

			$querystring = 'Select * from users where (username = "' . $data['email'] . '" or email = "' . $data['email'] . '")';
			$query1 = $this->db->query($querystring); 
			$user_info = $query1->row();

			if($user_info){

			$query = $this->db->query("SELECT * FROM users WHERE email = '".$user_info->email."' AND FIND_IN_SET('admin',role) <> 0");
			$result = $query->result_array();
			if(count($result) == 1){
				$getTemplate = $this->db->get_where('email_templates',array('code'=>'user-otp','email_for'=>'admins','status'=>1))->row();
				if($getTemplate){

					 $six_digit_random_number = mt_rand(100000, 999999);
					$pattern = array('{USER_NAME}','{USER_OTP}');
					$replacement = array($result[0]['name'],$six_digit_random_number);
					$body = str_replace($pattern,$replacement,$getTemplate->content);
					$this->email->from($getTemplate->from_email,$getTemplate->from_name);
					$this->email->to($result[0]['email']);
					$this->email->set_mailtype('html');
					$this->email->subject($getTemplate->subject);
					$this->email->message($body);
					$mail = $this->email->send();

					$getData = $this->db->order_by('id','DESC')->get_where('user_forgot_password', array('user_id'=>$result[0]['id']))->row();
					if($mail && $getData){
						$user_update = $this->db->insert('user_forgot_password', array('user_id'=>$result[0]['id'],'otp'=>$getData->otp,'created_at'=>date('Y-m-d H:i:s')));
					}else{
						$user_update = $this->db->insert('user_forgot_password', array('user_id'=>$result[0]['id'],'otp'=>$six_digit_random_number,'created_at'=>date('Y-m-d H:i:s')));
					}
					

					

					if ($user_update) {
						$response['msg'] = "We send an OTP to this email, please verify";
						$response['status'] = 1;
						$response['data'] = $result[0]['id'];
					}else{
						$response['msg'] = "Sorry for the inconvenience, please try sometime later";
						$response['status'] = 0;
					}
				}else{
					$response['msg'] = "Sorry for the inconvenience, please contact other admins";
					$response['status'] = 0;
				}
			}else{
				$response['msg'] = "Sorry! you are not a valid admin";
				$response['status'] = 0;
			}
		}else{
			$response['msg'] = "Sorry! you are not a valid admin";
				$response['status'] = 0;
		}
		}else{
			$response['msg'] = "Enter your email first";
			$response['status'] = 0;
		}
		echo json_encode($response);
	}

	public function checkotp(){
		$data = $this->input->post();
		$getuserdata = $this->db->order_by('id','DESC')->get_where('user_forgot_password', array('user_id'=>$data['user_id'],'used'=>0))->row();

		if (isset($getuserdata->id) && $getuserdata->id != "" && $getuserdata->otp != NULL && $getuserdata->created_at != NULL && $getuserdata->otp != "" && $getuserdata->created_at != "") {
			$db_time = strtotime($getuserdata->created_at);
			$current_time = strtotime(date('Y-m-d H:i:s'));
			$interval  = abs($current_time - $db_time);
			$minutes   = round($interval / 60);
			if($minutes <= 5 && $getuserdata->otp == $data['otp']){
				$response['msg'] = "Now you can change your password";
				$response['status'] = 1;
				$response['user_id'] = $data['user_id'];
				$response['otp'] = $data['otp'];
			}else{
				$response['msg'] = "Sorry! time exceeded or OTP does'nt mathced";
				$response['status'] = 0;
			}
		}else{
			$response['msg'] = "Sorry! you are not a valid admin";
			$response['status'] = 0;
		}
		echo json_encode($response);
	}


	public function change_pass(){
		$data = $this->input->post();
		$getuserdata = $this->db->get_where('user_forgot_password', array('user_id'=>$data['user_id'],'otp'=>$data['otp']))->row();

		if (isset($getuserdata->id) && $getuserdata->id != "" && $getuserdata->otp != NULL && $getuserdata->created_at != NULL && $getuserdata->otp != "" && $getuserdata->created_at != "") {
			if($data['new_password'] == $data['new_cpassword']){
				$new_password = md5($data['new_password']);
				$this->db->where('id',$getuserdata->id)->update('user_forgot_password',array('used'=>1,'modified_at'=>date('Y-m-d H:i:s')));
				$pass_update = $this->db->where('id',$data['user_id'])->update('users',array('password'=>$new_password));
				if($pass_update){
					$response['msg'] = "Password changed successfully, login with your new password";
					$response['status'] = 1;
				}else{
					$response['msg'] = "Sorry! something went wrong, please try later";
					$response['status'] = 0;
				}
			}else{
				$response['msg'] = "Sorry! password and confirm password does'nt matched";
				$response['status'] = 0;
			}
		}else{
			$response['msg'] = "Sorry! you are not a valid admin";
			$response['status'] = 0;
		}
		echo json_encode($response);
	}

	public function logout(){
		$this->session->set_userdata('user_id','');
		$this->session->set_userdata('two_factor','');
		$this->session->set_userdata('google_auth_code','');
		$this->session->set_userdata('email','');
		$this->session->set_userdata('google_authentication_url','');
		$this->session->sess_destroy();
		redirect('admin');
	}
}
?>