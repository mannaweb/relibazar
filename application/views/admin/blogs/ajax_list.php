<input type="hidden" id="start" value="<?php echo $start;?>">
<input type="hidden" id="end" value="<?php echo $end;?>">
<?php if($blogs){ foreach($blogs as $key=>$val){?>
	<tr>
		<td width="50">
			<div class="custom-checkbox">
					<input type="checkbox" class="custom-input singleCheck" id="customCheck<?php echo $val->id;?>" value="<?php echo $val->id;?>">
					<label class="custom-label" for="customCheck<?php echo $val->id;?>"></label>
				</div>
		</td>
		<td width="100">
		<div class="form-group m-0">
			<input type="hidden" class="form-control ids" value="<?php echo $val->id;?>">
			<input type="number" min="0" class="form-control ordering" value="<?php echo $val->ordering;?>">
		</div>
		</td>
		<td width="100"><div class="img-container"><a href="<?php echo getBlogImage($val->id,'logo');?>" class="d-block w-100 h-100" data-fancybox=""><img src="<?php echo getBlogImage($val->id,'logo');?>" alt=""/></a></div></td>

		<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('edit-blog', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>

			<td><a href="<?php echo base_url()?>admin/edit-blog/<?php echo $val->alias;?>" target="_blank"><?php echo $val->title;?></a></td>
	<td width="100" class="nowrap"><a href="<?php echo base_url()?>admin/edit-blog/<?php echo $val->alias;?>" target="_blank"><?php echo date('d M, Y',strtotime($val->created_date));?></a></td>
		<?php } else { ?>
     <td><?php echo $val->title;?></td>
	<td><?php echo date('d M, Y',strtotime($val->created_date));?></td>
		<?php } ?>
	  <td id="status_td_<?php echo $val->id;?>">
			<?php if($val->active == 1){ ?>
				<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Active</span></span>
			<?php }else if($val->active == 3){ ?>
				<span class="btn btn-xs btn-warning btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Pending</span></span>	
			<?php }else{ ?>
				<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Inactive</span></span>	
			<?php } ?>
		</td>	
        <td id="featured_td_<?php echo $val->id;?>"><?php echo ($val->featured == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Yes</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">No</span></span>';?></td>	
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('edit-blog', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/edit-blog/<?php echo $val->alias;?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('change-status-blog', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="statusChange(<?php echo $val->id;?>,<?php echo ($val->active == 1)?2:1;?>,'<?php echo $val->post_type; ?>')" id="status_a_<?php echo $val->id;?>"><?php echo ($val->active == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Deactivate':'<i class="fas fa-fw fa-check-circle"></i>  Activate';?></a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('change-featured-blog', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="blogFeatured(<?php echo $val->id;?>,<?php echo ($val->featured == 1)?2:1;?>)" id="featured_a_<?php echo $val->id;?>"><?php echo ($val->featured == 1)?'<i class="fas fa-fw fa-times-circle"></i> Non Featured':'<i class="fas fa-fw fa-check-circle"></i>  Featured';?></a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('seo', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/seo/<?php echo $val->post_type; ?>/<?php echo $val->id;?>" target="_blank"><i class="fab fa-fw fa-amazon"></i> SEO</a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('banners', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/banners/<?php echo $val->post_type; ?>/<?php echo $val->id;?>" target="_blank"><i class="fas fa-fw fa-image"></i> Banner</a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('gallery', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/gallery/blog/<?php echo $val->alias;?>" target="_blank"><i class="fas fa-fw fa-images"></i> Image Gallery</a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('video-url', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/video-url/blog/<?php echo $val->alias;?>" target="_blank"><i class="fas fa-video"></i> Video Gallery</a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('delete-blog', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="deleteBlog(<?php echo $val->id;?>)"><i class="fas fa-fw fa-trash"></i> Delete</a>
					<?php } ?>
					</div>
			      </div>
            </td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Blogs Found!</td>
	</tr>
<?php } ?>