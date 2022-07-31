<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($stores && $stores->id)?'Edit Store':'Add Store'?></h6></div>
      <div class="col-sm-6 text-right">
        <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
        <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form class="user" id="manageForm">
    	<div class="row">
				<input type="hidden" name="id" value="<?php echo ($stores && $stores->id)?$stores->id:''?>">
				<div class="col-lg-8 col-xl-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Store Name</label>
								<input type="text" class="form-control validate" autocomplete="off" name="name" id="name" data-validate-msg="Name field is required"  placeholder="Enter Store Name" value="<?php echo ($stores && $stores->name)?$stores->name:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Address</label>
								<input type="text" class="form-control validate" autocomplete="off" name="address" id="autocomplete" data-validate-msg="Address field is required"  placeholder="Enter Store Address" value="<?php echo ($stores && $stores->address)?$stores->address:''?>">
							</div> 
						</div>
					</div>
					<div class="row">
                    
						<div class="col-md-6">
								<div class="form-group">
								<label class="control-label required">City</label>
								<input type="text" class="form-control validate" autocomplete="off" name="city" id="locality" data-validate-msg="City field is required"  placeholder="Enter City" value="<?php echo ($stores && $stores->city)?$stores->city:''?>">
							</div>
						</div>

						<div class="col-md-6">
								<div class="form-group">
								<label class="control-label required">State</label>
								<input type="text" class="form-control validate" autocomplete="off" name="state" id="administrative_area_level_1" data-validate-msg="State field is required"  placeholder="Enter State" value="<?php echo ($stores && $stores->state)?$stores->state:''?>">
							</div>
						</div>



						<div class="col-md-6">
								<div class="form-group">
								<label class="control-label required">Country</label>
								<input type="text" class="form-control validate" autocomplete="off" name="country" id="country" data-validate-msg="Country  field is required"  placeholder="Enter State" value="<?php echo ($stores && $stores->country)?$stores->country:''?>">
							</div>
						</div>

						<div class="col-md-6">
								<div class="form-group">
								<label class="control-label required">Pin Code</label>
								<input type="text" class="form-control validate" autocomplete="off" name="pincode" id="postal_code" data-validate-msg="Pincode field is required"  placeholder="Enter Pincode" value="<?php echo ($stores && $stores->pincode)?$stores->pincode:''?>">
							</div>
						</div>



						<div class="col-md-6">
								<div class="form-group">
								<label class="control-label required">Lat</label>
								<input type="text" class="form-control " autocomplete="off" name="lat" id="lat" data-validate-msg="Lat field is required"  value="<?php echo ($stores && $stores->lat)?$stores->lat:''?>" readonly>
							</div>
						</div>


                        <div class="col-md-6">
								<div class="form-group">
								<label class="control-label required">Long</label>
								<input type="text" class="form-control" autocomplete="off" name="long" id="long" data-validate-msg=" field is required"   value="<?php echo ($stores && $stores->long)?$stores->long:''?>" readonly>
							</div>
						</div>

                       <input type="hidden" name="longitude" id="longitude" value="">
                    <input type="hidden" name="latitude" id="latitude" value="">

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