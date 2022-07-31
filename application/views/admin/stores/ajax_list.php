<?php if($stores){ foreach($stores as $key=>$val){?>
	<tr>
		<td>
			<div class="custom-checkbox">
				<input type="checkbox" class="custom-input singleCheck" id="customCheck<?php echo $val->id;?>" value="<?php echo $val->id;?>">
				<label class="custom-label" for="customCheck<?php echo $val->id;?>"></label>
			</div>
		</td>	
		
		<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-store', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
            <td><a href="<?php echo base_url()?>admin/edit-store/<?php echo $val->id;?>" target="_blank"><?php echo $val->name;?></a></td>
            <td><a href="<?php echo base_url()?>admin/edit-store/<?php echo $val->id;?>" target="_blank"><?php echo $val->address;?></a></td>
            <td><a href="<?php echo base_url()?>admin/edit-store/<?php echo $val->id;?>" target="_blank"><?php echo $val->city;?></a></td>
             <td><a href="<?php echo base_url()?>admin/edit-store/<?php echo $val->id;?>" target="_blank"><?php echo $val->state;?></a></td>
              <td><a href="<?php echo base_url()?>admin/edit-store/<?php echo $val->id;?>" target="_blank"><?php echo $val->country;?></a></td>
               <td><a href="<?php echo base_url()?>admin/edit-store/<?php echo $val->id;?>" target="_blank"><?php echo $val->pincode;?></a></td>
             <td><a href="<?php echo base_url()?>admin/edit-store/<?php echo $val->id;?>" target="_blank"><?php echo date('d M, Y',strtotime($val->created_at));?></a></td>
         <?php } else { ?>
           <td><?php echo $val->name;?></td>
             <td><?php echo $val->address;?></td>
               <td><?php echo $val->city;?></td>
                 <td><?php echo $val->state;?></td>
                   <td><?php echo $val->country;?></td>
                    <td><?php echo $val->pincode;?></td>
            <td><?php echo date('d M, Y',strtotime($val->created_at));?></td>
           <?php } ?>		
		<td id="status_td_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Active</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">In-Active</span></span>';?></td>
		
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-store', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/edit-store/<?php echo $val->id;?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
					<?php } ?>
					
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('change-status-store', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="statusChange(<?php echo $val->id;?>,<?php echo ($val->status == 1)?2:1;?>)" id="status_a_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Deactivate':'<i class="fas fa-fw fa-check-circle"></i>  Activate';?></a>
					<?php } ?>
					
      	<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('delete-store', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="deleteStore(<?php echo $val->id;?>)"><i class="fas fa-fw fa-trash"></i> Delete</a>
					<?php } ?>
				</div>
			</div>
        </td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No data Found!</td>
	</tr>
<?php } ?>