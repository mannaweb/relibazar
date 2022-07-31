<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function getList($params = array(),$limit = array()){

			$this->db->select('listings.user_id as listing_user_id,listings.title,users.name,transactions.id,transactions.inv_id,transactions.listing_id,transactions.handling_percentage,transactions.awarded_price,transactions.handling_price,transactions.amount,transactions.status,transactions.created_at,transactions.user_id');
			$this->db->from('transactions');
			$this->db->join('listings','listings.id = transactions.listing_id','left');
			$this->db->join('users','users.id = transactions.user_id','left');			

		if(isset($params['status']) && $params['status']){
			$this->db->where('transactions.status',$params['status']);	
		}

		if(isset($params['user_id']) && $params['user_id']){
			$this->db->where('transactions.user_id',$params['user_id']);	
		}

		if(isset($params['listing_id']) && $params['listing_id']){
			$this->db->where('transactions.listing_id',$params['listing_id']);	
		}

		if(isset($params['pay_for']) && $params['pay_for']){
			if($params['pay_for'] == 1){
				$this->db->where('listings.user_id != transactions.user_id');		
			}else{
				$this->db->where('listings.user_id = transactions.user_id');	
			}
			
		}

		if(isset($params['keyword']) && $params['keyword']){
			$this->db->where('(users.name LIKE "%'.$params['keyword'].'%" OR transactions.inv_id LIKE "%'.$params['keyword'].'%")');	
		}


         if(isset($params['startEnd']) && $params['startEnd']){
			  $explode = explode('-', $params['startEnd']);
			  $starDate = $explode[0];
			  $endDate = $explode[1];
			   $st=date('Y-m-d',strtotime($starDate)).' 00:00:00';
			   $et=date('Y-m-d',strtotime($endDate)).' 23:59:00';
              $this->db->where('transactions.created_at >=',$st);
			  $this->db->where('transactions.created_at <=',$et);
		}

		if(isset($params['sortBy']) && $params['sortBy'] && isset($params['sortByField']) && $params['sortByField']){
			$this->db->order_by($params['sortByField'],$params['sortBy']);
		} else {
			$this->db->order_by('transactions.id','DESC');
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


	public function PayInvoiceSave($data=array()){
		if($data['txn_id']){
			$id = $data['txn_id'];
			unset($data['txn_id']);
			$data['modified_by'] = $this->session->userdata('user_id');
			$data['status'] = 1;
			$this->db->where('id',$id)->update('transactions',$data);

			$getTemplate = $this->db->get_where('email_templates',array('code'=>'user-invoice-pay','email_for'=>'user','status'=>1))->row();

			$this->db->select('JSON_UNQUOTE(JSON_EXTRACT(listings.title, "$.en")) as title,listings.id as listing_id,listings.listing_id as listing_unique_id,users.name,users.email,transactions.user_id,transactions.handling_percentage,transactions.inv_id');
			$this->db->from('transactions');
			$this->db->join('listings','listings.id = transactions.listing_id','left');
			$this->db->join('users','users.id = transactions.user_id','left');
			$this->db->where('transactions.id',$id);
			$infoData = $this->db->get()->row();

			$adminInfo = $this->db->select('name,email')->get_where('users', array('id'=>$this->session->userdata('user_id')))->row();

			if($getTemplate){
				$pattern = array('{USER_NAME}','{AWARDED_PRICE}','{HANDLING_PERCENTAGE }','{HANDLING_PRICE }','{TOTAL_AMOUNT}','{LISTING_NAME}');
				$replacement = array($infoData->name,$data['awarded_price'],$infoData->handling_percentage,$data['handling_price'],$data['amount'],$infoData->title);
				$body = str_replace($pattern,$replacement,$getTemplate->content);
				$this->email->from($getTemplate->from_email,$getTemplate->from_name);
				$this->email->to($infoData->email);
				$this->email->set_mailtype('html');
				$this->email->subject($getTemplate->subject);
				$this->email->message($body);
				$mail = $this->email->send();
			}

			$notifications = array('type'=>2,'type_id'=>$id,'listing_id'=>$infoData->listing_id,'listing_unique_id'=>$infoData->inv_id,'sender_id'=>$this->session->userdata('user_id'),'receiver_ids'=> $infoData->user_id,'message'=>'Admin paid '.$data['amount'].' for Kr. the '.$infoData->title,'seen'=>$this->session->userdata('user_id'),'created_at'=>date('Y-m-d H:i:s'));

			$notify = $this->db->insert('notifications',$notifications);

			return array('status'=>1,'msg'=>'Data successfully saved');
		}else{
			return array('status'=>2,'msg'=>'Somethings is wrong');
		}

	}

	
}
?>