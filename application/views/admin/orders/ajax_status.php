<div class="modal-dialog">
	<div class="modal-content">
			
		<div class="modal-header">
			<h1 class="modal-title">Order Maintanancen #<?php echo $order_id; ?></h1>
			<button type="button" class="close" data-dismiss="modal">×</button>
		</div>		
		<input type="hidden" id="order_id" value="<?php echo $order_id; ?>">
		<div class="modal-body">
		<div class="details-wrap">
			 <div class="row">
                 <div class="col-sm-12 mb-2">
                 	<label>Status Maintanance</label>
                 	<select class="form-control select2" id="order_status">
                 		<option disabled="disabled">Select Status</option>
                 		<?php foreach ($order_status as $key => $value) { ?>
                 				<option value="<?php echo $value->id; ?>" <?php if($value->id == $orders->order_status){ echo 'selected';} ?>><?php echo $value->title; ?></option>
                 		<?php } ?>
                 	</select>
			  	</div>
			  	<br>
			  	 <div class="col-sm-12">
			  	 <textarea id="msg" placeholder="Message.." class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 137px;"></textarea>
                
			  	</div>
			  </div>
			</div>
		</div>
		<div class="modal-footer justify-content-right">
			   <a class="btn btn-primary saveBtn" href="javascript:void(0)" onclick="change_status()">Save</a>
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				
			</div>
	</div>
</div>
