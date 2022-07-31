<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {
    function __construct() {

    }

    public function checkFacebookUser($userData = array(),$user_profiles_data = array()){
        $userID = '';
        if(!empty($userData)){
            if($userData['email']){
                $this->db->select('id');
                $this->db->from('users');
                $this->db->where('deleted_at',NULL);
                $this->db->where(array('email'=>$userData['email']));
                $prevQuery = $this->db->get();
                $prevCheck = $prevQuery->num_rows();

                if($prevCheck > 0){
                    $prevResult = $prevQuery->row();
                    //$userData['modified_at'] = date("Y-m-d H:i:s");
                   // $userData['email_verified'] = 1;
                    $userData = array('social_id'=>$user_profiles_data['social_id'],'logged_using'=>$user_profiles_data['logged_using'],'modified_at' => date("Y-m-d H:i:s"),'email_verified'=>1);
                    $update = $this->db->update('users', $userData, array('id' => $prevResult->id));
                    $userID = $prevResult->id;
                }else{

                    $userData['created_at']  = date("Y-m-d H:i:s");
                    $userData['email_verified'] = 1;
                    $insert = $this->db->insert('users', $userData);
                    $userID = $this->db->insert_id();

                    $username = strstr($userData['email'], '@', true);
                    $check_username = $this->db->where('deleted_at',NULL)->get_where('users',array('username'=>$username))->row();
                    if($check_username){
                        $update = $this->db->update('users', array('username'=>$username.$userID), array('id' => $userID));
                    } else {
                        $update = $this->db->update('users', array('username'=>$username), array('id' => $userID));
                    }
                }

                $user_profiles = $this->db->get_where('user_profiles',array('user_id'=>$userID))->row();

                if($user_profiles){
                    $user_profiles_data['modified_at'] = date("Y-m-d H:i:s");
                    $update = $this->db->update('user_profiles', $user_profiles_data, array('id' => $user_profiles->id));
                } else {
                    $user_profiles_data['created_at']  = date("Y-m-d H:i:s");
                    $user_profiles_data['user_id']  = $userID;
                    $insert = $this->db->insert('user_profiles', $user_profiles_data);
                }
            }
        }

        return $userID?$userID:FALSE;
    }

    public function checkGoogleUser($data = array()){
        $this->db->select($this->primaryKey);
        $this->db->from($this->tableName);
        
        $con = array(
            'oauth_provider' => $data['oauth_provider'],
            'oauth_uid' => $data['oauth_uid']
        );
        $this->db->where($con);
        
        $query = $this->db->get();
        
        $check = $query->num_rows();
        
        if($check > 0){
            $result = $query->row_array();
            
            $data['modified'] = date("Y-m-d H:i:s");
            $update = $this->db->update($this->tableName, $data, array('id'=>$result['id']));
            
            $userID = $result['id'];
        }else{

            $data['created'] = date("Y-m-d H:i:s");
            $data['modified'] = date("Y-m-d H:i:s");
            $insert = $this->db->insert($this->tableName,$data);
            
            $userID = $this->db->insert_id();
        }
        
        return $userID?$userID:false;
    }

    public function how_it_works(){
        return $this->db->select('*,JSON_UNQUOTE(JSON_EXTRACT(title, "$.'.getSessionLang().'")) as howitworks_title,JSON_UNQUOTE(JSON_EXTRACT(description, "$.'.getSessionLang().'")) as howitworks_description')->order_by('step','ASC')->where('deleted_at',NULL)->get_where('how_it_works',array('status'=>1))->result();
    }

    public function testimonials(){
        return $this->db->order_by('id','RANDOM')->where('deleted_at',NULL)->get_where('testimonials',array('status'=>1))->result();
    }

    public function featuredListing(){
        return $this->db->select('listings.*,JSON_UNQUOTE(JSON_EXTRACT(listings.title, "$.'.getSessionLang().'")) as title,JSON_UNQUOTE(JSON_EXTRACT(listings.start_destination, "$.address")) as start_address,JSON_UNQUOTE(JSON_EXTRACT(listings.end_destination, "$.address")) as end_address,users.name,users.username,user_profiles.profile_image,users.logged_using,listing_images.image')->join('listing_images','listing_images.listing_id=listings.id AND listing_images.is_default = 1','left')->join('users','users.id=listings.user_id')->join('user_profiles','user_profiles.user_id=users.id AND user_profiles.logged_using=users.logged_using AND (user_profiles.social_id=users.social_id OR users.social_id IS NULL) ')->order_by('listings.id','RANDOM')->limit(6)->get_where('listings',array('listings.type'=>2,'listings.status'=>1,'listings.feature_status'=>1,'users.status'=>1,'users.deleted_at'=>NULL))->result();
    }

    public function getUserInfo($user_id){
        $this->db->select('users.*,user_profiles.profile_image');
        $this->db->from('users');
        $this->db->join('user_profiles','user_profiles.user_id=users.id AND user_profiles.logged_using=users.logged_using AND (user_profiles.social_id=users.social_id OR users.social_id IS NULL)');
        $this->db->where('users.status',1);
        $this->db->where('users.deleted_at',NULL);
        $this->db->where('users.id',$user_id);
        $query = $this->db->get();
        return $query->row();
    }


   
}