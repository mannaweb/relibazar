<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include(APPPATH . '/libraries/Crypto.php');
class Order extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('front/cart_model');
		$this->load->model('front/products_model');
		$this->load->model('front/users_model');
		$this->load->model('front/order_model');
		$this->cartSessionID = get_cookie('session_id');
	}

	public function placeOrder(){		
			$data = $this->input->post();
			$orderData = array();
			$getProductData = getAllCartData($this->cartSessionID);
			$subtotal = $this->cart_model->countCartPrice($this->cartSessionID);
			$orderData['store_id'] = $data['store_id'];
			$orderData['user_id'] = $this->session->userdata('id');
			$userInfo = array('user_id' => $this->session->userdata('id'),'user_name' =>$data['user_name'],'email' => $data['user_email'],'contact_number' => $data['user_contact_number'],'delivery_address' => $data['user_address'],'city' => $data['user_city'],'state' => $data['user_state'],'pincode' => $data['user_pincode']);
			$orderData['user_info'] = json_encode($userInfo);
			$orderData['product_info'] = json_encode($getProductData);
			$orderData['coupon'] = $data['coupon_code'];
			$orderData['coupon_price'] = (($data['coupon_price'] !='0')?base64_decode($data['coupon_price']):0);
			$orderData['coupon_discount'] = (($data['coupon_discount'] != '0')?base64_decode($data['coupon_discount']):0);
			$orderData['coupon_discount_type'] = (($data['coupon_discount_type'] != '0')?base64_decode($data['coupon_discount_type']):NULL);
			$orderData['payment_method'] = 'Cash On Delivery';
	        $orderData['payment_status'] = 'Pending';
	        $orderData['order_status'] = 1;
	        $orderData['total_amount'] = ($subtotal->total-$orderData['coupon_price']);
	        $orderData['created_by'] = $this->session->userdata('id');
	        $orderData['created_at'] = date('Y-m-d h:i:s');
			$storeData = $this->cart_model->storeOrder($orderData);
			if($storeData){
			  $getInsertID=str_pad($storeData, 6, '0', STR_PAD_LEFT);
			  $order_id ="OD".$getInsertID;
			  $updateData = $this->cart_model->updateOrder(array('order_id'=>$order_id),$storeData);
			}
		   if($updateData){
		   	 $orderdata = array();
		   	 $order_info = $this->order_model->getOrderData($order_id);
		   	 $user_info = json_decode($order_info->user_info);
		   	 $action_url = base_url().'payment';
		   	 $redirect_url = base_url().'order-information';
		   	 $html = '<input type="text" name="merchant_id" value="240382"/>
					<input type="text" name="order_id" id="order_id" value="'.(($order_info && $order_info->order_id)?$order_info->order_id:'').'"/>
					<input type="text" name="amount" id="amount" value="'.(($order_info && $order_info->total_amount)?$order_info->total_amount:'').'"/>
					<input type="text" name="currency" value="INR"/>
					<input type="text" name="redirect_url" value="'.$redirect_url.'"/>
					<input type="text" name="cancel_url" value="'.$action_url.'"/>
					<input type="text" name="language" value="EN"/>
					<input type="text" name="billing_name" id="billing_name" value="'.(($user_info && $user_info->user_name)?$user_info->user_name:'').'"/>
					<input type="text" name="billing_address" id="billing_address" value="'.(($user_info && $user_info->delivery_address)?$user_info->delivery_address:'').'"/>
					<input type="text" name="billing_city" id="billing_city" value="'.(($user_info && $user_info->city)?$user_info->city:'').'"/>
					<input type="text" name="billing_state" id="billing_state" value="'.(($user_info && $user_info->state)?$user_info->state:'').'"/>
					<input type="text" name="billing_zip" id="billing_zip" value="'.(($user_info && $user_info->pincode)?$user_info->pincode:'').'"/>
					<input type="text" name="billing_country" value="India"/>
					<input type="text" name="billing_tel" id="billing_tel" value="'.(($user_info && $user_info->contact_number)?$user_info->contact_number:'').'"/>
					<input type="text" name="billing_email" id="billing_email" value="'.(($user_info && $user_info->email)?$user_info->email:'').'"/>

					<input type="text" name="delivery_name" value="'.(($user_info && $user_info->user_name)?$user_info->user_name:'').'"/>
					<input type="text" name="delivery_address" value="'.(($user_info && $user_info->delivery_address)?$user_info->delivery_address:'').'"/>
					<input type="text" name="delivery_city" value="'.(($user_info && $user_info->city)?$user_info->city:'').'"/>
					<input type="text" name="delivery_state" value="'.(($user_info && $user_info->state)?$user_info->state:'').'"/>
					<input type="text" name="delivery_zip" value="'.(($user_info && $user_info->pincode)?$user_info->pincode:'').'"/>
					<input type="text" name="delivery_country" value="India"/>
					<input type="text" name="delivery_tel" value="'.(($user_info && $user_info->contact_number)?$user_info->contact_number:'').'"/>

					<input type="text" name="customer_identifier" value=""/>
					<input type="text" name="integration_type" value="iframe_normal"/>
					<input type="submit" value="CheckOut">';
			 
		   	 // $returnArr['order_id'] = (($order_info && $order_info->order_id)?$order_info->order_id:'');
		   	 // $returnArr['billing_name'] = (($user_info && $user_info->user_name)?$user_info->user_name:'');
		   	 // $returnArr['billing_address'] = (($user_info && $user_info->delivery_address)?$user_info->delivery_address:'');
		   	 // $returnArr['billing_city'] = (($user_info && $user_info->city)?$user_info->city:'');
		   	 // $returnArr['billing_state'] = (($user_info && $user_info->state)?$user_info->state:'');
		   	 // $returnArr['billing_zip'] = (($user_info && $user_info->pincode)?$user_info->pincode:'');
		   	 // $returnArr['billing_tel'] = (($user_info && $user_info->contact_number)?$user_info->contact_number:'');
		   	 // $returnArr['billing_email'] = (($user_info && $user_info->email)?$user_info->email:'');
		   	 // $returnArr['amount'] = (($order_info && $order_info->total_amount)?$order_info->total_amount:'');
		   	 $returnArr['status'] = 1; 
		   	 $returnArr['html'] = $html;
		   	 $returnArr['msg'] = 'Your order place successfully';
		   }else{
		   	 $returnArr['status'] = 2;
		     $returnArr['msg'] = 'Order can not be placed, Some problem occured please try again';
		   }
		   echo json_encode($returnArr);
		   
	}

	public function ccavRequestHandler(){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		$merchant_data='240382';
		$working_key='A1E8A3441348B601C56C8074734DD675';//Shared by CCAVENUES
		$access_code='AVXE89GL10AD98EXDA';//Shared by CCAVENUES		
		foreach ($_POST as $key => $value){
			$merchant_data.=$key.'='.$value.'&';
		}		
		$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
		//$production_url='https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;		
		$production_url='https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;
		echo '<div style="width:80%; margin: 0 auto;"><iframe src="'.$production_url.'" id="paymentFrame" width="100%" height="100%" frameborder="0" scrolling="No" ></iframe></div>';
		//echo '<script type="text/javascript" src="jquery-1.7.2.js"></script>';
		
	}

	public function ccavResponceHandler(){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	if($_POST["encResp"]){
	$workingKey='A1E8A3441348B601C56C8074734DD675';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_id = "";
	$order_status="";
	$tracking_id = "";
	$user_name = "";
	$user_phone = "";
	$user_email = "";
	$address = "";
	$city = "";
	$state = "";
	$zipcode = "";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==0)	
		$order_id=$information[1];
		if($i==3)	
		$order_status=$information[1];
		if($i==1)
		$tracking_id =$information[1];
		if($i==11)
		$user_name =$information[1];
		if($i==17)
		$user_phone =$information[1];
		if($i==18)
		$user_email =$information[1];
		if($i==12)
		$address =$information[1];
		if($i==13)
		$city =$information[1];
		if($i==14)
		$state =$information[1];
		if($i==15)
		$zipcode =$information[1];
	}

	if($order_status==="Success"){
		$updateData = $this->order_model->updateOrderByOrderId(array('payment_status'=>$order_status,'txn_info'=>json_encode($decryptValues),'tracking_id'=>$tracking_id),$order_id);
		$msg = "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		
	}
	else if($order_status==="Aborted"){
		$updateData = $this->order_model->updateOrderByOrderId(array('payment_status'=>$order_status,'txn_info'=>json_encode($decryptValues),'tracking_id'=>$tracking_id),$order_id);
		$msg = "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
	}
	else if($order_status==="Failure"){
		$updateData = $this->order_model->updateOrderByOrderId(array('payment_status'=>$order_status,'txn_info'=>json_encode($decryptValues),'tracking_id'=>$tracking_id),$order_id);
		$msg ="<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	else{
		$msg = "<br>Security Error. Illegal access detected";
	}

	if($order_status == 'Success' || $order_status == 'Aborted'){
	   	 //*************** SMS send mobile
	   	 $message = 'Thanks for your order. Order ID '.$order_id;
	   	 $getOtpBySms = getOtpBySms($user_phone,$message);
	   	 //*************** Sms send admin
	   	 $allSmsAdmins = $this->users_model->getAdminData('',1);
		 if($allSmsAdmins){
			$message_admin = 'New order has been placed by '.$user_name.'. Order ID '.$order_id;
			foreach ($allSmsAdmins as $key3 => $value3) {
				$phone = $value3->phone;
				$getOtpBySms = getOtpBySms($phone,$message_admin);
			}
		 }
	   	 //************** email send
	   	 $getProductData = getAllCartData($this->cartSessionID);
	   	 $orderData = $this->order_model->getOrderData($order_id);
	   	 $html = 	 '<table style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">
	   	 			  <tr>
					    <th colspan="3" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">
					      <span style="font-size: 14px;display: block;">Order ID : '.$order_id.'</span>
					    </th>
					  </tr>
					  <tr>
					    <th colspan="3" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Delivery Address
					      <span style="font-size: 12px;display: block;">Name : '.$user_name.'</span>
					      <span style="font-size: 12px;display: block;">Email : '.$user_email.'</span>
					      <span style="font-size: 12px;display: block;">Phone : '.$user_phone.'</span>
					      <span style="font-size: 12px;display: block;">Address : '.$address.'</span>
					      <span style="font-size: 12px;display: block;">City : '.$city.'</span>
					      <span style="font-size: 12px;display: block;">State : '.$state.'</span>
					      <span style="font-size: 12px;display: block;">Pincode : '.$zipcode.'</span>
					    </th>
					  </tr>
					  <tr>
					    <th colspan="3" style="border: 1px solid #dddddd;text-align: center;padding: 8px;">Order details are below</th>
					  </tr>';
					  $subtotal = 0;
					  if($getProductData){
					  	foreach ($getProductData as $key => $value){
					  		if($value->product_ratio !=''){
					  		  $name = $value->product_name.'('.$value->product_ratio.')';	
					  		}else{
					  		  $name = $value->product_name;
					  		}
					  		
		 $html .=	 '<tr>
					    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;"><img src="'.productFileExists('uploads/products/'.$value->product_image,$value->product_image).'" style="width:100px;"></td>
					    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$name.'<br>Qty: '.$value->quantity.'</td>
					    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">₨. '.$value->total.'</td>
					  </tr>';
					  $subtotal = $subtotal+$value->total;
					  } }
		 $html .=	 '<tr>
					    <td colspan="2" style="border: 1px solid #dddddd;text-align: right;padding: 8px;">Sub Total</td>
					    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">₨. '.$subtotal.'</td>
					  </tr>';
					  if(isset($orderData->coupon) && !empty($orderData->coupon)){
		 $html .=	  '<tr>
					    <td colspan="2" style="border: 1px solid #dddddd;text-align: right;padding: 8px;">Coupon ('.$orderData->coupon.')</td>
					    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">₨. -'.$orderData->coupon_price.'</td>
					  </tr>';
					  }
		 $html .=	'<tr>
					    <td colspan="2" style="border: 1px solid #dddddd;text-align: right;padding: 8px;">Total Amount</td>
					    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">₨. '.$orderData->total_amount.'</td>
					  </tr> 
					</table>'; 
		$content = $html;

		//************* Send mail user
		$getUserEmailTemplate = $this->db->get_where('email_templates',array('code'=>'order_email','email_for'=>'user','status'=>1))->row();
		if($getUserEmailTemplate){
			$pattern = array('{NAME}','{CONTENT}');
			$replacement = array($user_name,$content);
			$body = str_replace($pattern,$replacement,$getUserEmailTemplate->content);	
			$this->email->from($getUserEmailTemplate->from_email,$getUserEmailTemplate->from_name);
			$this->email->to($user_email);
			if($getUserEmailTemplate->cc_email){
				$this->email->cc($getUserEmailTemplate->cc_email);
			}
			$this->email->set_mailtype('html');
			$this->email->subject($getUserEmailTemplate->subject);
			$this->email->message($body);
			$mail = $this->email->send();
		}

		//************* Send mail all admins
		$allEmailAdmins = $this->users_model->getAdminData(1,'');
		$emails = '';
		if($allEmailAdmins){
			foreach ($allEmailAdmins as $key2 => $value2) {
				$email[] = $value2->email;
				$emails = implode(',', $email);
			}
		}

		$settings = $this->db->get('site_settings')->row();
		$getAdminEmailTemplate = $this->db->get_where('email_templates',array('code'=>'order_email_for_admin','email_for'=>'admins','status'=>1))->row();
		if($getUserEmailTemplate){
			$pattern = array('{CONTENT}');
			$replacement = array($content);
			$body = str_replace($pattern,$replacement,$getAdminEmailTemplate->content);	
			$this->email->from($getAdminEmailTemplate->from_email,$getAdminEmailTemplate->from_name);
			$this->email->to($settings->email);
			if($getAdminEmailTemplate->cc_email){
				$this->email->cc($getAdminEmailTemplate->cc_email);
			}
			if($emails !=''){
				$this->email->bcc($emails);
			}
			$this->email->set_mailtype('html');
			$this->email->subject($getAdminEmailTemplate->subject);
			$this->email->message($body);
			$mail2 = $this->email->send();
		}
	   	 $deleteCart = $this->cart_model->deleteCartDataAfterPlaceOrder($this->cartSessionID);
	   	 $thankyou = base_url().'thankyou?order_id='.$order_id.'&order_status='.$order_status.'&msg='.$msg;
	   	 //redirect($thankyou);
	}else{
		 $thankyou = base_url().'thankyou?order_id='.$order_id.'&order_status='.$order_status.'&msg='.$msg;
	   	 //redirect($thankyou);
	}	
	$data = array('viewPage'=>'payment_success','pageTitle'=>'Singla Sweet | Success','activeMenus'=>array(''));
	$data['order_id'] = $order_id;
	$data['order_status'] = $order_status;
	$data['msg'] = $msg;
	$this->load->view('front/template/default',$data);
    }else{
    	redirect(base_url());
    }
	// echo "<br><br>";

	// echo "<table cellspacing=4 cellpadding=4>";
	// for($i = 0; $i < $dataSize; $i++) 
	// {
	// 	$information=explode('=',$decryptValues[$i]);
	//     	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	// }

	// echo "</table><br>";
	// echo "</center>";
		
	}

	public function orderSuccess(){
		$data = array('viewPage'=>'payment_success','pageTitle'=>'Singla Sweet | Success','activeMenus'=>array(''));
		$data['order_id'] = $this->input->get('order_id');
		$data['order_status'] = $this->input->get('order_status');
		$data['msg'] = $this->input->get('msg');
		$this->load->view('front/template/default',$data);
	}



}
?>