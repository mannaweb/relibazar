<div class="card shadow mb-4">
	<div class="card-header py-3">
		<div class="row">
			<div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($banners && $banners->id)?'Edit Banner':'Add Banner'?></h6></div>
			<div class="col-sm-6 text-right">
				<button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<form class="user" id="manageForm">
			<div class="row">
				<div class="col-lg-4 col-xl-3">
					<input type="hidden" name="id" value="<?php echo ($banners && $banners->id)?$banners->id:''?>">
					
					<input type="hidden" name="type_id" value="<?php  if($this->uri->segment(4)){ echo $this->uri->segment(4); }else{ echo 5;} ?>">
					<input type="hidden" name="image" value="<?php echo ($banners && $banners->image)?$banners->image:''?>">
					<div class="profile-image img-square">
						<div class="img-container">
							<img src="<?php echo getBannerImage( (($banners && $banners->id)?$banners->id:''),'image');?>" class="upic" alt=""/>
						</div>
						<input type="file" id="images" class="input-file" name="images" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="images" id="upBtn2"><span class="fas fa-camera"></span></label>
					</div>
				</div>



				<div class="col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Banner Title</label>
								<input type="text" class="form-control validate" autocomplete="off" name="title" data-validate-msg="Banner Title field is required"  placeholder="Enter Banner Title" value="<?php echo ($banners && $banners->title)?$banners->title:''?>">
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Link</label>
								<input type="text" class="form-control" autocomplete="off" name="link"   placeholder="Enter Button link" value="<?php echo ($banners && $banners->link)?$banners->link:''?>">
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea class="form-control" name="description" rows="5"><?php echo ($banners && $banners->description)?$banners->description:''?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col text-right">
							<button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>