<input type="hidden" id="start" value="<?php echo $start;?>">
<input type="hidden" id="end" value="<?php echo $end;?>">
<?php if($categories){ foreach($categories as $key=>$val){?>
	<tr>
		<td>
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
		<td width="100"><div class="img-container"><a href="<?php echo getCatImage($val->id,'image');?>" class="d-block w-100 h-100" data-fancybox=""><img src="<?php echo getCatImage($val->id,'image');?>" alt=""/></a></div></td>
		<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-category', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
            <td><a href="<?php echo base_url()?>admin/edit-category/<?php echo $val->slug;?>" target="_blank"><?php echo $val->name;?></a></td>
             <td></td>
         <?php } else { ?>
           <td><?php echo $val->name;?></td>
            <td></td>
           <?php } ?>		
		<td id="status_td_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Active</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">In-Active</span></span>';?></td>
		<td id="featured_td_<?php echo $val->id;?>"><?php echo ($val->featured == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Yes</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">No</span></span>';?></td>
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-category', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/edit-category/<?php echo $val->slug;?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
					<?php } ?>

					<a class="dropdown-item" target="_blank" href="<?php echo base_url()?>admin/products?cat_id=<?php echo $val->id;?>"><i class="fab fa-product-hunt"></i> Products</a>

					<a class="dropdown-item" target="_blank" href="<?php echo base_url()?>admin/orders?cat_id=<?php echo $val->id;?>"><i class="fas fa-gavel"></i> Orders</a>

					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('change-status-category', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="statusChange(<?php echo $val->id;?>,<?php echo ($val->status == 1)?2:1;?>)" id="status_a_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Deactivate':'<i class="fas fa-fw fa-check-circle"></i>  Activate';?></a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('change-featured-category', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="categoryFeatured(<?php echo $val->id;?>,<?php echo ($val->featured == 1)?2:1;?>)" id="featured_a_<?php echo $val->id;?>"><?php echo ($val->featured == 1)?'<i class="fas fa-fw fa-times-circle"></i> Non Featured':'<i class="fas fa-fw fa-check-circle"></i>  Featured';?></a>
					<?php } ?>

					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('seo', getUserDetails($this->session->userdata('user_id'),'access_management'))){ ?>
						<a class="dropdown-item" href="<?php echo base_url()?>admin/seo/categories/<?php echo $val->id;?>" target="_blank"><i class="fab fa-fw fa-amazon"></i> Seo</a> 
					<?php } ?>
					<!-- <?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('banners', getUserDetails($this->session->userdata('user_id'),'access_management'))){ ?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/banners/categories/<?php echo $val->id;?>" target="_blank"><i class="fas fa-fw fa-image"></i> Banner</a>
				<?php } ?> -->

				<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('dropdowns', getUserDetails($this->session->userdata('user_id'),'access_management'))){ ?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/dropdowns/<?php echo $val->slug;?>" target="_blank"><i class="fa fa-fw fa-sort"></i> Sorting Dropdowns</a>
				<?php } ?>

					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('delete-category', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="deleteCategory(<?php echo $val->id;?>)"><i class="fas fa-fw fa-trash"></i> Delete</a>
					<?php } ?>
				</div>
			</div>
        </td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Categories Found!</td>
	</tr>
<?php } ?>