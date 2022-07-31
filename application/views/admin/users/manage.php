<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($users && $users->id)?'Edit User':'Add User'?></h6></div>
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
					<input type="hidden" name="id" value="<?php echo ($users && $users->id)?$users->id:''?>">
					<input type="hidden" name="usertype" value="<?php echo ($users && $users->usertype)?$users->usertype:'user'?>">
					<input type="hidden" name="profile" value="<?php echo ($users && $users->profile)?$users->profile:''?>">
					<div class="profile-image">
						<div class="img-container">
							<img src="<?php echo getUserDetails( (($users && $users->id)?$users->id:''),'profile');?>" class="upic" alt=""/>
						</div>
						<input type="file" id="image" class="input-file" name="image" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="image" id="upBtn2"><span class="fas fa-camera"></span></label>
					</div>
				</div>
				<div class="col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">First Name</label>
								<input type="text" class="form-control validate" autocomplete="off" id="firstname" name="firstname" data-validate-msg="First Name field is required"  placeholder="Enter First Name" value="<?php echo ($users && $users->firstname)?$users->firstname:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Last Name</label>
								<input type="text" class="form-control validate" autocomplete="off" id="lastname" name="lastname" data-validate-msg="Last Name field is required"  placeholder="Enter Last Name" value="<?php echo ($users && $users->lastname)?$users->lastname:''?>">
							</div> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Email Address</label>
								<input type="text" class="form-control validate" autocomplete="off" id="email" name="email" data-validate-msg="Email field is required"  placeholder="Enter Email Address" value="<?php echo ($users && $users->email)?$users->email:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Password</label>
								<input type="password" class="form-control <?php echo ($users && $users->password)?'':'validate'?>" id="password" autocomplete="off" name="password" data-validate-msg="Password field is required"  placeholder="Enter Password" value="">
							</div> 
						</div>
						
					</div>
					<?php 
					if($users){
						$socialnetwork = json_decode($users->socialnetwork);
					}else{
						$socialnetwork = '';
					}
					?>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Facebook</label>
								<input type="text" class="form-control validate urlValidation" autocomplete="off" name="facebook" data-validate-msg="Facebook URL field is required"  placeholder="Facebook URL" value="<?php echo isset($socialnetwork->facebook)?$socialnetwork->facebook:'' ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Google</label>
								<input type="text" class="form-control validate urlValidation" autocomplete="off" name="google" data-validate-msg="Google URL field is required"  placeholder="Google URL" value="<?php echo isset($socialnetwork->google)?$socialnetwork->google:'' ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Linkedin</label>
								<input type="text" class="form-control validate urlValidation" autocomplete="off" name="linkedin" data-validate-msg="LinkedIn URL field is required"  placeholder="LinkedIn URL" value="<?php echo isset($socialnetwork->linkedin)?$socialnetwork->linkedin:'' ?>">
							</div>
						</div>
						<div class="col-md-6">          
							<div class="form-group">
								<label class="control-label">Twitter</label>
								<input type="text" class="form-control validate urlValidation" autocomplete="off" name="twitter" data-validate-msg="Twitter URL field is required"  placeholder="Twitter URL" value="<?php echo isset($socialnetwork->twitter)?$socialnetwork->twitter:'' ?>">
							</div>
						</div>
					 </div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Youtube</label>
								<input type="text" class="form-control validate urlValidation" autocomplete="off" name="youtube" data-validate-msg="Youtube URL field is required"  placeholder="Youtube URL" value="<?php echo isset($socialnetwork->youtube)?$socialnetwork->youtube:'' ?>">
							</div>
						</div>
						<div class="col-md-6">          
							<div class="form-group">
								<label class="control-label">Instragram</label>
								<input type="text" class="form-control validate urlValidation" autocomplete="off" name="instagram" data-validate-msg="Instagram URL field is required"  placeholder="Instagram URL" value="<?php echo isset($socialnetwork->instagram)?$socialnetwork->instagram:'' ?>">
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