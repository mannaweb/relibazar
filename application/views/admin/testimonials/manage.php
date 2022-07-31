<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($testimonials && $testimonials->id)?'Edit Testimonial':'Add Testimonial'?></h6></div>
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
					<input type="hidden" name="id" value="<?php echo ($testimonials && $testimonials->id)?$testimonials->id:''?>">
					<input type="hidden" name="user_image" value="<?php echo ($testimonials && $testimonials->user_image)?$testimonials->user_image:''?>">
					<div class="profile-image img-square">
						<div class="img-container">
							<img src="<?php echo gettestimonialImage( (($testimonials && $testimonials->id)?$testimonials->id:''),'user_image');?>" class="upic" alt=""/>
						</div>
						<input type="file" id="image" class="input-file" name="image" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="image" id="upBtn2"><span class="fas fa-camera"></span></label>
					</div>
				</div>
				<div class="col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Name</label>
								<input type="text" class="form-control validate" autocomplete="off" name="name" id="name" data-validate-msg="Name field is required"  placeholder="Enter Name" value="<?php echo ($testimonials && $testimonials->name)?$testimonials->name:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Location</label>
								<input type="text" class="form-control validate" autocomplete="off" name="location" id="location" data-validate-msg="Location field is required"  placeholder="Enter City,State" value="<?php echo ($testimonials && $testimonials->location)?$testimonials->location:''?>">
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label ">Short Description</label>
								<textarea class="form-control" name="short_description" id="short_description" rows="5"><?php echo ($testimonials && $testimonials->short_description)?$testimonials->short_description:''?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label ">Description</label>
								<textarea class="form-control tinymce" name="description" id="description" rows="5"><?php echo ($testimonials && $testimonials->description)?$testimonials->description:''?></textarea>
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