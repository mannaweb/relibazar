<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

		$this->db->select('id,ordering,title,alias,created_date,post_type,featured,active');
		$this->db->from('post');
		$this->db->where('post_type','blog');
		if(isset($params['status']) && $params['status']){
			$this->db->where('post.active',$params['status']);	
		}

		if(isset($params['category']) && $params['category']){
			$this->db->where("FIND_IN_SET(".$params['category'].",post.category) !=", 0);	
		}


		if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  //print_r($explode)
			 // print_r($explode);die;
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('post.created_date >=',$st);
			  $this->db->where('post.created_date <=',$et);
		}

		
		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(post.title LIKE "%'.$params['keyword'].'%")');	
		}

		if(isset($params['featured']) && $params['featured']){
			$this->db->where('post.featured',$params['featured']);	
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('post.ordering','ASC');
		}

		if(array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit'],$limit['start']);
		}elseif(!array_key_exists("start",$limit) && array_key_exists("limit",$limit)){
			$this->db->limit($limit['limit']);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		return ($query->num_rows() > 0)?$query->result():array();

	}

	public function getData($alias=''){

		return $this->db->get_where('post',array('alias'=>$alias,'post_type'=>'blog'))->row();
	}

	public function saveData($data=array()){
		
		if(isset($data['main_cat_id'])){
			unset($data['main_cat_id']);
		}
		if(isset($data['sub_cat_id'])){
			unset($data['sub_cat_id']);
		}	

		if($data['id']){
			$id = $data['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
			unset($data['id']);
			$this->db->where('id',$id)->update('post',$data);
		} else {
			$ordering = $this->db->query('Select post.ordering from post order by ordering desc')->row();	
			if($ordering){
				$data['ordering'] = $ordering->ordering+1;
			}else{
				$data['ordering'] = 1;
			}
			$data['post_type'] = 'blog';
			$data['created_date'] = date('Y-m-d H:i:s');
			$this->db->insert('post',$data);
		}

		return array('status'=>1,'msg'=>'Data successfully saved');
	}

	public function aliasCheck($where=array()){

		$return = $this->db->get_where('post',$where)->num_rows();
		if($return > 0){
			return array('status'=>2,'msg'=>'Category alias already exists.');
		} else {
			return array('status'=>1);
		}
	}

	public function statusChange($data=array()){
		$updateData = $this->db->where('id',$data['id'])->update('post',array('active'=>$data['status']));
		$postData = $this->db->get_where('post', array('id'=>$data['id']))->row();
		$userData = $this->db->select('name,usertype')->get_where('user', array('id'=>$postData->user_id))->row();
		if($data['status'] ==1){
			$status = 'active';
		}else{
			$status = 'inactive';
		}
		if($updateData && $userData->usertype =='user'){
			$getAdministratorEmailTemplate = $this->db->get_where('email',array('code'=>'status-change','email_for'=>'user','status'=>1))->row();
			if($getAdministratorEmailTemplate){

				$pattern = array('{USER_NAME}','{POST_TYPE}','{STATUS}');
				$replacement = array($userData->name,$data['post_type'],$status);
				$body = str_replace($pattern,$replacement,$getAdministratorEmailTemplate->content);

				$this->email->from($getAdministratorEmailTemplate->from_email,$getAdministratorEmailTemplate->from_name);
				$this->email->to($getAdministratorEmailTemplate->to_email);
				if($getAdministratorEmailTemplate->cc_email){
					$this->email->cc($getAdministratorEmailTemplate->cc_email);
				}
				$this->email->set_mailtype('html');
				$this->email->subject($getAdministratorEmailTemplate->subject);
				$this->email->message($body);
				$mail = $this->email->send();
			}
		}
		return array('status'=>1,'msg'=>'Status changed successfully.');
	}

	public function deleteData($data=array()){
		if($data['ids']){
			$ids = explode(',', $data['ids']);
			$getData = $this->db->where_in('id',$ids)->get('post')->result();
			if($getData){
				foreach ($getData as $key => $value) {
					@unlink('./uploads/post/'.$value->logo);
					@unlink('./uploads/post/70x70/'.$value->logo);
					@unlink('./uploads/post/150x150/'.$value->logo);
					@unlink('./uploads/post/350x250/'.$value->logo);

					$getgallery = $this->db->where('post_id',$value->id)->where('type',1)->get('gallery')->result();
					if($getgallery){
						foreach ($getgallery as $key1 => $value1) {
							@unlink('./uploads/post/gallery/'.$value1->image);
							@unlink('./uploads/post/gallery/150x150/'.$value1->image);
						}
					}

				}
				
			}
			$this->db->where_in('post_id',$ids)->delete('gallery');
			$this->db->where_in('id',$ids)->delete('post');
			return array('status'=>1,'msg'=>'Deleted successfully.');
		} else {
			return array('status'=>2,'msg'=>'Something went wrong,please try again later.');
		}
	}

	public function saveOrdering($data=array()){
		if($data['ids']){
			foreach ($data['ids'] as $key => $value) {
				$this->db->where('id',$value)->update('post',array('ordering'=>$data['ordering'][$key]));
			}
			return array('status'=>1,'msg'=>'Updated successfully.');
		}
	}

	// public function statusChangeBanner($data=array()){
	// 	$this->db->where('id',$data['id'])->update('post',array('banner_status'=>$data['status']));
	// 	return array('status'=>1,'msg'=>'Banner status changed successfully.');
	// }

	public function changeFeaturedBlog($data=array()){
		$this->db->where('id',$data['id'])->update('post',array('featured'=>$data['featured']));
		return array('status'=>1,'msg'=>'Blog featured successfully.');
	}


}
?>