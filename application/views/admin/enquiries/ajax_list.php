<?php if($enquiries){ foreach($enquiries as $key=>$val){?>
	<tr>
			
		
		 <td><a href="<?php echo base_url();?>/admin/edit-product/<?php echo $val->pro_slug;?>" target="_blank"><?php echo $val->product_name;?></a></td>
           <td><?php echo $val->name;?></td>
            <td><?php echo $val->email;?></td>
             <td><?php echo $val->phone;?></td>
             <td><?php echo $val->message;?></td>
            <td><?php echo date('d M, Y',strtotime($val->created_at));?></td>
    

	
		
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					
					
      	<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('delete-enquiry', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="deleteEnq(<?php echo $val->id;?>)"><i class="fas fa-fw fa-trash"></i> Delete</a>
					<?php } ?>
				</div> 
			</div>
        </td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No data Found!</td>
	</tr>
<?php } ?>