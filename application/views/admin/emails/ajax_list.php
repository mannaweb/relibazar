<?php if($emails){ foreach($emails as $key=>$val){?>
	<tr>
		<td width="50">
			<div class="custom-checkbox">
				<input type="checkbox" class="custom-input singleCheck" id="customCheck<?php echo $val->id;?>" value="<?php echo $val->id;?>">
				<label class="custom-label" for="customCheck<?php echo $val->id;?>"></label>
			</div>
		</td>
		<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-email', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>

			<td><a href="<?php echo base_url()?>admin/edit-email/<?php echo $val->id;?>" target="_blank"><?php echo $val->code;?></a></td>
			<td><a href="<?php echo base_url()?>admin/edit-email/<?php echo $val->id;?>" target="_blank"><?php echo $val->email_for;?></a></td>
			<td><a href="<?php echo base_url()?>admin/edit-email/<?php echo $val->id;?>" target="_blank"><?php echo date('d M, Y',strtotime($val->created_at));?></a></td>
			<td><a href="<?php echo base_url()?>admin/edit-email/<?php echo $val->id;?>" target="_blank"><?php echo $val->subject;?></a></td>
			
			<?php } else { ?>
				<td><?php echo $val->code;?></td>
			<td><?php echo $val->email_for;?></td>
			<td><?php echo date('d M, Y',strtotime($val->created_at));?></td>
			<td><?php echo $val->subject;?></td>
		<?php } ?>
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-email', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/edit-email/<?php echo $val->id;?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
				<?php } ?>
				</div>
			</div>

		</td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Emails Found!</td>
	</tr>
<?php } ?>
		