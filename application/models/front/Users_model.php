<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Users_model extends CI_Model{ 
   public function __construct(){
        parent::__construct();
    }

    public function loginData($data=array()){
        if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $get_user = $this->db->where('password',md5($data['password']) )->where('(email = "'.$data['email'].'")',NULL,false)->get('users')->row();  
        $checkData = 'email'; 
        }else{
        $get_user = $this->db->where('password',md5($data['password']) )->where('(phone = "'.$data['email'].'")',NULL,false)->get('users')->row(); 
        $checkData = 'phone';   
        }  

       // echo '<pre>';print_r($get_user);die;   
        if($get_user){
            if($checkData == 'email' && $get_user->email_verified !=1){
                return array('status'=>3,'message'=>'Your email is not verified . if you want verify your email <a href="javascript:void(0)" onclick="loginOTP()" style="font-weight: bold;color: white;">click here</a>','user_id'=>$get_user->id);
            }else if($checkData == 'phone' && $get_user->phone_verified !=1){
                return array('status'=>3,'message'=>'Your phone number is not verified . if you want verify your phone number <a href="javascript:void(0)" onclick="loginPhoneOTP()" style="font-weight: bold;color: white;">click here</a>','user_id'=>$get_user->id);
            }else{
                if($get_user->role == 'user'){
                    if($get_user->status == 1){
                        //if($get_user){
                           $get_profile_data =  $this->db->where('user_id',$get_user->id)->where('logged_using',$get_user->logged_using)->where('(social_id ="'.$get_user->social_id.'" OR social_id IS NULL)',NULL,false)->get('user_profiles')->row();
                            $this->session->set_userdata('id',$get_user->id);
                            $this->session->set_userdata('email',$get_user->email);
                            $this->session->set_userdata('role',$get_user->role);
                            $this->session->set_userdata('name',$get_user->name);
                            $this->session->set_userdata('logged_using',$get_user->logged_using);
                            $this->session->set_userdata('profile_image',$get_profile_data->profile_image);
                            $cart_session_id = (get_cookie('session_id'))?get_cookie('session_id'):'';
                            if($cart_session_id!=''){
                              $this->db->where('session_id',$cart_session_id);
                              $this->db->update('cart',array('user_id'=>$get_user->id));
                            }
                            return array('status'=>1,'message'=>'successfully logged in','user_id'=>$get_user->id);
                        // }else{
                        //     return array('status'=>2,'message'=>'Your Email not verified.If you verify your email then click <a href="javascript:void(0)" onclick="loginOTP()">here</a>','user_id'=>$get_user->id);  
                        // }
                    }else{
                        return array('status'=>2,'message'=>'Your account not activated');
                    } 
                }else{
                    return array('status'=>2,'message'=>'Invalid user'); 
                }
            }
        }else{
            return array('status'=>2,'message'=>'Invalid email or password');  
        }
    }



    public function signupData($data=array()){
       //echo '<pre>';print_r($data['shop_image']);die;
        $data['name'] = $data['name'];
        $data['password'] = md5($data['password']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['role'] = $data['role'];
        $email_verified_code = rand(100000,999999);
        $data['email_verified_code'] = $email_verified_code;
        if( $data['role'] == 'vendor'){
            $data['email_verified'] = 1;
            $data['access_management'] = '["dashboard","all-transactions","transactions","all-products","products","add-product","edit-product","delete-product","change-status-product","change-featured-product","all-orders","orders","stores","change-status-store","all-stores","edit-store","add-store","delete-store"]';
        }else{
             $data['email_verified'] = 2;
        }
        
        $phone_verified_code = rand(100000,999999);
        $data['phone_verified_code'] = $phone_verified_code;
        $data['phone_verified'] = 2;
        $inserData = $this->db->insert('users',$data);
        $lastID = $this->db->insert_id();
        $username = strstr($data['email'], '@', true);

        $check = $this->db->where('deleted_at',NULL)->get_where('users',array('username'=>$username))->result_array();
        if(count($check)>0){
            $username = $username.''.$lastID;
        }
        $update = $this->db->where('id',$lastID)->update('users',array('username'=>$username));
        $this->db->insert('user_profiles',array('user_id'=>$lastID,'created_at'=>date('Y-m-d H:i:s')));
        if($inserData){
            if(!empty($refer)){
                $ur = $this->db->where('deleted_at',NULL)->get_where('users',array('username'=>$refer))->row();
                if(empty($ur->refer_id)){
                   $update = $this->db->where('username',$refer)->update('users',array('refer_id'=>$lastID,'refer_amount'=>2));
                }else{
                     $update = $this->db->where('username',$refer)->update('users',array('refer_id'=>$ur->refer_id.','.$lastID,'refer_amount'=>2));
                }
            }
            // $getUserEmailTemplate = $this->db->get_where('email_templates',array('code'=>'user-otp-register','email_for'=>'user','status'=>1))->row();
            // if($getUserEmailTemplate){                
            //     $pattern = array('{USER_NAME}','{USER_OTP}');
            //     $replacement = array($data['name'],$email_verified_code);               
            //     $body = str_replace($pattern,$replacement,$getUserEmailTemplate->content);
            //     $this->email->from($getUserEmailTemplate->from_email,$getUserEmailTemplate->from_name);
            //     $this->email->to($data['email']);
            //     $this->email->set_mailtype('html');
            //     $this->email->subject($getUserEmailTemplate->subject);
            //     $this->email->message($body);
            //     $mail = $this->email->send();
            // }

            // $getAdministratorEmailTemplate = $this->db->get_where('email_templates',array('code'=>'frontend-user-signup','email_for'=>'admins','status'=>1))->row();

            // $admin = $this->db->get_where('users', array('role'=>'admin'))->row();
            // if($getAdministratorEmailTemplate){
            //     $receiver_email = $admin->email;
            //     $pattern = array('{USER_NAME}','{USER_EMAIL}');
            //     $replacement = array($data['name'],$data['email'],$data['name']);
            //     $body = str_replace($pattern,$replacement,$getAdministratorEmailTemplate->content);

            //     $this->email->from($getAdministratorEmailTemplate->from_email,$getAdministratorEmailTemplate->from_name);
            //     $this->email->to($receiver_email);
            //     if($getAdministratorEmailTemplate->cc_email){
            //         $this->email->cc($getAdministratorEmailTemplate->cc_email);
            //     }
            //     $this->email->set_mailtype('html');
            //     $this->email->subject($getAdministratorEmailTemplate->subject);
            //     $this->email->message($body);
            //     $mail = $this->email->send();
            // }

            // if($data['phone'] !=''){
            //     $message = 'This is your one time OTP for your phone verification: '.$phone_verified_code;
            //     $sms = getOtpBySms($data['phone'],$message,$phone_verified_code);
            // }
            return array('user_id'=>$lastID,'email'=>$data['email'],'phone'=>$data['phone'],'status'=>1,'message'=>'Signup successfully Done.Please verify your email to continue.');
        }else{
            return array('status'=>2,'message'=>'Signup failed,please try again.'); 
        }

    }


    public function emailCheck($where=array()){
        $checkemail = $this->db->where('deleted_at',NULL)->get_where('users',$where)->row();
        if($checkemail){
            return array('status'=>2,'message'=>'Email already exists');
        } else {
            return array('status'=>1);
        }
    }

    public function phoneCheck($where=array()){
        $checkphone = $this->db->where('deleted_at',NULL)->get_where('users',$where)->row();
        if($checkphone){
            return array('status'=>2,'message'=>'Phone already exists');
        } else {
            return array('status'=>1);
        }
    }

    public function checkSignupOTP($where=array()){
        $checkuser1 = $this->db->get_where('users',array('email_verified_code'=>$where['email_verified_code']))->row();
        $checkuser2 = $this->db->get_where('users',array('phone_verified_code'=>$where['phone_verified_code']))->row();
        if($checkuser1 && $checkuser2){
            $this->db->where('id',$where['id'])->update('users',array('email_verified'=>1,'email_verified_code'=>NULL,'email_verified_date'=>date('Y-m-d H:i:s'),'phone_verified'=>1,'phone_verified_code'=>NULL,'phone_verified_date'=>date('Y-m-d H:i:s')));
            return array('status'=>1,'message'=>'Email & Phone verified.');
        }else{
            if(!empty($checkuser1) && empty($checkuser2)){
              $this->db->where('id',$where['id'])->update('users',array('email_verified'=>1,'email_verified_code'=>NULL,'email_verified_date'=>date('Y-m-d H:i:s')));
               return array('status'=>1,'message'=>'Email Verified.'); 
            }else if(empty($checkuser1) && !empty($checkuser2)){
              $this->db->where('id',$where['id'])->update('users',array('phone_verified'=>1,'phone_verified_code'=>NULL,'phone_verified_date'=>date('Y-m-d H:i:s')));
               return array('status'=>1,'message'=>'Phone verified.'); 
            }else if(empty($checkuser1) && empty($checkuser2)){
                return array('status'=>2,'message'=>'Email & Phone OTP does not matched.'); 
            }            
        }        
    }

    public function sendLoginOtp($where=array()){
        $checkuser = $this->db->get_where('users',$where)->row();
        if($checkuser){
            $getUserEmailTemplate = $this->db->get_where('email_templates',array('code'=>'user-otp-register','email_for'=>'user','status'=>1))->row();
            if($getUserEmailTemplate){                
                $pattern = array('{USER_NAME}','{USER_OTP}');
                $replacement = array($checkuser->name,$checkuser->email_verified_code);               
                $body = str_replace($pattern,$replacement,$getUserEmailTemplate->content);
                $this->email->from($getUserEmailTemplate->from_email,$getUserEmailTemplate->from_name);
                $this->email->to($checkuser->email);
                $this->email->set_mailtype('html');
                $this->email->subject($getUserEmailTemplate->subject);
                $this->email->message($body);
                $mail = $this->email->send();
            }
            return array('status'=>1,'message'=>'Email sent.');
        } else {
            return array('status'=>2,'message'=>'Email does not send.');
        }
    }

    public function checkLoginOTP($where=array()){
        $checkuser = $this->db->get_where('users',$where)->row();
        if($checkuser){
            $this->session->set_userdata('id',$where['id']);
            $this->db->where('id',$where['id'])->update('users',array('email_verified'=>1,'email_verified_code'=>NULL,'email_verified_date'=>date('Y-m-d H:i:s')));
            return array('status'=>1,'message'=>'Email verified.');
        } else {
            return array('status'=>2,'message'=>'OTP does not matched.');
        }
    }

    public function sendPhoneOtp($where=array()){
        $checkuser = $this->db->get_where('users',$where)->row();
        if($checkuser){
            $message = 'This is your one time OTP for your phone verification :'.$checkuser->phone_verified_code;
            $getOtpBySms = getOtpBySms($checkuser->phone,$message,$checkuser->phone_verified_code);
            if($getOtpBySms){
              return array('status'=>1,'message'=>'OTP send successfully.');  
            }else{
              return array('status'=>2,'message'=>'OTP does not send.'); 
            }
        }else{
            return array('status'=>2,'message'=>'OTP does not send.');
        }
    }

    public function checkPhoneLoginOTP($where=array()){
       $checkuser = $this->db->get_where('users',$where)->row();
        if($checkuser){
            $this->session->set_userdata('id',$where['id']);
            $this->db->where('id',$where['id'])->update('users',array('phone_verified'=>1,'phone_verified_code'=>NULL,'phone_verified_date'=>date('Y-m-d H:i:s')));
            return array('status'=>1,'message'=>'Phone number is verified.');
        } else {
            return array('status'=>2,'message'=>'OTP does not matched.');
        } 
    }

    public function getUserData($user_id=''){
        $this->db->select('users.id,users.name,users.email,users.phone,user_profiles.address,user_profiles.city,user_profiles.state,user_profiles.country,user_profiles.pin_code');
        $this->db->from('users');
        $this->db->join('user_profiles','user_profiles.user_id = users.id','left');
        $this->db->where('users.id',$user_id);
        $result = $this->db->get();
        return $result->row();
    }

    public function getAdminData($email_notification='',$sms_notification=''){
        $this->db->select('id,name,email,phone,email_notification,sms_notification');
        $this->db->from('users');
        $this->db->where('role','admin');
        $this->db->where('deleted_at',NULL);
        $this->db->where('status',1);
        if($email_notification == 1){
          $this->db->where('email_notification',1);  
        }
        if($sms_notification == 1){
          $this->db->where('sms_notification',1);  
        }
        $result = $this->db->get();
        return $result->result();
    }




    
}