<div class="card shadow mb-4">
	<div class="card-header py-3">
		<div class="row">
			<div class="col-md-6 d-flex"><h6 class="title my-auto"><?php echo ($post_type)?ucwords($post_type).' Gallery':'Gallery'?></h6></div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label">Upload Gallery Image</label>
					<div id="postDropzone" class="postDropzone">
						<div class="dropzone-file-area">
							<input type="hidden" id="post_id" name="post_id" value="<?php echo ($post_id)?$post_id:''?>">
							<input type="hidden" id="post_type" name="post_type" value="<?php echo ($post_type)?$post_type:''?>">
							<div class="dz-message" data-dz-message><span><h3 class='title'>Drop files here or click to upload screenshot</h3><p class='text'> You have to upload the screenshot for your software to satisfy the customers </p></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>