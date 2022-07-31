<input type="hidden" id="start" value="<?php echo $start;?>">
<input type="hidden" id="end" value="<?php echo $end;?>">
<?php if($contact){ foreach($contact as $key=>$val){?>
	<tr>
		
		<td>
		<?php echo $val->name;?>
		</td>
			
		<td><?php echo $val->email;?></td>			
		<td><?php echo $val->phone;?></td>				
		<td>
		
		<?php echo $val->message;?>

		</td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Data found!</td>
	</tr>
<?php } ?>