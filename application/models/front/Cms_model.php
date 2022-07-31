<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getDetails($alias=''){		
		$this->db->select('title,description');
		$this->db->from('pages');
		$this->db->where('slug',$alias);
		$query = $this->db->get();
		$data = $query->row();
		return $data;
	}

	

	public function getFaqs($params = array()){
		
		$this->db->select('JSON_UNQUOTE(JSON_EXTRACT(question, "$.'.getSessionLang().'")) as question,JSON_UNQUOTE(JSON_EXTRACT(answer, "$.'.getSessionLang().'")) as answer ');
		$this->db->from('faqs');
		$this->db->where('status',1);
		$this->db->where('deleted_at',NULL);
		$this->db->order_by('ordering','ASC');
		$query = $this->db->get();
		$data = $query->result();
		return $data;
	}

	public function getContact(){
		return $this->db->get_where('site_settings', array('id'=>1))->row();
	}

	public function homeBlog(){
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where('status',1);
		$this->db->order_by("id", "RANDOM");
		$this->db->limit(3);
		$result = $this->db->get()->result();
		return	$result;
	}

	public function SaveContact($data=array()){

		unset($data['g-recaptcha-response']);
		$data['created_at'] = date('Y-m-d H:i:s');
		$inserData = $this->db->insert('contact',$data);
         //echo 'hi';die;
		if($inserData){
			$getAdministratorEmailTemplate = $this->db->get_where('email_templates',array('code'=>'frontend-contact-us','email_for'=>'admins','status'=>1))->row();
			//print_r($getAdministratorEmailTemplate);die;
			$admin = $this->db->get_where('users', array('id'=>1))->row();
			if($getAdministratorEmailTemplate){

				$pattern = array('{NAME}','{EMAIL}','{PHONE}','{MESSAGE}');
				$replacement = array($data['name'],$data['email'],$data['phone'],$data['message']);
				$body = str_replace($pattern,$replacement,$getAdministratorEmailTemplate->content);

				$this->email->from($getAdministratorEmailTemplate->from_email,$getAdministratorEmailTemplate->from_name);
				$this->email->to($admin->email);
				if($getAdministratorEmailTemplate->cc_email){
					$this->email->cc($getAdministratorEmailTemplate->cc_email);
				}
				$this->email->set_mailtype('html');
				$this->email->subject($getAdministratorEmailTemplate->subject);
				$this->email->message($body);
				$mail = $this->email->send();
			}

			$getUserEmailTemplate = $this->db->get_where('email_templates',array('code'=>'user-contact-us','email_for'=>'user','status'=>1))->row();

			if($getUserEmailTemplate){

				$pattern = array('{USER_NAME}');
				$replacement = array($data['name']);
				$body = str_replace($pattern,$replacement,$getUserEmailTemplate->content);

				$this->email->from($getUserEmailTemplate->from_email,$getUserEmailTemplate->from_name);
				$this->email->to($data['email']);
				if($getUserEmailTemplate->cc_email){
					$this->email->cc($getUserEmailTemplate->cc_email);
				}
				$this->email->set_mailtype('html');
				$this->email->subject($getUserEmailTemplate->subject);
				$this->email->message($body);
				$mail = $this->email->send();
			}

			return array('status'=>1,'message'=> 'Data send successfully');
		}else{
			return array('status'=>2,'message'=>'Something is wrong. Please try again.');
		}
	}



		public function SaveEnquiry($data=array()){
        
         if($this->session->userdata('id')){
         	 $data['user_id'] = $this->session->userdata('id');
         }
		 //$data['created_by'] =$this->session->userdata('id');
         $data['created_at'] = date('Y-m-d H:i:s');
		 $inserData = $this->db->insert('enquiries',$data);
         //echo 'hi';die;
		if($inserData){
			$getAdministratorEmailTemplate = $this->db->get_where('email_templates',array('code'=>'frontend-enquiry','email_for'=>'admins','status'=>1))->row();
			//print_r($getAdministratorEmailTemplate);die;
			$admin = $this->db->get_where('users', array('id'=>1))->row();
			if($getAdministratorEmailTemplate){

				$pattern = array('{NAME}','{EMAIL}','{PHONE}','{MESSAGE}');
				$replacement = array($data['name'],$data['email'],$data['phone'],$data['message']);
				$body = str_replace($pattern,$replacement,$getAdministratorEmailTemplate->content);

				$this->email->from($getAdministratorEmailTemplate->from_email,$getAdministratorEmailTemplate->from_name);
				$this->email->to($admin->email);
				if($getAdministratorEmailTemplate->cc_email){
					$this->email->cc($getAdministratorEmailTemplate->cc_email);
				}
				$this->email->set_mailtype('html');
				$this->email->subject($getAdministratorEmailTemplate->subject);
				$this->email->message($body);
				$mail = $this->email->send();
			}

		

			return array('status'=>1,'message'=> 'Data send successfully');
		}else{
			return array('status'=>2,'message'=>'Something is wrong. Please try again.');
		}
	}


	 
	public function sendotp($data=array()){
		$response = array();
		$email = $data['email'];
		if($data['email'] != ""){
			$result = $this->db->get_where('users', array('email'=>$data['email'],'role!='=>'admin','status'=>1,'email_verified'=>1))->row();
			if($result){
				$getTemplate = $this->db->get_where('email_templates',array('code'=>'user-otp','email_for'=>'admins','status'=>1))->row();
				if($getTemplate){

					$getData = $this->db->order_by('id','DESC')->get_where('user_forgot_password', array('user_id'=>$result->id))->row();
					if($getData){
						$user_update = $this->db->insert('user_forgot_password', array('user_id'=>$result->id,'otp'=>$getData->otp,'created_at'=>date('Y-m-d H:i:s')));
						$six_digit_random_number = $getData->otp;
					}else{
						$six_digit_random_number = mt_rand(100000, 999999);
						$user_update = $this->db->insert('user_forgot_password', array('user_id'=>$result->id,'otp'=>$six_digit_random_number,'created_at'=>date('Y-m-d H:i:s')));
					}

					$pattern = array('{USER_NAME}','{USER_OTP}');
					$replacement = array($result->name,$six_digit_random_number);
					$body = str_replace($pattern,$replacement,$getTemplate->content);
					$this->email->from($getTemplate->from_email,$getTemplate->from_name);
					$this->email->to($email);
					$this->email->set_mailtype('html');
					$this->email->subject($getTemplate->subject);
					$this->email->message($body);
					$mail = $this->email->send();

					if ($mail && $user_update) {
						$response['msg'] = 'We send an OTP to this email please verify';
						$response['status'] = 1;
						$response['data'] = $result->id;
					}else{
						$response['msg'] = "Sorry for the inconvenience, please try sometime later";
						$response['status'] = 0;
					}
				}else{
					$response['msg'] = "Sorry for the inconvenience, please contact other admins";
					$response['status'] = 0;
				}
			}else{
				$response['msg'] = "Sorry! you are not a valid user";
				$response['status'] = 0;
			}
		}else{
			$response['msg'] = "Enter your email first";
			$response['status'] = 0;
		}

		return $response;

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
				$response['msg'] = 'Sorry time exceeded or OTP does not matched';
				$response['status'] = 0;
			}
		}else{
			$response['msg'] = "Sorry! you are not a valid admin";
			$response['status'] = 0;
		}
		return $response;
	}


		public function changeForgotPassword(){
		$data = $this->input->post();
		$getuserdata = $this->db->order_by('id','desc')->get_where('user_forgot_password', array('user_id'=>$data['user_id'],'otp'=>$data['otp']))->row();

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
		return $response;
	}


    
}
?>