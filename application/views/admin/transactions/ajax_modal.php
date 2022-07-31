<div class="modal-dialog">
	<div class="modal-content">

		<div class="modal-header">
			<h4 class="modal-title">Transaction Pay</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>

		<div class="modal-body">
			<form id="payManageForm">
				<div class="col-md-12">
					<input type="hidden" id="handling_percentage" value="<?php echo round($getPayData->handling_percentage); ?>">
					<input type="hidden" name="txn_id" value="<?php echo $getPayData->id; ?>">
					<div class="form-group">
						<label class="control-label required">Awarded Price</label>
						<input type="text" name="awarded_price" id="awarded_price" readonly="" onkeyup="amountCalculate();" autocomplete="off" class="form-control validate" placeholder="Awarded Price" data-validate-msg=" Awarded Price is required" value="<?php echo $getPayData->awarded_price; ?>" />
					</div>
					<div class="form-group">
						<label class="control-label required">Handling Price(<?php echo round($getPayData->handling_percentage); ?>%)</label>
						<input type="text" class="form-control validate" readonly="" placeholder="Handling Price"  name="handling_price" id="handling_price" autocomplete="off" data-validate-msg="Handling Price field is required" value="<?php echo $getPayData->handling_price; ?>" />
					</div>
					<div class="form-group">
						<label class="control-label required">Total Amount</label>
						<input type="text" name="amount" id="amount" readonly="" placeholder="Total Amount"  autocomplete="off" class="form-control validate" data-validate-msg="Total Amount field is required" value="<?php echo $getPayData->amount; ?>" />
					</div>
					<div class="form-group">
						<label class="control-label">Comment</label>
						<textarea class="form-control" name="comment"></textarea>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-success savePay">Confirm Pay</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>


<script type="text/javascript">
	function amountCalculate(){
		var awarded_price = $('#awarded_price').val();
		var handling_percentage = $('#handling_percentage').val();
		if(awarded_price){
			var handling_price = ((parseFloat(awarded_price)/100)*parseInt(handling_percentage)).toFixed(2);
			var amount = (parseFloat(awarded_price)-parseFloat(handling_price));
			$('#handling_price').val(handling_price);
			$('#amount').val(amount);
		}else{
			$('#handling_price').val('');
			$('#amount').val('');
		}
	}

	$(document).ready(function(){
		$('.savePay').click(function(){
			var enable = true;
			$( ".validate" ).each(function( index,element ) {

				if(jQuery.trim($(element).val()) == ''){
					toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
					enable = false;
					return false;
				}
			});
			if(enable){
				saveData();
			}
		});
	});

	function saveData(){
		var formData = new FormData($("#payManageForm")[0]);
		$.ajax({
			type: "POST",
			url: BASE_URL +'admin/transaction-pay-save',
			data: formData,
			enctype:'multipart/form-data',
			contentType : false,
			processData : false,
			beforeSend:function(){

				$('.savePay').prop('disabled',true);
				$('.savePay').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
			},
			success:function(result){

				var data = jQuery.parseJSON(result);
				if(data.status == 1){
					$('.savePay').html('Saved');
					toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { location.reload(); }   });
				} else {
					$('.savePay').prop('disabled',false);
					$('.savePay').html('Save');
					toastr.error(data.msg, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
				}
			}
		});
	}
</script>