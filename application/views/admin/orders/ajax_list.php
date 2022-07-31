<input type="hidden" id="start" value="<?php echo $start;?>">
<input type="hidden" id="end" value="<?php echo $end;?>">
<?php if($orders){ foreach($orders as $key=>$val){?>
	<tr>
			
		<!-- <td width="100">
		<div class="form-group m-0">
			<input type="hidden" class="form-control ids" value="<?php echo $val->id;?>">
			<input type="number" min="0" class="form-control ordering" value="<?php echo $val->ordering;?>">
		</div>
		</td> -->	
		

	
		
	    <td width="100" class="nowrap"><a href="javascript:void(0)" data-toggle="modal" data-target="#orderModal" onclick="order_details('<?php echo $val->order_id; ?>')"><?php echo $val->order_id; ?></a></td>
		
		
		<td><a href="javascript:void(0)" data-toggle="modal" data-target="#orderModal" onclick="order_details('<?php echo $val->order_id; ?>')"><?php echo date('d M, Y',strtotime($val->created_at));?></a></td>
	    <td id="">
	    	<a href="javascript:void(0)" data-toggle="modal" data-target="#orderModal" onclick="order_details('<?php echo $val->order_id; ?>')">
	    	<?php
			if($val->user_info){
			 $user_info = json_decode($val->user_info); 
			 echo isset($user_info->email)?$user_info->email:'';
			 echo '<br>';
			 echo isset($user_info->contact_number)?$user_info->contact_number:'';
			}
			
			?></a>
		</td>	
        <td id="">₹<?php echo $val->total_amount; ?></td>	
          <td id=""><?php echo $val->status_name; ?></td>	
         <td ><?php echo ($val->payment_status == 'Success')?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Success</span></span>':'<span class="btn btn-xs btn-warning btn-icon-split"><span class="icon text-white-50"><i class="fas fa-clock"></i></span><span class="text">Pending</span></span>';?></td>

         <?php if($this->uri->segment(2) != 'dashboard'){ ?>

		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
					<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:void(0)" data-toggle="modal" data-target="#orderMaintance" onclick="order_manage('<?php echo $val->order_id; ?>')"><i class="fa fa-tasks"></i> Manage</a></div>
			
			 </div>
            </td>
           <?php } ?>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Order Found!</td>
	</tr>
<?php } ?>