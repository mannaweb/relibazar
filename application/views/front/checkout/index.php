   
<section class="generic-banner relative mb-4">           
        <div class="container">
          <div class="row height align-items-center justify-content-center">
            <div class="col-lg-10">
              <div class="generic-banner-content">
                <h2 class="text-white">Checkout</h2>
                <p class="text-white">It won’t be a bigger problem to find one video game lover in your <br> neighbor. Since the introduction of Virtual Game.</p>
              </div>
            </div>
          </div>
        </div>
      </section>  

<section class="sec-checkout-page">
	<div class="container">
		<form id="place_order">
			<?php $getStoreData = getStoreData();?>
			<input type="hidden" name="store_id" class="form-control" id="store_id" value="<?php echo (($getStoreData && $getStoreData->id)?$getStoreData->id :'')?>">
			<div class="checkout-wrap row">
				<div class="checkout-info col-sm-6 mb-4">
					<h4 class="title"><!-- Billing & Shipping --> Delivery Address</h4>
					<div class="form-content">
						<div class="row form-row">
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">Name</label>
									<input type="text" class="form-control validate" name="user_name" id="user_name" autocomplete="off" data-validate-msg="Nname field is required" placeholder="Enter your Name" value="<?php echo (($user_info && $user_info->name)?$user_info->name:'') ?>" />
								</div>
							</div>
						</div>
						<div class="row form-row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">Email Address</label>
									<input type="email" class="form-control validate" name="user_email" id="user_email" autocomplete="off" data-validate-msg="Email field is required" placeholder="Enter your Email Address" value="<?php echo (($user_info && $user_info->email)?$user_info->email:'') ?>"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">Contact Number</label>
									<input type="text" class="form-control validate" name="user_contact_number" id="user_contact_number" autocomplete="off" data-validate-msg="Contact number field is required" placeholder="Enter your Contact Number" value="<?php echo (($user_info && $user_info->phone)?$user_info->phone:'') ?>"/>
								</div>
							</div>
						</div>
						<div class="row form-row">
							<div class="col">
								<div class="form-group">
									<label class="control-label">Address</label>
									<input type="text" class="form-control validate" name="user_address" id="user_address" data-validate-msg="Address field is required" autocomplete="off" placeholder="Enter your Address" value="<?php echo (($user_info && $user_info->address)?$user_info->address:'') ?>"/>
								</div>
							</div>
						</div>
						<div class="row form-row">
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">City</label>
									<input type="text" class="form-control validate" name="user_city" id="user_city" data-validate-msg="City field is required" autocomplete="off" placeholder="Enter your City" value="<?php echo (($user_info && $user_info->city)?$user_info->city:'') ?>"/>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">State</label>
									<input type="text" class="form-control validate" name="user_state" id="user_state" data-validate-msg="State field is required" autocomplete="off" placeholder="Enter your State" value="<?php echo (($user_info && $user_info->state)?$user_info->state:'') ?>"/>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Pincode</label>
									<input type="text" class="form-control validate" name="user_pincode" id="user_pincode" data-validate-msg="Pincode field is required" autocomplete="off" placeholder="Enter your Pincode"value="<?php echo (($user_info && $user_info->pin_code)?$user_info->pin_code:'') ?>"/>
								</div>
							</div>
						</div>
					</div>
					
					<div class="sec-coupon">
						<div class="title">Have a Coupon?</div>
						<div class="apply-code row">
							<div class="label">If you have a coupon code, please apply it below</div>
							<div class="data col-lg-8">
								<input type="text" class="form-control" autocomplete="off" name="coupon_code" id="coupon_code" />
								
							</div>
							<div class="data col-lg-4">
							<a href="javascript:void(0)" class="genric-btn danger circle arrow cupBtn" onclick="applyCoupon();">Apply Coupon</a>
						   </div>
						</div>
					</div>
				</div>
				<?php $getAllCartData = getAllCartData(get_cookie('session_id'));  ?>
				<div class="checkout-summary col-sm-6 card">
					<div class="cart-container ">
						<div class="cart-header mb-4">
							<h3 class="cart-title text-center">Summary</h3>
						</div>
						<div class="cart-body col-sm-12 mb-4">
							<div class="cart-list">
								<?php
								   $subtotal = 0;
								   if(count($getAllCartData)>0){
								   foreach ($getAllCartData as $cartKey => $cartVal) {
								?>
								<div class="cart-item">
									<div class="title"><?php echo ucwords($cartVal->product_name); ?>
										<?php if($cartVal->product_ratio != NULL){?>
									     <span> (<?php echo $cartVal->product_ratio; ?>)</span>
									    <?php }?>
									</div>
									<div class="item-details">
										<div class="quantity">
											<div class="rate"><?php echo $cartVal->quantity; ?> X ₹<span><?php echo number_format((float)$cartVal->product_price+$cartVal->tax_price, 2, '.', ''); ?></span></div>
											<div class="item-note">Included GST of <?php echo $cartVal->tax; ?>%</div>
										</div>
										<div class="price">₹<span><?php echo number_format((float)$cartVal->total, 2, '.', ''); ?></span></div>
									</div>
								</div>
								<?php
								   $subtotal = $subtotal+$cartVal->total;
								} }?>
							</div>
						</div>
					</div>
					<input type="hidden" name="coupon_price" id="coupon_price" value="0">
					<input type="hidden" name="coupon_discount" id="coupon_discount" value="0">
					<input type="hidden" name="coupon_discount_type" id="coupon_discount_type" value="0">
					<div class="sec-payments">
						<div class="payment-summary col-sm-12 mb-4">
							<div class="discount-summary" style="display:none;">
								<div class="discount">Discount of <span>₹<strong id="couponPrice">00.00</strong></span></div>
								<div class="coupon-code">Coupon Code Applied : <span id="couponCode"></span></div>
							</div>
							<div class="totals">
								<div class="label">
									Payable Total <!-- <span>Included GST of ₹99.99</span> -->
								</div>
								<div class="data">₹<span id="checkout_subtotal"><?php echo number_format((float)$subtotal, 2, '.', ''); ?></span></div>
							</div>
						</div>
						<div class="col-sm-12 mb-4">
							<select class="form-control value" data-validate-msg="Please Select a time slot">
								<option value="">Delivery Time Slot</option>
								<option value="1">9.00AM - 9.00PM</option>
								<option value="2">After 9.00PM</option>
							</select>
						</div>
						<div class="actions col-sm-12">
							<a href="javascript:void(0)" class="genric-btn danger circle arrow payButton">Proceed to Pay</a>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div id="paymentForm" style="width:80%; margin: 0 auto;">
			<script>
				window.onload = function() {
					var d = new Date().getTime();
					document.getElementById("tid").value = d;
				};
			</script>
			<form method="post" id="customerData" name="customerData" action="<?php echo base_url().'payment'; ?>" style="display: none;">
			  <input type="text" name="tid" id="tid" readonly />

			</form>
		</div>
	</div>
</section>