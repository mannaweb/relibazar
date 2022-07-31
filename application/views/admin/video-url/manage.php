<div class="card shadow mb-4">
	<div class="card-header py-3">
		<div class="row">
			<div class="col-md-6 d-flex"><h6 class="title my-auto"><?php echo ($post_type)?ucwords($post_type).' Video URL':'Video URL'?></h6></div>
		</div>
	</div>
	<div class="card-body">
		<form class="user" id="manageForm">
			<input type="hidden" name="post_id" value="<?php echo (isset($post_id)?$post_id:'')?>">
			<input type="hidden" name="post_type" value="<?php echo (isset($post_type)?$post_type:'')?>">
			<div id="append_div" class="video-url-append">
				<?php
				  if(isset($videoInfo) && count($videoInfo)>0){
				  	foreach ($videoInfo as $key => $value){
				?>
				<div class="each-row" id="row_url_<?php echo $key; ?>">
					<div class="col-title">
						<label class="control-label required">Title</label>
						<input type="text" class="form-control validate" autocomplete="off" name="original_name[]" data-validate-msg="Title field is required"  placeholder="Enter Title" value="<?php echo ($value->original_name)?$value->original_name:''?>">
					</div>
					<div class="col-url">
						<label class="control-label required">Url</label>
						<input type="url" class="form-control validate" autocomplete="off" name="image[]" data-validate-msg="URL field is required" id="url_data_<?php echo $key; ?>"  placeholder="Enter URL" value="<?php echo ($value->image)?$value->image:''?>" onchange="checkUrl(this.value,<?php echo $key; ?>);">
					</div>
					<?php if($key == 0){?>
					<button type="button" class="btn btn-sm btn-primary btn-add-row addCF" onclick=""><i class="fal fa-plus"></i></button>
					<?php }else{?>
					<button type="button" class="btn btn-sm btn-danger btn-remove-row" onclick="remove_div('<?php echo $key; ?>')"><i class="fal fa-times"></i></button>
					<?php }?>
					<input type="hidden" name="primary_id[]" value="<?php echo ($value->id)?$value->id:''?>">
				</div>
			<?php }?>
				<input type="hidden" class="row_count" value="<?php echo $key; ?>">
			<?php  }else{?>
				<div class="each-row" id="row_url_0">
					<div class="col-title">
						<label class="control-label required">Title</label>
						<input type="text" class="form-control validate" autocomplete="off" name="original_name[]" data-validate-msg="Title field is required"  placeholder="Enter Title" value="">
					</div>
					<div class="col-url">
						<label class="control-label required">Url</label>
						<input type="url" class="form-control validate" autocomplete="off" name="image[]" data-validate-msg="URL field is required" id="url_data_0"  placeholder="Enter URL" value="" onchange="checkUrl(this.value,0);">
					</div>
					<button type="button" class="btn btn-sm btn-primary btn-add-row addCF" onclick=""><i class="fal fa-plus"></i></button>
					<input type="hidden" name="primary_id[]" value="">
				</div>
				<input type="hidden" class="row_count" value="0">
			<?php }?>
			</div>
			<div class="row">
				<div class="col text-right">
				   <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
				   <!-- <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button> -->
				</div>
			</div>
		</form>
	</div>
</div>