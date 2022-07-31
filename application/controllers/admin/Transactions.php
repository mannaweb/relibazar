<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$urlPermission = array('transactions');
		$userPermission = getUserDetails($this->session->userdata('user_id'),'access_management');
		if(!$this->session->userdata('user_id')){
			redirect('admin/logout');
		} else if( in_array($this->uri->segment(2), $urlPermission) && (!is_array($userPermission) || !in_array($this->uri->segment(2), $userPermission)) ){
			redirect('admin/logout');
		}
		$this->load->library('Admin_ajax_pagination');
		$this->load->model('admin/transactions_model');
		$this->perPage = 10;
	}

	public function index(){

		$data = array('viewPage'=>'transactions/list','pageTitle'=>'Transactions','jsFiles'=>array('transactions','moment.min','daterangepicker.min'),'cssFiles'=>array('daterangepicker'),'activeMenus'=>array('all-transactions','transactions'));
						 $this->db->select('users.name,users.id');
						 $this->db->from('users');
						 $this->db->where('role !=','admin');
		$data['users'] = $this->db->get()->result();

		$this->db->select('JSON_UNQUOTE(JSON_EXTRACT(listings.title, "$.'.getSessionLang().'")) as title,listings.id');
		$this->db->from('listings');
		// $this->db->join('listings','listings.id = transactions.listing_id', 'left');
		// $this->db->group_by('transactions.listing_id');
		$data['listings'] = $this->db->get()->result();
		
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
        $totalRec = count($this->transactions_model->getList( $this->input->post() ));

        $config['base_url']    = base_url().'admin/transactions-search-data';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->admin_ajax_pagination->initialize($config);

		$data['transactions'] = $this->transactions_model->getList( $this->input->post(),array('start'=>$offset,'limit'=>$this->perPage) );

		$returnArr['html'] = $this->load->view('admin/transactions/ajax_list',$data,true);
		$returnArr['pagination'] = $this->load->view('admin/transactions/ajax_list_pagination',$data,true);
        echo json_encode($returnArr);

	}

	
		public function viewInvoice($invoice_id=''){
				
				$this->db->select('JSON_UNQUOTE(JSON_EXTRACT(listings.title, "$.en")) as title,JSON_UNQUOTE(JSON_EXTRACT(listings.start_destination, "$.address")) as start_address,JSON_UNQUOTE(JSON_EXTRACT(listings.end_destination, "$.address")) as end_address,listings.pick_up_date,listings.drop_off_date,transactions.*');
				$this->db->from('transactions');
				$this->db->join('listings','listings.id = transactions.listing_id','left');
				$this->db->where('inv_id',$invoice_id);
				$data['getInvoice'] = $this->db->get()->row();
		//echo "<pre>"; print_r($data['getInvoice']); die;
			//$data['getInvoice'] = $this->db->where('invoice_id',$invoice_id)->get('transactions')->row();;
			if($data['getInvoice']){
			$data['site_setting'] = $this->db->get('site_settings')->row();
			$data['userdata'] = $this->db->where('id',$data['getInvoice']->user_id)->get('users')->row();
			$data['getDefaultCurrency'] = getDefaultCurrency();
			$this->load->view('admin/transactions/invoice',$data);
	        $html = $this->output->get_output();
	        $this->load->library('pdf');
	        $this->dompdf->loadHtml($html);
	        $this->dompdf->setPaper('A4', 'portrait');
	        $this->dompdf->render();
	        $this->dompdf->stream($invoice_id.".pdf", array("Attachment" => 0));
	    } else {
			$this->session->set_flashdata('error', 'Something went wrong,Please try again later');
			redirect(base_url().'admin/transactions');
		}
	}

	public function PayInvoiceModal(){
		$getPayData = $this->db->get_where('transactions', array('id'=>$this->input->post('id')))->row();
		if($getPayData){
			$data['getPayData'] = $getPayData;
			$html = $this->load->view('admin/transactions/ajax_modal',$data,true);
            $return = array('status'=>1,'html'=>$html,'utype'=>'');
		}else{
			$return = array('status'=>2);
		}
		echo json_encode($return);
	}

	public function PayInvoiceSave(){
		$data = $this->input->post();
		$return = $this->transactions_model->PayInvoiceSave($data);
		echo json_encode($return);
	}

	

}
?>