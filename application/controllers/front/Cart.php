<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('front/cart_model');
		$this->load->model('front/products_model');
		$this->load->model('front/users_model');
		$this->cartSessionID = get_cookie('session_id');
	}

	public function index(){
		$data = array('viewPage'=>'cart/index','pageTitle'=>'Singla Sweet | Cart','activeMenus'=>array('checkout'));
		$this->load->view('front/template/default',$data);
	}


	public function addToCart(){
	  $pageData = array();
	  $data = $this->input->post();
	  $data['productData'] = $this->products_model->getDataByID($data['product_id']);
	  if(isset($data['productData']->product_type) && $data['productData']->product_type ==1){
	  	$checkCart = $this->cart_model->getCartData($this->cartSessionID,$data['product_id'],$data['productData']->product_type);
	  }else{
	  	$checkCart = $this->cart_model->getCartData($this->cartSessionID,$data['product_id'],$data['productData']->product_type,$data['key']);
	  }	  
	  if($checkCart){
	  	$updateCart = $this->cart_model->updateCartData($data,$checkCart->id);
	  	if($updateCart){	  	  
	  	  $pageData['cartVal'] = $this->cart_model->getCartDataByID($updateCart);
	  	  $pageData['type']	= 'html';
	  	  $returnArr['type'] ='html';
	  	  $returnArr['countCart'] = $this->cart_model->countCart($this->cartSessionID);
	  	  $subtotal = $this->cart_model->countCartPrice($this->cartSessionID);
	  	  $returnArr['subtotal'] = $subtotal->total;
	  	  $returnArr['cart_id'] = $updateCart;
	  	  $returnArr['html'] = $this->load->view('front/cart/li_list',$pageData,true);
	  	}
	  }else{	  	
	  	$data['session_id'] = $this->cartSessionID;
	  	$storeCart = $this->cart_model->storeCartData($data);
	  	if($storeCart){
	  	  $pageData['cartVal'] = $this->cart_model->getCartDataByID($storeCart);
	  	  $pageData['type']	= 'appened';	  
	  	  $returnArr['type'] ='appened';
	  	  $returnArr['countCart'] = $this->cart_model->countCart($this->cartSessionID);
	  	  $subtotal = $this->cart_model->countCartPrice($this->cartSessionID);
	  	  $returnArr['subtotal'] = $subtotal->total;
	  	  $returnArr['html'] = $this->load->view('front/cart/li_list',$pageData,true);
	  	}
	  }
	  echo json_encode($returnArr);	  
	}

	public function cartQuantityManage(){
		$data = $this->input->post();
		$data['productData'] = $this->products_model->getDataByID($data['product_id']);
		$updateCart = $this->cart_model->updateCartData($data,$data['cart_id']);
		if($updateCart){	  	  
	  	  $pageData['cartVal'] = $this->cart_model->getCartDataByID($updateCart);
	  	  $pageData['type']	= 'html';
	  	  $returnArr['type'] ='html';
	  	  $returnArr['countCart'] = $this->cart_model->countCart($this->cartSessionID);
	  	  $returnArr['cart_id'] = $updateCart;
	  	  $subtotal = $this->cart_model->countCartPrice($this->cartSessionID);
	  	  $returnArr['subtotal'] = $subtotal->total;
	  	  $returnArr['html'] = $this->load->view('front/cart/li_list',$pageData,true);
	  	}
	  	echo json_encode($returnArr);
	}	

	public function cartItemDelete(){
		$cart_id = $this->input->post('cart_id');
		$delete = $this->cart_model->deleteCartData($cart_id);
		if($delete){
			$returnArr['cart_id'] = $cart_id; 
			$returnArr['success'] = 'true'; 
			$returnArr['countCart'] = $this->cart_model->countCart($this->cartSessionID);
			$subtotal = $this->cart_model->countCartPrice($this->cartSessionID);
	  	    $returnArr['subtotal'] = $subtotal->total;
		}else{
			$returnArr['cart_id'] = ''; 
			$returnArr['success'] = 'false';
			$returnArr['countCart'] = $this->cart_model->countCart($this->cartSessionID);
			$subtotal = $this->cart_model->countCartPrice($this->cartSessionID);
	  	    $returnArr['subtotal'] = $subtotal->total;
		}
		echo json_encode($returnArr);
	}

	public function checkout(){
		$countCart = $this->cart_model->countCart($this->cartSessionID);
		//if($this->session->userdata('id') && ($countCart>0)){
			$data = array('viewPage'=>'checkout/index','pageTitle'=>'Singla Sweet | Checkout','activeMenus'=>array('checkout'),'jsFiles'=>array('order'));
			$user_id = $this->session->userdata('id');
			$data['user_info'] = $this->users_model->getUserData($user_id);
		    $this->load->view('front/template/default',$data);
		// }else{
		// 	redirect(base_url());
	 //    }
	}

	public function applyCoupon(){
		$coupon = $this->input->post('coupon_code');
		$checkCouponData = $this->cart_model->getCoupon($coupon);
		if($checkCouponData){
		   $subtotal = $this->cart_model->countCartPrice($this->cartSessionID);
		   if($checkCouponData->discount_type == 1){
		   	 $discountPrice = (($subtotal->total*$checkCouponData->discount)/100);
		   	 $returnArr['discountPrice'] = base64_encode(number_format((float)$discountPrice, 2, '.', ''));
		   	 $returnArr['coupon'] = base64_encode($coupon);
		   	 $returnArr['discount'] = base64_encode($checkCouponData->discount);
		   	 $returnArr['discountType'] = base64_encode('percentage');
		   	 $returnArr['subtotal'] = base64_encode(number_format((float)$subtotal->total-$discountPrice, 2, '.', ''));
		   }else{
		   	 $discountPrice = $checkCouponData->discount;
		   	 $returnArr['discountPrice'] =base64_encode(number_format((float)$discountPrice, 2, '.', '')) ;
		   	 $returnArr['coupon'] = base64_encode($coupon);
		   	 $returnArr['discount'] = base64_encode($checkCouponData->discount);
		   	 $returnArr['discountType'] = base64_encode('fixed');
		   	 $returnArr['subtotal'] = base64_encode(number_format((float)$subtotal->total-$discountPrice, 2, '.', ''));
		   }
		   $returnArr['status'] = 1; 
		}else{
		   $returnArr['status'] = 2;
		   $returnArr['msg'] = 'Invalid coupon code';
		}
		echo json_encode($returnArr);
		
	}

}
?>