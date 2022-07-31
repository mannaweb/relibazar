<div class="each-row" id="row_url_<?php echo $last_id; ?>">
	<div class="col-title">
		<label class="control-label required">Title</label>
		<input type="text" class="form-control validate" autocomplete="off" name="original_name[]" data-validate-msg="Title field is required"  placeholder="Enter Title" value="">
	</div>
	<div class="col-url">
		<label class="control-label required">Url</label>
		<input type="url" class="form-control validate" autocomplete="off" name="image[]" data-validate-msg="Url field is required" id="url_data_<?php echo $last_id; ?>"  placeholder="Enter URL" value="" onchange="checkUrl(this.value,<?php echo $last_id; ?>);">
	</div>
	<button type="button" class="btn btn-sm btn-danger btn-remove-row" onclick="remove_div('<?php echo $last_id; ?>')"><i class="fal fa-times"></i></button>
	<input type="hidden" name="primary_id[]" value="">
</div>