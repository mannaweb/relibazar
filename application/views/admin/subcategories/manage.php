<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($categories && $categories->id)?'Edit Category':'Add Category'?></h6></div>
      <div class="col-sm-6 text-right">
        <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
        <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form class="user" id="manageForm">
    	<div class="row">
				<div class="col-lg-4 col-xl-3">
					<input type="hidden" name="id" value="<?php echo ($categories && $categories->id)?$categories->id:''?>">
					
					<input type="hidden" name="image" value="<?php echo ($categories && $categories->image)?$categories->image:''?>">
					<div class="profile-image img-square">
						<div class="img-container">
							<img src="<?php echo getCatImage( (($categories && $categories->id)?$categories->id:''),'image');?>" class="upic" alt=""/>
						</div>
						<input type="file" id="image" class="input-file" name="img" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="image" id="upBtn2"><span class="fas fa-camera"></span></label>
					</div>
				</div>
				<div class="col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required">Sub Category Name</label>
								<input type="text" class="form-control validate" autocomplete="off" name="name" id="name" data-validate-msg="Sub Category Name field is required"  placeholder="Enter Category Name" value="<?php echo ($categories && $categories->name)?$categories->name:''?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required">Category Alias</label>
								<input type="text" class="form-control validate" autocomplete="off" name="slug" id="alias" data-validate-msg="Alias field is required"  placeholder="Enter Alias" value="<?php echo ($categories && $categories->slug)?$categories->slug:''?>">
							</div> 
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required">Main Category</label>
								<select class="form-control select2 validate" name="root_id" data-validate-msg="Main category field is required">
									<?php if($maincategories){ foreach ($maincategories as $value) { ?>
									<option value="<?php echo $value->id; ?>" <?php if(isset($categories->root_id) && $categories->root_id == $value->id){ echo "selected";} ?>><?php echo $value->name; ?></option>
									<?php } } ?>     
								</select>
							</div> 
						</div>
					</div>
					<div class="row">

						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label ">Short Description</label>
								<textarea class="form-control" name="short_description" id="short_description" rows="5"><?php echo ($categories && $categories->short_description)?$categories->short_description:''?></textarea>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label ">Long Description</label>
								<textarea class="form-control tinymce" name="long_description" id="long_description" rows="5"><?php echo ($categories && $categories->long_description)?$categories->long_description:''?></textarea>
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