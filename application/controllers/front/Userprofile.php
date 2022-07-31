<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userprofile extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('Front_ajax_pagination');
		$this->load->model('front/profile_model');
		//$this->load->model('front/reviews_model');
		$this->perPage = 2;
	}

	public function viewProfile(){      
        $user_id =  $this->session->userdata('id');
        if($user_id){
        $data = array('viewPage'=>'users/profile','jsFiles'=>array('profile'));
        $data['user'] =  $this->profile_model->getData($user_id);//$query->row();
        //print_r($data['user']);die;
        $this->load->view('front/template/default',$data);
        }else{
        	redirect('/');
        }
		
	}

	public function saveProfileData(){		
		$data = $this->input->post();
		$uid =  $this->session->userdata('id');
		//$usernameCheckWhere = array('username'=>$data['username'],'id !=' => $uid);
       // $usernameCheck = $this->profile_model->usernameCheck($usernameCheckWhere);
       // if($usernameCheck['status'] == 1){           
    //        $uploadFile = $this->doUpload($_FILES,$data['profile']);
    //        //echo '<pre>';print_r($uploadFile);die();
    //     	if($uploadFile['status'] == 1){
    //             $data['profile'] = ($uploadFile['profile'])?$uploadFile['profile']:$data['profile'];
			 //    $return = $this->profile_model->saveData($data);
			 // }else{
			 // 	$return['status'] = $uploadFile['status'];
			 // 	$return['message'] = $uploadFile['msg'];
			 // }
	 $return = $this->profile_model->saveData($data);
        echo json_encode($return);
	}


		public function doUpload($FILES,$profile){
		if($FILES['image']['name']){
			$config['upload_path']          = 'uploads/user/avatars';
			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}
			$config['allowed_types']        = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
			$config['max_size']             = 10000;
			$config['max_width']            = 20000;
			$config['max_height']           = 10000;
			$config['file_name'] 			= time().$FILES['image']['name'];
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('image')){
				return array('status'=>2,'msg'=>$this->upload->display_errors()); 
			}else{
			    @unlink($profile);
				return array('status'=>1,'profile'=>$config['upload_path'].'/' . $this->upload->data()['file_name']);
			}
		}else{
			return array('status'=>1,'profile'=>'');
		}

	}

	public function ChangePassword(){
		$uid =  $this->session->userdata('id');
		if($uid){
			$data = array('viewPage'=>'users/change_password','jsFiles'=>array('profile'));
		      $this->load->view('front/template/default',$data);
	       }else{
             redirect('/');
	       }
		
	}

	public function saveChangePassword(){
		$id = $this->session->userdata('id');
		$alldata = $this->input->post();
		$alldata['id'] = $id;
		$return = $this->profile_model->savePasswordData($alldata);
		echo json_encode($return);
	}


	public function emailVerify(){
		$data = $this->input->post();
		$id = $this->session->userdata('id');
		if($data['type'] == 1){
		$emailCheckWhere = array('email'=> $data['chnage_email'],'id !='=>$id);
		} else {
		$emailCheckWhere = array('email'=> $data['chnage_email']);
		}
		$emailCheck = $this->profile_model->emailCheck2($emailCheckWhere);
		if($emailCheck['status'] == 1){
          $return = $this->profile_model->sendotp($data);
		}else{
			$return = $emailCheck;
		}
		echo json_encode($return);
	}

	public function otpChangeEmail(){
		$data = $this->input->post();
		$return = $this->profile_model->emailotp($data);
		echo json_encode($return);
	}


	public function phoneVerify(){
		$data = $this->input->post();
		$id = $this->session->userdata('id');
		if($data['type'] == 1){
		$phoneCheckWhere = array('phone'=> $data['new_phone'],'id !='=>$id);
		} else {
		$phoneCheckWhere = array('phone'=> $data['new_phone']);
		}
		$phoneCheck = $this->profile_model->phoneCheck2($phoneCheckWhere);
		if($phoneCheck['status'] == 1){
		  $phone_verified_code = rand(100000,999999);
          $message = 'This is your one time OTP for your phone verification: '.$phone_verified_code;
          $return = getOtpBySms($data['new_phone'],$message,$phone_verified_code);          
          if($return){
          	$checkData = $this->profile_model->checkExistingData($id,$data['new_phone']);
          	if($checkData['status'] == 1){
          	  $update = $this->profile_model->savePhoneData($id,$data['new_phone'],$phone_verified_code,'update');
          	}else{
          	  $store = $this->profile_model->savePhoneData($id,$data['new_phone'],$phone_verified_code,'store');
          	}
          	$return['success'] = 'true'; 
          	$return['msg'] = 'Check your phone for phone no. verification';
          }else{
          	$return['msg'] = $return;
          	$return['success'] = 'false';
          }
		}else{
		  $return = $phoneCheck;
		}
		echo json_encode($return);
	}


	public function otpChangePhone(){
		$data = $this->input->post();
		$return = $this->profile_model->updateOtp($data);
		echo json_encode($return);
	}

		public function user_details(){
		$data = $this->input->post();
		 $data['user'] =  $this->profile_model->getData($data['user_id']);
		
        $returnArr['html'] = $this->load->view('front/users/ajax_details',$data,true);
		  echo json_encode($returnArr);
	}


	



	

	
}
?>