
<?php if($users){ foreach($users as $key=>$val){?>
	<tr>
		<td>
			<div class="custom-checkbox">
					<input type="checkbox" class="custom-input singleCheck" id="customCheck<?php echo $val->id;?>" value="<?php echo $val->id;?>">
					<label class="custom-label" for="customCheck<?php echo $val->id;?>"></label>
				</div>
		</td>
		
			<td ><a href="javascript:void(0)" class="item-title"  onclick="user_details('<?php echo $val->id; ?>')" data-toggle="modal" data-target="#userModal" ><?php echo $val->name;?></a></td>
			<td id="email_td_<?php echo $val->id;?>"><a href="javascript:void(0)" class="item-title"  onclick="user_details('<?php echo $val->id; ?>')" data-toggle="modal" data-target="#userModal" ><?php echo $val->email;?>   <?php echo ($val->email_verified == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check-circle"></i></span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times-circle"></i></span></span>'?></a></td>
			<td  id="phone_td_<?php echo $val->id;?>"><a href="javascript:void(0)" class="item-title"  onclick="user_details('<?php echo $val->id; ?>')" data-toggle="modal" data-target="#userModal" ><?php echo isset($val->phone)?$val->phone:'Not Given';?>   <?php echo ($val->phone_verified == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check-circle"></i></span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times-circle"></i></span></span>'?></a></td>
			<td><a href="javascript:void(0)" class="item-title"  onclick="user_details('<?php echo $val->id; ?>')" data-toggle="modal" data-target="#userModal" ><?php echo date('jS M, Y',strtotime($val->created_at));?></a></td>
       

		<td id="status_td_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Active</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Inactive</span></span>';?></td>
		<td>

			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" target="_blank" href="<?php echo base_url('admin/orders?user_id='.$val->id); ?>"><i class="fas fa-gavel"></i> Orders</a>
					<a class="dropdown-item" target="_blank" href="<?php echo base_url('admin/enquiries?user_id='.$val->id); ?>"><i class="fa fa-question-circle"></i> Enquiry</a>
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-user', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/edit-user/<?php echo $val->id;?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('change-status-user', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="statusChange(<?php echo $val->id;?>,<?php echo ($val->status == 1)?2:1;?>)" id="status_a_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Deactivate':'<i class="fas fa-fw fa-check-circle"></i>  Activate';?></a>
					<?php } ?>

					<a class="dropdown-item" href="javascript:void(0)" onclick="statusEmail(<?php echo $val->id;?>,'<?php echo $val->email;?>',<?php echo ($val->email_verified == 1)?2:1;?>)" id="email_a_<?php echo $val->id;?>"><?php echo ($val->email_verified == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Email Unverified':'<i class="fas fa-fw fa-check-circle"></i>  Email Verified';?></a>

                   <a class="dropdown-item" href="javascript:void(0)" onclick="statusPhone(<?php echo $val->id;?>,<?php echo $val->phone;?>,<?php echo ($val->phone_verified == 1)?2:1;?>)" id="phone_a_<?php echo $val->id;?>"><?php echo ($val->phone_verified == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Phone Unverified':'<i class="fas fa-fw fa-check-circle"></i>  Phone Verified';?></a>

					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('delete-user', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
						<?php if($val->status == 3){ ?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="deleteUser(<?php echo $val->id;?>,<?php echo $val->status;?>)"><i class="fas fa-fw fa-trash"></i> Delete</a>
					<?php }else{ ?>
						<a class="dropdown-item" href="javascript:void(0)" onclick="deleteUser(<?php echo $val->id;?>,<?php echo $val->status;?>)"><i class="fas fa-fw fa-trash"></i> Trash</a>
					<?php } ?>
					<?php } ?>

					
				</div>
			</div>

		</td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Data Found!</td>
	</tr>
<?php } ?>
		