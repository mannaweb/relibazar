<section class="generic-banner relative">						
				<div class="container">
					<div class="row height align-items-center justify-content-center">
						<div class="col-lg-10">
							<div class="generic-banner-content">
								<h2 class="text-white">Cart</h2>
								<p class="text-white">It won’t be a bigger problem to find one video game lover in your <br> neighbor. Since the introduction of Virtual Game.</p>
							</div>
						</div>
					</div>
				</div>
			</section>		
			




<section class="top-dish-area section-gap" id="dish">
<div class="container">
					
					<div class="px-4 px-lg-0">
 <div class="pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="border-0 bg-light">
                    <div class="p-2 px-3 text-uppercase">Product</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Price</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Quantity</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Total Price</div>
                  </th>
                </tr>
              </thead>
              <tbody id="cart_appened_div">
              	<?php
			   $getAllCartData = getAllCartData(get_cookie('session_id'));
			   $subtotal = 0;
			   if(count($getAllCartData)>0){
			   foreach ($getAllCartData as $cartKey => $cartVal) {?>
                <tr id="cart_li_<?php echo $cartVal->id; ?>">
                  <th scope="row" class="border-0">
                    <div class="p-2">
                      <img src="<?php echo productFileExists('uploads/products/'.$cartVal->product_image,$cartVal->product_image);?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                      <div class="ml-3 d-inline-block align-middle">
                        <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle"><?php echo ucwords($cartVal->product_name); ?></a></h5><span class="text-muted font-weight-normal font-italic d-block">Category: Watches</span>
                      </div>
                    </div>
                  </th>
                  <td class="border-0 align-middle"><strong><?php echo number_format((float)$cartVal->product_price, 2, '.', ''); ?></strong></td>
                  <td class="border-0 align-middle"><strong><div class="number-spinner" data-id="<?php echo $cartVal->id; ?>">
								<button class="btn" data-dir="dwn" id="<?php echo $cartVal->id; ?>"><span class="fal fa-minus-circle"></span></button>
								<input type="text" class="formcontrol" id="formcontrol_<?php echo $cartVal->id; ?>" value="<?php echo $cartVal->quantity; ?>" readonly>
								<input type="hidden" name="pid" class="pid" id="pid_<?php echo $cartVal->id; ?>" value="<?php echo $cartVal->product_id; ?>">
								<input type="hidden" name="key" class="key" id="key_<?php echo $cartVal->id; ?>" value="<?php echo $cartVal->price_key; ?>">
								<button class="btn" data-dir="up" id="<?php echo $cartVal->id; ?>"><span class="fal fa-plus-circle"></span></button>
							</div></strong></td>
                  <td class="border-0 align-middle"><?php echo number_format((float)$cartVal->total, 2, '.', ''); ?></td>
                </tr>
              <?php
			   $subtotal = $subtotal+$cartVal->total;
			    } }?>
                <tr>
                	<td colspan="4" style="text-align: right;"><div class="cart-total" id="subTotal"><span>Total</span>₹<?php echo number_format((float)$subtotal, 2, '.', ''); ?></div></td>
                </tr>
              </tbody>
            </table>
            <div class="cart-footer" id="checkout_div" <?php if(count($getAllCartData)>0){?> style="display: flex;" <?php }else{?> style="display: none;" <?php }?>> 
			<?php
			$redirectUrl = base_url().'checkout';
			 // if($this->session->userdata('id')){
			 // 	$redirectUrl = base_url().'checkout';
			 // }else{
			 // 	$redirectUrl = base_url().'signin';
			 // }
			?>
			
			<a href="<?php echo $redirectUrl; ?>" class="btn btn-success">Checkout <i class="far fa-long-arrow-alt-right"></i></a>
		</div>
          </div>
          <!-- End -->
        </div>
      </div>

     <!--  <div class="row py-5 p-4 bg-white rounded shadow-sm">
        <div class="col-lg-6">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
          <div class="p-4">
            <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
            <div class="input-group mb-4 border rounded-pill p-2">
              <input type="text" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0">
              <div class="input-group-append border-0">
                <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Apply coupon</button>
              </div>
            </div>
          </div>
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div>
          <div class="p-4">
            <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
            <textarea name="" cols="30" rows="2" class="form-control"></textarea>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
          <div class="p-4">
            <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
            <ul class="list-unstyled mb-4">
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong>$390.00</strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping and handling</strong><strong>$10.00</strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong>$0.00</strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                <h5 class="font-weight-bold">$400.00</h5>
              </li>
            </ul><a href="#" class="btn btn-dark rounded-pill py-2 btn-block">Procceed to checkout</a>
          </div>
        </div>
      </div> -->

    </div>
  </div>
</div>

				</div>	
			</section>
			<!-- End top-dish Area -->