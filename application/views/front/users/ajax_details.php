<div class="modal-dialog">
	<div class="modal-content">
			
		<div class="modal-header">
			<h1 class="modal-title"><?php echo $user->username; ?></h1>
			<button type="button" class="close" data-dismiss="modal">×</button>
		</div>		
		<div class="modal-body">
		
			<div class="details-wrap">
			 <div class="row">
			  	<div class="col-lg-3">
						<div class="gallery-content">
							<div class="carousel slide gal-slider" id="gal-slider" data-ride="carousel">
								<div class="carousel-inner">
									<div class="carousel-item active">
															<?php if($user->profile_image){ 
					                 	$explode= explode('/', $user->profile_image);
					                 	//print_r($explode[0]);die;
					                 	if($explode[0] == 'uploads'){
					                          $base_url = base_url().$user->profile_image;
					                 	   }else {
					                           $base_url = 'https://graph.facebook.com/v3.0/'.$user->social_id.'/picture?width=1920';
					                 	   }
					                 	?>
					                 	<img src="<?php echo $base_url; ?>" alt="" class="img-thumbnail">
					                 <?php }else{ ?>
										<img src="https://graph.facebook.com/v3.0/744500662700132/picture?width=1920" alt="" class="img-thumbnail">
									<?php } ?>
									</div>
									
									
								</div>
								
							</div>

						</div>
						
			
			
						
					</div>
					<div class="col-lg-8">
						<div class="details-content">
							
						
							
							<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								<label class="control-label">Name : </label>
								<div class="data"><?php echo isset($user->name)?$user->name:''; ?></div>
							</div>
						</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Email : </label>
										<div class="data"><?php echo isset($user->email)?$user->email:''; ?> <?php if($user->email_verified == 1){ ?><i class="badge badge-pill badge-success">Verified</i><?php }else{ ?> <i class="badge badge-pill badge-danger">Unerified</i> <?php } ?></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Phone : </label>
										<div class="data"><?php echo isset($user->phone)?$user->phone:'Not Given'; ?> <?php if($user->phone_verified == 1){ ?><i class="badge badge-pill badge-success">Verified</i><?php }else{ ?> <i class="badge badge-pill badge-danger">Unerified</i> <?php } ?> </div>
									</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								<label class="control-label">Member Since : </label>
								<div class="data"><?php echo ($user->created_at!=''&&$user->created_at != null)?date('jS F,Y', strtotime($user->created_at)):'N/A';?></div>
							</div>
							</div>
								</div>
								<?php if(!empty($user->user_address)){ ?>
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label"> Address : </label>
										<div class="data"><?php echo isset($user->user_address)?$user->user_address:''; ?></div>
									</div>
								</div>
							</div>
                            <?php } ?>
                           
                            
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>