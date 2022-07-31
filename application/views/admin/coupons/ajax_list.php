<?php if($coupons){ foreach($coupons as $key=>$val){?>
	<tr>
		<td>
			<div class="custom-checkbox">
				<input type="checkbox" class="custom-input singleCheck" id="customCheck<?php echo $val->id;?>" value="<?php echo $val->id;?>">
				<label class="custom-label" for="customCheck<?php echo $val->id;?>"></label>
			</div>
		</td>	
		
		<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-coupon', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
            <td><a href="<?php echo base_url()?>admin/edit-coupon/<?php echo $val->id;?>" target="_blank"><?php echo $val->code;?></a></td>
            <td><a href="<?php echo base_url()?>admin/edit-coupon/<?php echo $val->id;?>" target="_blank"><?php echo $val->discount;?></a></td>
            <td><?php if($val->discount_type == 1){ echo 'Percentage';}else if($val->discount_type == 2){ echo 'Fixed cart';}else{ echo 'Fixed product'; } ?></td>
             <td><a href="<?php echo base_url()?>admin/edit-coupon/<?php echo $val->id;?>" target="_blank"><?php echo date('d M, Y',strtotime($val->end_date));?></a></td>
         <?php } else { ?>
           <td><?php echo $val->code;?></td>
            <td><?php echo date('d M, Y',strtotime($val->end_date));?></td>
           <?php } ?>		
		<td id="status_td_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Active</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">In-Active</span></span>';?></td>
		
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-coupon', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/edit-coupon/<?php echo $val->id;?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
					<?php } ?>
					
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('change-status-coupon', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="statusChange(<?php echo $val->id;?>,<?php echo ($val->status == 1)?2:1;?>)" id="status_a_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Deactivate':'<i class="fas fa-fw fa-check-circle"></i>  Activate';?></a>
					<?php } ?>
					
      	<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('delete-coupon', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="deleteCoupon(<?php echo $val->id;?>)"><i class="fas fa-fw fa-trash"></i> Delete</a>
					<?php } ?>
				</div>
			</div>
        </td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No data Found!</td>
	</tr>
<?php } ?>