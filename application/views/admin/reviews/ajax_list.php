<?php 
$session_lang = getSessionLang();
if($reviews){ foreach($reviews as $key=>$val){?>
	<tr>
		<td><a href="<?php echo base_url().'admin/edit-reviews/'.$val->id; ?>" target="_blank"><?php echo $val->title;?></a></td>
		<td><a href="javascript:void(0)" data-toggle="modal" data-target="#listModal" onclick="show_details(<?php echo $val->listing_id;?>)">
			<?php 
			$list_titles = json_decode($val->list_title,true);
			echo $list_titles[$session_lang];
			?>	</a>
		</td>
		<td><a href="javascript:void(0)" class="item-title"  onclick="user_details('<?php echo $val->rid; ?>')" data-toggle="modal" data-target="#userModal" ><?php echo $val->rname; ?></a></td>

		<td><a href="javascript:void(0)" class="item-title"  onclick="user_details('<?php echo $val->sid; ?>')" data-toggle="modal" data-target="#userModal" ><?php echo $val->sname; ?></a></td>
		<td>
			<i class="fa fa-star fa-fw <?php echo ((isset($val->ratting) && ($val->ratting ==1 || $val->ratting >1))?'active':''); ?>"></i>
			<i class="fa fa-star fa-fw <?php echo ((isset($val->ratting) && ($val->ratting ==2 || $val->ratting >2))?'active':''); ?>"></i>
			<i class="fa fa-star fa-fw <?php echo ((isset($val->ratting) && ($val->ratting ==3 || $val->ratting >3))?'active':''); ?>"></i>
			<i class="fa fa-star fa-fw <?php echo ((isset($val->ratting) && ($val->ratting ==4 || $val->ratting >4))?'active':''); ?>"></i>
			<i class="fa fa-star fa-fw <?php echo ((isset($val->ratting) && ($val->ratting ==5))?'active':''); ?>"></i>
		</td>
		<td><a  href="<?php echo base_url().'admin/edit-reviews/'.$val->id; ?>" target="_blank"><?php echo $val->description; ?></a></td>
		<td><?php echo date('jS M, Y',strtotime($val->created_at));?></a></td>

		<!-- <td id="status_td_<?php echo $val->id;?>"><?php echo ($val->is_editable == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Yes</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">No</span></span>';?></td> -->
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="<?php echo base_url().'admin/edit-reviews/'.$val->id; ?>"><i class="fas fa-fw fa-edit"></i> Edit</a>

					<!-- <a class="dropdown-item" href="javascript:void(0)" onclick="statusChange(<?php echo $val->id;?>,<?php echo ($val->is_editable == 1)?2:1;?>)" id="status_a_<?php echo $val->id;?>"><?php echo ($val->is_editable == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Not Editable':'<i class="fas fa-fw fa-check-circle"></i>  Is Editable';?></a> -->
				</div>
			</div>
		</td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Data Found!</td>
	</tr>
<?php } ?>
		