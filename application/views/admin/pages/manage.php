<div class="card shadow mb-4">
	<div class="card-header py-3">
		<div class="row">
			<div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($pages && $pages->id)?'Edit Page':'Add Page'?></h6></div>
			<div class="col-sm-6 text-right">
				<button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
				<button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<form class="user" id="manageForm">
			<div class="row">
				<input type="hidden" name="id" value="<?php echo ($pages && $pages->id)?$pages->id:''?>">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Title</label>
								<input type="text" class="form-control validate" autocomplete="off" name="title" data-validate-msg="Title field is required" placeholder="Enter Page Title" value="<?php echo ($pages && $pages->title)?$pages->title:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Alias</label>
								<input type="text" class="form-control slug validate" autocomplete="off" name="slug" data-validate-msg="Alias field is required"  placeholder="Enter Alias" value="<?php echo ($pages && $pages->slug)?$pages->slug:''?>">
							</div> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea class="form-control tinymce validate" name="description" data-validate-msg="Description field is required" rows="5"><?php echo ($pages && $pages->description)?$pages->description:''?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col text-right">
							<button class="btn btn-primary saveButton" type="button">Save</button>
							<button class="btn btn-danger cancelButton" type="button">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>