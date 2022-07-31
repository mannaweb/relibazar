<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row mb-2">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto"><?php echo $users->name;?></h6>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-wrap">
			<div class="preloader">
				<?php $this->load->view('admin/common/default/loader');?>
			</div>
			<?php 
			if (isset($users) && isset($users->id)) {
			?>
			<div class="row">
				<div class="tabs form-group col-sm-12">
			
			</div>
			
			</div>

			<div class="row">
				<div class="form-group col-sm-6">
						<div class="alert alert-info">
					<h6 class="title my-auto">Profile Image</h6>
				</div>
					<div class="form-group">
								
								<?php
								if ($users->profile_type == 'system' && $users->profile_image != '') {?>
									<img src="<?php echo base_url().$users->profile_image;?>" class="img-thumbnail" width="200px">									
								<?php }else{?>
									<img src="<?php echo base_url(); ?>assets/front/img/icons/profile-user.png" class="img-thumbnail" width="200px">
								<?php } ?>
					</div>
					
				</div>
				<div class="form-group col-sm-6">
					<div class="alert alert-info">
					<h6 class="title my-auto">User Info</h6>
				</div>
					<ul>
							<li>
							<div class="form-group">
								<label style="font-weight:bold;">Name: </label>
								<span><?php echo $users->name;?></span>
							</div>
						</li>
						<li>
							<div class="form-group">
								<label style="font-weight:bold;">Username: </label>
								<span><?php echo $users->username;?></span>
							</div>
						</li>
						<li>
							<div class="form-group">
								<label style="font-weight:bold;">Email: </label>
								<span><?php echo $users->email;?></span> <?php if ($users->email_verified == 1) { ?><i class="badge badge-success">Verified</i> <?php }else{ ?> <i class="badge badge-danger">Unverified</i> <?php } ?>
							</div>
						</li>
						
						<?php if($users->email_verified == 1){ ?>
						<li>
							<div class="form-group">
								<label style="font-weight:bold;">Email Verified Date: </label>
								<?php 
									if ($users->email_verified_date == '' && $users->email_verified_date == NULL) {
										$email_verified_date = '--/--/--';
									}else{
										$email_verified_date = date('jS F,Y', strtotime($users->email_verified_date));
									}
								?>
								<span><?php echo $email_verified_date;?></span>
							</div>
						</li>
					<?php } ?>

						<li>
							<div class="form-group">
								<label style="font-weight:bold;">Phone: </label>
								<span><?php echo $users->phone;?></span> <?php if ($users->phone_verified == 1) { ?><i class="badge badge-success">Verified</i> <?php }else{ ?> <i class="badge badge-danger">Unverified</i> <?php } ?>
							</div>
						</li>
					
						<?php if($users->phone_verified == 1){ ?>
						<li>
							<div class="form-group">
								<label style="font-weight:bold;">Phone Verified Date: </label>
								<?php 
									if ($users->phone_verified_date == '' && $users->phone_verified_date == NULL) {
										$phone_verified_date = '--/--/--';
									}else{
										$phone_verified_date = date('jS F,Y', strtotime($users->phone_verified_date));
									}
								?>
								<span><?php echo $phone_verified_date;?></span>
							</div>
						</li>
					<?php } ?>
						<?php if($users->last_logged != '' && $users->last_logged != NULL){ ?>
						<li>
							<div class="form-group">
								<label style="font-weight:bold;">Last logged in: </label>
								<?php 
									if ($users->last_logged == '' && $users->last_logged == NULL) {
										$last_logged = '--/--/--';
									}else{
										$last_logged = date('jS F,Y', strtotime($users->last_logged));
									}
								?>
								<span><?php echo $last_logged;?></span>
							</div>
						</li>
					<?php } ?>
						<li>
							<div class="form-group">
								<label style="font-weight:bold;">Account Created: </label>
								<?php 
									if ($users->created_at == '' && $users->created_at == NULL) {
										$created_at = '--/--/--';
									}else{
										$created_at = date('jS F,Y', strtotime($users->created_at));
									}
								?>
								<span><?php echo $created_at;?></span>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>