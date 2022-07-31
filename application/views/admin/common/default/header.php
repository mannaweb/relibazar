<nav class="navbar navbar-expand navbar-dark topbar mb-4 static-top shadow">
	<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>

	<ul class="navbar-nav ml-auto">
		<div class="topbar-divider d-none d-sm-block"></div> 
  		<li class="nav-item dropdown no-arrow userDropdown">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php $getUserDetails = getUserDetails($this->session->userdata('user_id')) ?>
				<span class="mr-2 d-none d-lg-inline small"><?php echo $getUserDetails->name;?></span>
				<div class="img-profile rounded-circle">
			  		<?php if(isset($getUserDetails->profile_image) && file_exists($getUserDetails->profile_image)){ ?>
			  		<img class="" src="<?php echo base_url().$getUserDetails->profile_image;?>">
					<?php }else{ ?>
						<img class="" src="<?php echo base_url().'assets/admin/img/user-default.png';?>">
					<?php } ?>
				</div>
			</a>
    
    		<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
			<?php
				$profileEditUrl = 'javascript:void(0)';
				$isProfileEdit = 2;
				$role = explode(',', $getUserDetails->role);
				if(in_array('admin', $role)){
					$profileEditUrl = base_url().'admin/edit-admin/'.$this->session->userdata('user_id');
					$userPermissions = getUserDetails($this->session->userdata('user_id'));		
					$userPermission = json_decode($userPermissions->access_management, true);
					if(in_array('edit-admin', $userPermission)){
						$isProfileEdit = 1;
				}
			} 
			?>
	      		<?php if($isProfileEdit == 1){?>
				<a class="dropdown-item" href="<?php echo $profileEditUrl;?>">
					<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
					Profile
				</a>

			<div class="dropdown-divider"></div>
	      		<?php } ?>
				<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
					Logout
				</a>
    		</div>
		</li>
  		
	</ul>
</nav>