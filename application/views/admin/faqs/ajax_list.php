<?php $access_management = getUserDetails($this->session->userdata('user_id'),'access_management');?>
<input type="hidden" id="start" value="<?php echo $start;?>">
<input type="hidden" id="end" value="<?php echo $end;?>">
<?php 
$default_lang_arr = getsitelanguages(2);
$default_lang = $default_lang_arr->lang_code;
$session_lang = getSessionLang();
if($faqs){ foreach($faqs as $key=>$val){
$question = [];
$question = json_decode($val->question,true);
?>
	<tr>
		<td width="50">
			<div class="custom-checkbox">
					<input type="checkbox" class="custom-input singleCheck" id="customCheck<?php echo $val->id;?>" value="<?php echo $val->id;?>">
					<label class="custom-label" for="customCheck<?php echo $val->id;?>"></label>
				</div>
		</td>
		<td width="100">
		<div class="form-group m-0">
			<input type="hidden" class="form-control ids"  value="<?php echo $val->id;?>">
			<input type="number" class="form-control ordering" min="0" value="<?php echo $val->ordering;?>">
		</div>
		</td>
			<?php if($access_management && in_array('edit-faq', $access_management)){?>

		<td><a href="<?php echo base_url()?>admin/edit-faq/<?php echo $val->id;?>" target="_blank"><?php echo $question[$session_lang];?></a></td>
		<td><a href="<?php echo base_url()?>admin/edit-faq/<?php echo $val->id;?>" target="_blank"><?php echo date('d M, Y',strtotime($val->created_at));?></a></td>		
		<?php }else{ ?>
			<td><?php echo $question[$session_lang];?></td>	
		<td><?php echo date('d M, Y',strtotime($val->created_at));?></td>

		<?php }	 ?>
		<td id="status_td_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Active</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">In-Active</span></span>';?></td>				
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">

					<?php if($access_management && in_array('edit-faq', $access_management)){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/edit-faq/<?php echo $val->id;?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
					<?php } ?>

					<?php if($access_management && in_array('change-status-faq', $access_management)){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="statusChange(<?php echo $val->id;?>,<?php echo ($val->status == 1)?2:1;?>)" id="status_a_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Deactivate':'<i class="fas fa-fw fa-check-circle"></i>  Activate';?></a>
					<?php } ?>

					<?php if($access_management && in_array('delete-faq', $access_management)){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="deletefaq(<?php echo $val->id;?>)"><i class="fas fa-fw fa-trash"></i> Delete</a>
					<?php } ?>
				</div>
			</div>

		</td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Faqs Found!</td>
	</tr>
<?php } ?>