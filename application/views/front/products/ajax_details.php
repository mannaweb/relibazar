
<?php if($productDetails->product_type == 1){
    	//$tax = (($productDetails->selling_price*$productDetails->tax)/100);
        $price = $productDetails->selling_price;
        $min_weight ='';
        $parm = '';
    }else if($productDetails->product_type == 2){
   		$jsonPrice = json_decode($productDetails->selling_price,true);
   		$min_weight = min($jsonPrice['weight']);
        $min_price = min($jsonPrice['price']);
        //$tax = (($min_price*$productDetails->tax)/100);
        $price = $min_price;
        $foreachData = $jsonPrice['weight'];
        $parm = 'gm';
    }else if($productDetails->product_type == 3){
   		$jsonPrice = json_decode($productDetails->selling_price,true);
   		$min_weight = min($jsonPrice['piece']);
        $min_price = min($jsonPrice['price']);
        //$tax = (($min_price*$productDetails->tax)/100);
        $price = $min_price;
        $foreachData = $jsonPrice['piece'];
        $parm = 'pc';
    } ?>


<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<div class="modal-body">
			<div class="modal-layout">
				<div class="modal-left">
					<div class="carousel slide gal-slider" id="gal-slider" data-ride="carousel">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<img src="<?php echo productFileExists('uploads/products/'.$productDetails->image,$productDetails->image);?>" title="">
							</div>
							
							<?php if(count($productgalery)>0){
                                  foreach ($productgalery as $key => $value) { ?>
                                  	<div class="carousel-item">
                                  	<img src="<?php echo base_url('uploads/products/gallery/'.$value->image);?>" title=""></div>
                                  <?php } } ?>
                          <?php if(count($productgalery)>0){ ?>
							<a class="carousel-control-prev" href="#gal-slider" role="button" data-slide="prev"><i class="fal fa-chevron-left"></i></a>
							<a class="carousel-control-next" href="#gal-slider" role="button" data-slide="next"><i class="fal fa-chevron-right"></i></a>
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="modal-right">
					<div class="details-content">
						<h4 class="title"><?php echo $productDetails->name; ?></h4>
						<div class="details-info">
							<?php if($productDetails->product_type == 1){ ?>
							<div class="item">
								<div class="label">Price</div>
								<div class="data">₹<?php echo $productDetails->selling_price; ?>
								</div>
							</div>
							<?php } else { ?>
              <div class="item">
							<div class="label">Price</div>
							<?php 
				foreach($foreachData as $jkey => $jweight){
					//$rowTax = (($jsonPrice['price'][$jkey]*$productDetails->tax)/100);
					$rowPrice = $jsonPrice['price'][$jkey];
				?>
				      <div class="data">₹<?php echo number_format((float)$rowPrice, 2, '.', ''); ?> (<?php echo gmTokg($jweight,$parm); ?>) </div>
				  <?php } ?>
                   
						</div>
							<?php } ?>


							
							
							
							<div class="item">
								<div class="label">Category</div>
								<div class="data">
									<?php echo $impCat; ?>
								</div>
							</div>
							<div class="item full">
								<div class="label">Description</div>
								<div class="data">
									<?php echo $productDetails->long_description; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-content">
						<h4 class="title">Enquiry</h4>
						<form action="javascript:void(0)" id="enquiryForm">
							<input type="hidden" name="product_id" value="<?php echo $productDetails->id; ?>">
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label class="control-label">Name</label>
										<input type="text" name="name" class="form-control validate" data-validate-msg="Name field is required" placeholder="Please Enter Name">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label">Email</label>
										<input type="text" name="email" class="form-control validate" data-validate-msg="Email field is required" placeholder="Please Enter Email">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="control-label">Phone</label>
										<input type="text" name="phone" class="form-control validate" data-validate-msg="Phone field is required" placeholder="Please Enter Phone">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label class="control-label">Message</label>
										<textarea class="form-control" name="message" id="message" placeholder="Message.."></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group text-center mt-3">
										<button class="btn-submit" onclick="saveEnquiry()">Submit</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>