<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto"><?php echo ($settings_info && $settings_info->id)?'Edit Settings':'Add Settings'?></h6>
			</div>
			<div class="col-sm-6 text-right">
				<button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
				<button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<form class="user" id="manageForm">
			<div class="row">
				<div class="col-md-6 col-lg-4 col-xl-3">
					<input type="hidden" name="logo" value="<?php echo ($settings_info && $settings_info->logo)?$settings_info->logo:''?>">
					<div class="profile-image img-square">
						<div class="img-container">
							<img src="<?php echo settingsFileExists( (($settings_info && $settings_info->logo)?$settings_info->logo:''),(($settings_info && $settings_info->logo)?$settings_info->logo:'') );?>" class="upic" alt=""/>
						</div>
						<input type="file" id="image" class="input-file" name="logo" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="image" id="upBtn2"><span class="fas fa-camera"></span></label>
					</div>
				</div>
				<div class="col-md-12 col-lg-8 col-xl-9">
					<input type="hidden" name="id" value="<?php echo ($settings_info && $settings_info->id)?$settings_info->id:''?>">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Title</label>
								<input type="text" class="form-control validate" autocomplete="off" name="title" data-validate-msg="Title field is required"  placeholder="Enter Title" value="<?php echo ($settings_info && $settings_info->title)?$settings_info->title:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Contact Email</label>
								<input type="text" class="form-control validate" autocomplete="off" name="email" data-validate-msg="Contact Email field is required"  placeholder="Enter Contact Email" value="<?php echo ($settings_info && $settings_info->email)?$settings_info->email:''?>">
							</div> 
						</div>						
						
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label ">Phone</label>
								<input type="text" class="form-control " autocomplete="off" name="phone" data-validate-msg="Phone field is required"  placeholder="Enter Phone" value="<?php echo ($settings_info && $settings_info->phone)?$settings_info->phone:''?>">
							</div> 
						</div>
					</div>
					<div class="row">
						<?php if($social_logins){
							$social_links = ($settings_info && $settings_info->social_links)?json_decode($settings_info->social_links,true):array();
							foreach($social_logins as $val){?>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label "><?php echo $val->name;?> Link</label>
										<input type="text" class="form-control " autocomplete="off" name="<?php echo $val->code;?>" data-validate-msg="<?php echo $val->name;?> Link field is required"  placeholder="Enter <?php echo $val->name;?> Link" value="<?php echo isset($social_links[$val->code])?$social_links[$val->code]:''?>">
									</div> 
								</div>
							<?php } } ?>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label required">Stripe Publish Key</label>
									<input type="text" class="form-control validate" autocomplete="off" name="stripe_publish_key" data-validate-msg="Stripe Publish Key field is required"  placeholder="Enter Stripe Publish Key" value="<?php echo ($settings_info && $settings_info->stripe_publish_key)?$settings_info->stripe_publish_key:''?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label required">Stripe Seccret Key</label>
									<input type="text" class="form-control validate" autocomplete="off" name="stripe_seccret_key" data-validate-msg="Stripe Seccret Key field is required"  placeholder="Enter Stripe Seccret Key" value="<?php echo ($settings_info && $settings_info->stripe_seccret_key)?$settings_info->stripe_seccret_key:''?>">
								</div>
							</div>
						</div>
					
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label required">Copyright</label>
									<input type="text" class="form-control validate" autocomplete="off" name="copyright" data-validate-msg="Copyright field is required"  placeholder="Enter Copyright" value="<?php echo ($settings_info && $settings_info->copyright)?$settings_info->copyright:''?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label ">Address</label>
									<input type="text" class="form-control " autocomplete="off" name="address" data-validate-msg="Address field is required"  placeholder="Enter Address" value="<?php echo ($settings_info && $settings_info->address)?$settings_info->address:''?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label required">Description</label>
									<textarea class="form-control tinymce validate" name="description" data-validate-msg="Description field is required" rows="3"><?php echo ($settings_info && $settings_info->description)?$settings_info->description:''?></textarea>
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