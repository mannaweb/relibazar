
<?php 
$session_lang = getSessionLang();
$getDefaultCurrency = getDefaultCurrency();
if($transactions){ foreach($transactions as $key=>$val){?>
	<tr>
		<td><a href="javascript:void(0)" class="item-title"  onclick="user_details('<?php echo $val->user_id; ?>')" data-toggle="modal" data-target="#userModal" ><?php echo $val->name;?></a></td>
		<td><a href="javascript:void(0)" data-toggle="modal" data-target="#listModal" onclick="show_details(<?php echo $val->listing_id;?>)">
			<?php 
			$titles = json_decode($val->title,true);
			echo $titles[$session_lang];
			?></a>
		</td>
		<td><a href="<?php echo base_url().'admin/view-invoice/'.$val->inv_id; ?>" target="_blank"><?php echo $val->inv_id; ?></a></td>
		<td><?php echo ($getDefaultCurrency->before_after == 1)?$getDefaultCurrency->symbol.' '.number_format($val->awarded_price,2):number_format($val->awarded_price,2).' '.$getDefaultCurrency->symbol;  ?></td>
		
		<td><?php echo ($getDefaultCurrency->before_after == 1)?$getDefaultCurrency->symbol.' '.number_format($val->handling_price,2):number_format($val->handling_price,2).' '.$getDefaultCurrency->symbol;  ?> (<?php echo round($val->handling_percentage); ?>%)</td>
		<td><?php echo ($getDefaultCurrency->before_after == 1)?$getDefaultCurrency->symbol.' '.number_format($val->amount,2):number_format($val->amount,2).' '.$getDefaultCurrency->symbol;  ?></td>
		<td><?php echo ($val->status == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Paid</span></span>':'<span class="btn btn-xs btn-warning btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Pending</span></span>';?></td>
		<td><?php echo date('jS M, Y',strtotime($val->created_at));?></a></td>
		<td>
			<?php if($val->user_id != $val->listing_user_id && $val->status != 1){ ?>
				<span class="badge badge-pill badge-primary">Transporter</span>
			<?php }else{ ?>
				<span class="badge badge-pill badge-dark">Sender</span>
			<?php } ?>
		</td>
		<td>

			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="<?php echo base_url().'admin/view-invoice/'.$val->inv_id; ?>" target="_blank"><i class="fas fa-fw fa-eye"></i> View</a>
					<?php if($val->user_id != $val->listing_user_id && $val->status != 1){ ?>
					<a class="dropdown-item" href="javascript:void(0);" onclick="payStatusModal(<?php echo $val->id; ?>)"><i class="fas fa-fw fa-hand-holding-usd"></i> Pay Now</a>
					<?php } ?>
				</div>
			</div>

		</td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Data Found!</td>
	</tr>
<?php } ?>
		