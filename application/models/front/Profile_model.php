<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Profile_model extends CI_Model{ 
   public function __construct(){
        parent::__construct();
    }

     


     public function getData($user_id=''){
     	
		 $this->db->select('users.*,user_profiles.profile_image,user_profiles.address as user_address,user_profiles.reg_no,user_profiles.account_no,user_profiles.city,user_profiles.state,user_profiles.country,user_profiles.pin_code,user_profiles.latitude,user_profiles.longitude');
        $this->db->from('users');
        $this->db->join('user_profiles','user_profiles.user_id=users.id AND user_profiles.logged_using=users.logged_using AND (user_profiles.social_id=users.social_id OR users.social_id IS NULL)');
        $this->db->where('users.status',1);
        $this->db->where('users.deleted_at',NULL);
        $this->db->where('users.id',$user_id);
        $query = $this->db->get();
        return $query->row();
	}



    public function saveData($data=array()){
		$id = $this->session->userdata('id');
		$logged_using = $this->session->userdata('logged_using');
	
		$this->db->where('id',$id)->where('logged_using',$logged_using)->update('users',$data);
		
		return array('status'=>1,'message'=>'data successfully saved');
	}

	


    public function savePasswordData($data=array()){
		//echo "<pre>"; print_r($data); die;
		$old_password = md5($data['oldpassword']);
		$new_password = $data['password'];
		$confirm_password = $data['confirmpassword'];
		$pass = $this->db->get_where('users',array('id'=>$data['id']))->row();
		if($pass->password == $old_password){
			if($new_password == $confirm_password){
				$this->db->update('users',array('password'=>md5($new_password)),array('id'=>$data['id']));
				return array('status'=>1,'message'=>'Password successfully saved');
			}else{
				return array('status'=>2,'message'=>'Password mismatch');
			}
		}else{
			return array('status'=>2,'message'=>'Old password is incorect');
		}

		
	}


	public function emailCheck($where=array()){
		$emailCheck = $this->db->get_where('users', array('email'=>$where['email']))->row();
		if($emailCheck){
			return array('status'=>2,'message'=>'Email already exists');
		} else {
			return array('status'=>1);
		}
	}

	public function emailCheck2($where=array()){
		$emailCheck = $this->db->get_where('users', $where)->row();
		if($emailCheck){
			return array('status'=>2,'message'=>'Email already exists');
		} else {
			return array('status'=>1);
		}
	}

	public function phoneCheck($where=array()){
		$phoneCheck = $this->db->get_where('users', array('phone'=>$where['phone']))->row();
		if($phoneCheck){
			return array('status'=>2,'msg'=>'Phone already exists');
		} else {
			return array('status'=>1);
		}
	}

	public function phoneCheck2($where=array()){
		$phoneCheck = $this->db->get_where('users', $where)->row();
		if($phoneCheck){
			return array('status'=>2,'msg'=>'Phone already exists');
		} else {
			return array('status'=>1);
		}
	}


	public function sendotp($data=array()){
		$id = $this->session->userdata('id');
		$getUser = $this->db->get_where('users',array('id'=>$id))->row();
		$response = array();
		$email = $data['chnage_email'];
		if($data['chnage_email'] != ""){			
				$getTemplate = $this->db->get_where('email_templates',array('code'=>'user-change-email-otp','email_for'=>'admins','status'=>1))->row();
				if($getTemplate){
					$getData = $this->db->order_by('id','DESC')->get_where('user_forgot_password', array('user_id'=>$id,'field_value'=>$email,'type'=>1))->row();							
					if($getData){
                        $db_time = strtotime($getData->created_at);
						$current_time = strtotime(date('Y-m-d H:i:s'));
						$interval  = abs($current_time - $db_time);
						$minutes   = round($interval / 60);
						if($minutes <= 5){
						   $six_digit_random_number = $getData->otp;
						}else{
                           $six_digit_random_number = mt_rand(100000, 999999);
						}
						$user_update = $this->db->where('id',$getData->id)->update('user_forgot_password', array('otp'=>$six_digit_random_number,'created_at'=>date('Y-m-d H:i:s'),'modified_at'=>date('Y-m-d H:i:s')));
					}else{
						$six_digit_random_number = mt_rand(100000, 999999);
						$user_update = $this->db->insert('user_forgot_password', array('user_id'=>$id,'type'=>1,'otp'=>$six_digit_random_number,'field_value'=>$email,'created_at'=>date('Y-m-d H:i:s')));
					}
					$pattern = array('{USER_NAME}','{USER_OTP}');
					$replacement = array($getUser->name,$six_digit_random_number);
					$body = str_replace($pattern,$replacement,$getTemplate->content);
					//print_r($body);die;
					$this->email->from($getTemplate->from_email,$getTemplate->from_name);
					$this->email->to($email);
					$this->email->set_mailtype('html');
					$this->email->subject($getTemplate->subject);
					$this->email->message($body);
					$mail = $this->email->send();
					if($mail) {
						$response['message'] = 'An OTP send your email for email verification';
						$response['status'] = 1;
						$response['data'] = $id;
						$response['new_email'] = $data['chnage_email'];
					}else{
						$response['message'] = "Sorry for the inconvenience, please try sometime later";
						$response['status'] = 0;
					}
				}else{
					$response['message'] = "Sorry for the inconvenience, please contact other admins";
					$response['status'] = 0;
				}			
		}else{
			$response['message'] = "Enter your email first";
			$response['status'] = 0;
		}
		return $response;
	}


		public function emailotp(){
		$logged_using = $this->session->userdata('logged_using');
		$data = $this->input->post();
		$data['user_id'] = $this->session->userdata('id');
		$getuserdata = $this->db->get_where('user_forgot_password', array('otp'=>$data['otp'],'type'=>1))->row();
		if (isset($getuserdata->id) && $getuserdata->id != "" && $getuserdata->otp != NULL && $getuserdata->created_at != NULL && $getuserdata->otp != "" && $getuserdata->created_at != "") {
			$db_time = strtotime($getuserdata->created_at);
			$current_time = strtotime(date('Y-m-d H:i:s'));
			$interval  = abs($current_time - $db_time);
			$minutes   = round($interval / 60);
			if($minutes <= 5 && $getuserdata->otp == $data['otp']){
                $this->db->where('id',$data['user_id']);
                $this->db->where('logged_using',$logged_using);
				$this->db->update('users',array('email'=>$data['new_email'],'email_verified'=>1,'email_verified_date'=>date('Y-m-d H:i:s') ));  

                $this->db->where('id',$getuserdata->id);
                $this->db->update('user_forgot_password',array('used'=>1,'otp'=>NULL,'modified_at'=>date('Y-m-d H:i:s')));

				$response['message'] = 'Successfully change your email';
				$response['status'] = 1;
				$response['user_id'] = $data['user_id'];
				$response['otp'] = $data['otp'];
			}else{
				$response['message'] = 'Sorry time exceeded or OTP does not matched';
				$response['status'] = 0;
			}
		}else{
			$response['message'] = 'OTP does not mathced';//"OTP does'nt mathced";
			$response['status'] = 0;
		}
		return $response;
	}


	public function updateOtp($data=array()){
		$id = $this->session->userdata('id');		
        $checkuser2 = $this->db->get_where('user_forgot_password',array('otp'=>$data['otp'],'type'=>2))->row();
        if($checkuser2){        	
            $this->db->where('id',$id)->update('users',array('phone'=>$checkuser2->field_value,'phone_verified'=>1,'phone_verified_code'=>NULL,'phone_verified_date'=>date('Y-m-d H:i:s')));
            $this->db->where('id',$checkuser2->id)->update('user_forgot_password',array('otp'=>NULL,'used'=>1,'modified_at'=>date('Y-m-d H:i:s')));
            return array('status'=>1,'message'=>'Phone number change successfully');
        }else{
            return array('status'=>2,'message'=>'OTP does not mathced');            
        }    
	}

	public function savePhoneData($id,$phone,$otp,$type=''){
		if($type == 'store'){
			$this->db->insert('user_forgot_password', array('user_id'=>$id,'type'=>2,'otp'=>$otp,'field_value'=>$phone,'created_at'=>date('Y-m-d H:i:s')));
		    return $lastID = $this->db->insert_id();
		}else{
			return $id = $this->db->where('user_id',$id)->update('user_forgot_password', array('otp'=>$otp,'modified_at'=>date('Y-m-d H:i:s')));
		}
		
	}

	public function checkExistingData($user_id,$field=''){
		$check = $this->db->get_where('user_forgot_password',array('user_id'=>$user_id,'field_value'=>$field))->row();
		if($check){
			return array('status' =>1,'msg'=>'Existing data found');
		}else{
			return array('status' =>2,'msg'=>'No data found');
		}
	}


	public function getAccountDetails(){
		$this->db->select('users.name,users.email,users.logged_using,user_profiles.profile_image,user_bank_accounts.*');
        $this->db->from('users');
       $this->db->join('user_profiles','user_profiles.user_id=users.id AND user_profiles.logged_using=users.logged_using AND (user_profiles.social_id=users.social_id OR users.social_id IS NULL)');
        $this->db->join('user_bank_accounts','user_bank_accounts.user_id=users.id','left');
        $this->db->where('users.status',1);
        $this->db->where('users.deleted_at',NULL);
        $this->db->where('users.id',$this->session->userdata('id'));
        $query = $this->db->get()->row();
        return $query;
	}


	public function accountSettingSave($data=array()){
		if(isset($data['email'])){
			unset($data['email']);
		}
		$data['user_id'] = $this->session->userdata('id');
		if($data['id']){
			$id = $data['id'];
			unset($data['id']);
			$data['modified_by'] = $data['user_id'];
			$this->db->where('id',$id)->update('user_bank_accounts',$data);
		}else{
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['created_by'] = $data['user_id'];
			$this->db->insert('user_bank_accounts',$data);
		}
		return array('status'=>1,'message'=>'Data successfully saved');
	}

   

    
}