<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

    public function getCartData($session_id='',$product_id='',$product_type='',$price_key=''){
		$this->db->select('*');
		$this->db->from('cart');
		$this->db->where('session_id',$session_id);
		$this->db->where('product_id',$product_id);
		if($product_type !=''){
		  if($product_type ==1){
		  	$this->db->where('product_type',$product_type);
		  }else{
		  	$this->db->where('product_type',$product_type);
		  	$this->db->where('price_key',$price_key);
		  }		  	
		}
		$query = $this->db->get();
		return $query->row();
	}

	public function countCart($session_id=''){
		$this->db->select('*');
		$this->db->from('cart');
		$this->db->where('session_id',$session_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function countCartPrice($session_id=''){
		$this->db->select_sum('total');
		$this->db->from('cart');
		$this->db->where('session_id',$session_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getCartDataByID($cart_id=''){
		$this->db->select('*');
		$this->db->from('cart');
		$this->db->where('id',$cart_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function storeCartData($data = array()){
		$taxPrice = 0;
		if(isset($data['productData']->product_type) && $data['productData']->product_type == 1){
			if(isset($data['productData']->tax_status) && $data['productData']->tax_status ==1){
			  $taxPrice = (($data['productData']->selling_price*$data['productData']->tax)/100);
		    }else{
		    	$jsonPrice = json_decode($data['productData']->selling_price,true);
				$taxPrice = $jsonPrice['price'][$data['key']];
			}	
		    $totalTax = $taxPrice;
		    $product_price = $data['productData']->selling_price;
		    $totalPrice = ($product_price);
		    $price_key = NULL;
		    $product_ratio = NULL;
		}else{
			if(isset($data['productData']->tax_status) && $data['productData']->tax_status ==1){
			  $jsonPrice = json_decode($data['productData']->selling_price,true);
			  $taxPrice = (($jsonPrice['price'][$data['key']]*$data['productData']->tax)/100);
		    }else{
		    	$jsonPrice = json_decode($data['productData']->selling_price,true);
				$taxPrice = $jsonPrice['price'][$data['key']];
			}
		   $totalTax = $taxPrice;
		    $product_price = $jsonPrice['price'][$data['key']];
		    $totalPrice = ($product_price);
		    $price_key = $data['key'];
		    if(isset($data['productData']->product_type) && $data['productData']->product_type == 2){
		    	$product_ratio = gmTokg($jsonPrice['weight'][$data['key']],'gm'); //$jsonPrice['weight'][$data['key']].'gm';
		    }else{
		    	$product_ratio = gmTokg($jsonPrice['weight'][$data['key']],'pc');
		    }
		    
		}
		$storeData = array('user_id'=>$this->session->userdata('id'),'session_id'=>$data['session_id'],'product_id'=>$data['product_id'],'product_name'=>$data['productData']->name,'product_image'=>$data['productData']->image,'product_price'=>$product_price,'tax_price'=>$totalTax,'quantity'=>1,'total'=>$totalPrice,'product_type'=>$data['productData']->product_type,'tax'=>$data['productData']->tax,'price_key'=>$price_key,'product_ratio' =>$product_ratio,'created_at'=>date('Y-m-d h:i:s'));
		$this->db->insert('cart',$storeData);
		return $this->db->insert_id();
	}

	public function updateCartData($data = array(),$cart_id=''){
		$checkData = $this->db->get_where('cart',array('id'=>$cart_id))->row();
		$taxPrice = 0;
		if(isset($data['productData']->product_type) && $data['productData']->product_type == 1){
			if(isset($data['productData']->tax_status) && $data['productData']->tax_status ==1){
				$taxPrice = (($data['productData']->selling_price*$data['productData']->tax)/100);
			}else{
				$taxPrice = $data['productData']->selling_price;
			}
			if(isset($data['quantity']) && !empty($data['quantity'])){
				$totalQuantity = $data['quantity'];
			}else{
				$totalQuantity = $checkData->quantity+1;
			}		
			$productPrice = $data['productData']->selling_price;
			$totalTax = $taxPrice;
			$totalPrice = ($productPrice*$totalQuantity);
		}else{
			if(isset($data['productData']->tax_status) && $data['productData']->tax_status ==1){
				$jsonPrice = json_decode($data['productData']->selling_price,true);
				$taxPrice = (($jsonPrice['price'][$data['key']]*$data['productData']->tax)/100);
			}else{
				$jsonPrice = json_decode($data['productData']->selling_price,true);
				$taxPrice = $jsonPrice['price'][$data['key']];
			}
			if(isset($data['quantity']) && !empty($data['quantity'])){
				$totalQuantity = $data['quantity'];
			}else{
				$totalQuantity = $checkData->quantity+1;
			}		
			$productPrice = $jsonPrice['price'][$data['key']];
			$totalTax = $taxPrice;
			$totalPrice = ($productPrice*$totalQuantity);
		}
		  
		$updateData = array('product_name'=>$data['productData']->name,'product_image'=>$data['productData']->image,'product_price'=>$productPrice,'tax_price'=>$totalTax,'quantity'=>$totalQuantity,'total'=>$totalPrice,'product_type'=>$data['productData']->product_type,'tax'=>$data['productData']->tax,'modified_at'=>date('Y-m-d h:i:s'));
		 $this->db->where('id',$cart_id)->update('cart',$updateData);
		 return $cart_id;
	}

	public function deleteCartData($cart_id=''){
		return $delete = $this->db->where('id',$cart_id)->delete('cart');
	}

	public function deleteCartDataAfterPlaceOrder($session_id=''){
		return $delete = $this->db->where('session_id',$session_id)->delete('cart');
	}

	//***************** Use for coupon 

	public function getCoupon($coupon=''){
		$this->db->select('*');
		$this->db->from('coupons');
		$this->db->where('status',1);
		$this->db->where('code',$coupon);
		$this->db->where("(DATE_FORMAT(start_date,'%Y-%m-%d') <='".date('Y-m-d')."' AND DATE_FORMAT(end_date,'%Y-%m-%d') >='".date('Y-m-d')."')");
		$query = $this->db->get();
		return $query->row();
	}

	public function storeOrder($data=array()){
		$this->db->insert('orders',$data);
		return $this->db->insert_id();
	}

	public function updateOrder($data=array(),$id){
		return $this->db->where('id',$id)->update('orders',$data);
	}

}
?>