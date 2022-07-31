<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($coupons && $coupons->id)?'Edit Coupon':'Add Coupon'?></h6></div>
      <div class="col-sm-6 text-right">
        <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
        <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form class="user" id="manageForm">
    	<div class="row">
				<input type="hidden" name="id" value="<?php echo ($coupons && $coupons->id)?$coupons->id:''?>">
               	<input type="hidden" name="start_date" value="<?php echo date('Y-m-d H:i:s'); ?>">
				<div class="col-lg-8 col-xl-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Coupon Code</label>
								<input type="text" class="form-control validate" autocomplete="off" name="code" id="code" data-validate-msg="Coupon Code field is required"  placeholder="Enter Coupon Code" value="<?php echo ($coupons && $coupons->code)?$coupons->code:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Discount Type</label>
								<select class="form-control select2" name="discount_type" id="discount_type" onchange="discount_typ(this.value)">
									<option value="1" <?php if(isset($coupons->discount_type) && $coupons->discount_type ==1){ echo 'selected';} ?>>Percentage</option>
									<option value="2" <?php if(isset($coupons->discount_type) && $coupons->discount_type ==2){ echo 'selected';} ?>>Fixed</option>
								</select>
							</div> 
						</div>
					</div>
					<div class="row">
                    
						<div class="col-md-6">
								<div class="form-group">
								<label class="control-label required">Coupon Amount</label>
								<input type="text" class="form-control validate" autocomplete="off" name="discount" id="discount" data-validate-msg="Coupon Amount field is required"  placeholder="Enter Coupon Amount" value="<?php echo ($coupons && $coupons->discount)?$coupons->discount:''?>">
							</div>
						</div>

						<div class="col-md-6">
								<div class="form-group">
								<label class="control-label required">Expire Date</label>
								<input type="text" class="form-control validate" autocomplete="off" name="end_date" id="expire_date" data-validate-msg="Expire Date field is required"  placeholder="Enter Expire Date" value="<?php echo ($coupons && $coupons->end_date)?date('m/d/y',strtotime($coupons->end_date)):''?>" readonly>
							</div>
						</div>
					</div>
                   <div class="products_div">
					<?php 


						$pro_id = array();
						if(isset($coupons->product_ids) && !empty($coupons->product_ids)){
							$pro_id = explode(',', $coupons->product_ids);
						}
					?>
                      <div class="row">
                      	<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Products</label>
								<select name="product[]" class="form-control select2 <?php if(isset($coupons->discount_type) && $coupons->discount_type == 3){ echo 'validate';} ?>" data-validate-msg="Please select Product" multiple="multiple">
									<option value="0" <?php if(isset($coupons->product_ids) && $coupons->product_ids == 0){ echo 'selected';} ?>>All Products</option>
									<?php if($all_pro){ foreach ($all_pro as $value) { ?>
									<option value="<?php echo $value->id; ?>" <?php if(isset($coupons->product_ids) && in_array($value->id,$pro_id)){ echo "selected";} ?>><?php echo $value->name; ?></option>
									<?php } } ?>             
								</select>
							</div>
						</div>
					</div>

					
                    </div>
					<div class="row">
						<div class="col text-right">
							<button class="btn btn-primary saveButton" type="button">Save</button>
							<button class="btn btn-danger cancelButton" type="button">Cancel</button>
						</div>
					</div>
				</div>
			</div>
    </form>
  </div>
</div>