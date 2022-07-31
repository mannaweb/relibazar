<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(1);
class Orders extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('orders');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/orders_model');
		$this->perPage = 10;
	}

	public function index(){
		$data = array('viewPage'=>'orders/list','pageTitle'=>'Orders','jsFiles'=>array('orders','moment.min','daterangepicker.min'),'cssFiles'=>array('daterangepicker'),'activeMenus'=>array('all-orders','all-products','orders'));
		$data['product_info'] = $this->db->select('id,name')->get_where('products', array('deleted_at'=>NULL))->result();
		$data['user_email'] = $this->orders_model->getOrderUser(1,'');
		$data['user_phone'] = $this->orders_model->getOrderUser('',1);
		$data['status_info'] = $this->db->select('id,title')->get_where('order_status', array('status'=>1))->result();

		$this->load->view('admin/template/default',$data);
	}

	public function ajaxPaginationSearch(){
        $returnArr = array();
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $this->perPage = $this->input->post('perPage');
        $totalRec = count($this->orders_model->getList($this->input->post() ));

        $config['base_url']    = base_url().'admin/order-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['orders'] = $this->orders_model->getList($this->input->post(),array('start'=>$offset,'limit'=>$this->perPage));
		
		if( ( $offset + $this->perPage ) < ( $totalRec -1 ) )
        $end = $offset + $this->perPage;
        else
        $end = $totalRec;

		$data['start'] = $offset+1;
		$data['end'] = $end;
		$data['total'] = $totalRec;
       //$data['orders'] =array();
		$returnArr['html'] = $this->load->view('admin/orders/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/orders/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);
	}


	function orderDetails(){
		$data['order_maintainence'] = $this->db->get_where('order_maintainence',array('order_id'=>$this->input->post('order_id')))->result();
		$data['orders'] = $this->db->get_where('orders',array('order_id'=>$this->input->post('order_id')))->row();
		 $returnArr['html'] = $this->load->view('admin/orders/ajax_details',$data,true);
		 echo json_encode($returnArr);
	}

	function orderManage(){
		$data['order_id'] = $this->input->post('order_id');
		$data['orders'] = $this->db->get_where('orders',array('order_id'=>$data['order_id']))->row();
		$data['order_status'] = $this->db->get_where('order_status',array('status'=>1))->result();
		 $returnArr['html'] = $this->load->view('admin/orders/ajax_status',$data,true);
		 echo json_encode($returnArr);
	}
	
	function updateStatus(){
		//echo 'hi';die;
		$order_status = $this->input->post('order_status');
		$status_name = $this->db->get_where('order_status',array('id'=>$order_status))->row();
		//echo $this->input->post('order_status');
		$getOrder = $this->db->get_where('orders',array('order_id'=>$this->input->post('order_id')))->row();
		$user_info = json_decode($getOrder->user_info);
		//echo $user_info->contact_number;die;
		
		$upd = array('order_status' => $order_status);
		$ins = array('order_id' => $this->input->post('order_id'),'manage_by' => $this->session->userdata('user_id'),'status_id' => $this->input->post('order_status'),'status_name' =>  $status_name->title,'comment' => $this->input->post('msg'));
		$this->db->insert('order_maintainence',$ins);
		$this->db->where('order_id',$this->input->post('order_id'));
		$this->db->update('orders',$upd);

		if($user_info->contact_number){
			
			if($msg != ''){
				$msg = $this->input->post('msg');
			}else{
				$msg = '';
			}
			$message = $status_name->title.'<br>'.$msg;
			//echo $msg;die;
	   	 $getOtpBySms = getOtpBySms($user_info->contact_number,$message);
	   	// print_r( $getOtpBySms);die;
		}

		if($user_info->email){
			//echo 'hi';die;
			$getEmailTemplate = $this->db->get_where('email_templates',array('code'=>'user-status-change','email_for'=>'user','status'=>1))->row();
			//print_r($getEmailTemplate);die;
			if($getEmailTemplate){

				$pattern = array('{USER_NAME}','{ORDER_STATUS}');
				$replacement = array($user_info->user_name,$status_name->title);
				$body = str_replace($pattern,$replacement,$getEmailTemplate->content);
				//echo $body;die;
				//print_r($body);die;
                $this->email->from($getEmailTemplate->from_email,$getEmailTemplate->from_name);
				$this->email->to($user_info->email);
				if($getEmailTemplate->cc_email){
					$this->email->cc($getEmailTemplate->cc_email);
				}
				$this->email->set_mailtype('html');
				$this->email->subject('Your Order #'.$this->input->post('order_id').' is '.$status_name->title);
				$this->email->message($body);
				$mail = $this->email->send();
			}
		}
	}

}
?>