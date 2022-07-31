<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($admins && $admins->id)?'Edit Admin':'Add Admin'?></h6></div>
      <div class="col-sm-6 text-right">
        <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
        <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form class="user" id="manageForm">
    	<div class="row">
    		<div class="col-lg-4 col-xl-3">
					<input type="hidden" name="id" value="<?php echo ($admins && $admins->id)?$admins->id:''?>">
					
					<input type="hidden" name="profile_image" value="<?php echo ($admins && $admins->profile_image)?$admins->profile_image:''?>">
					<?php $getUserDetails = getUserDetails($this->session->userdata('user_id')) ?>
					<div class="profile-image">
						<div class="img-container">
							<?php if(isset($getUserDetails->profile_image) && file_exists($getUserDetails->profile_image)){ ?>
							<img src="<?php echo base_url().$getUserDetails->profile_image;?>" class="upic" alt=""/>
						<?php }else{ ?>
							<img src="<?php echo base_url().'assets/admin/img/user-default.png';?>" class="upic" alt=""/>
						<?php } ?>
						</div>
						<input type="file" id="image" class="input-file" name="image" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="image" id="upBtn2"><span class="fas fa-camera"></span></label>
					</div>
				</div>
				<div class="col-lg-8 col-xl-9">


					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Name</label>
								<input type="text" class="form-control validate" id="name" name="name" data-validate-msg="Name field is required"  placeholder="Enter Name" value="<?php echo ($admins && $admins->name)?$admins->name:''?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Email Address</label>
								<input type="text" class="form-control validate" id="email" name="email" data-validate-msg="Email field is required"  placeholder="Enter Email Address" value="<?php echo ($admins && $admins->email)?$admins->email:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Password</label>
								<input type="password" class="form-control <?php echo ($admins && $admins->password)?'':'validate'?>" name="password" id="password" data-validate-msg="Password field is required"  placeholder="Enter Password" >
							</div> 
						</div>

						<?php if($this->session->userdata('role') == 'vendor'){ ?>
                            <input type="hidden" name="role" value="vendor">
						<?php } else {?>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Role</label>
								<div class="custom-checkbox">
									<input type="radio" class="custom-input validate" id="admin" name="role" value="admin" data-validate-msg="Please select tax status"  <?php if($admins && $admins->role =='admin'){ echo 'checked';}?>>
									<label class="custom-label" for="email_notification">Admin</label>
								</div>	

								<div class="custom-checkbox">
									<input type="radio" class="custom-input validate" id="vendor" name="role" value="vendor" data-validate-msg="Please select tax status"  <?php if($admins && $admins->role =='vendor'){ echo 'checked';}?>>
									<label class="custom-label" for="email_notification">Vendor</label>
								</div>								
							</div>
						</div>
                          <?php  } ?>

						
					</div>
					<div class="row">
						<div class="col text-right">
							<button class="btn btn-primary saveButton" type="button" >Save</button>
							<button class="btn btn-danger cancelButton" type="button">Cancel</button>
						</div>
					</div>
				</div>
			</div>
    </form>
  </div>
</div>