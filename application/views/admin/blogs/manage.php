<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($blogs && $blogs->id)?'Edit Blog':'Add Blog'?></h6></div>
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
					<input type="hidden" name="id" value="<?php echo ($blogs && $blogs->id)?$blogs->id:''?>">
					<input type="hidden" name="logo" value="<?php echo ($blogs && $blogs->logo)?$blogs->logo:''?>">
					<div class="profile-image img-square">
						<div class="img-container">
							<img src="<?php echo getBlogImage( (($blogs && $blogs->id)?$blogs->id:''),'logo');?>" class="upic" alt=""/>
						</div>
						<input type="file" id="image" class="input-file" name="image" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="image" id="upBtn2"><span class="fas fa-camera"></span></label>
						<div class="note text-center">Minimum Dimension (350 x 250)</div>
					</div>
				</div>
				<div class="col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Blog Title</label>
								<input type="text" id="title" class="form-control validate" autocomplete="off" id="title" name="title" data-validate-msg="Blog Title field is required"  placeholder="Enter Blog Title" value="<?php echo ($blogs && $blogs->title)?$blogs->title:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Alias</label>
								<input type="text" id="slug" class="form-control validate" id="alias" autocomplete="off" name="alias" data-validate-msg="Alias field is required"  placeholder="Enter Alias" value="<?php echo ($blogs && $blogs->alias)?$blogs->alias:''?>">
							</div> 
						</div>
					</div>
					<?php 
						$cat_id = array();
						if(isset($blogs->category) && !empty($blogs->category)){
							$cat_id = explode(',', $blogs->category);
						}
					?>
                      <div class="row">
						<div class="col">
							<div class="permission-management-title required">Category</div>
							<div class="permission-management">
								<?php if($all_cat){ 
								foreach ($all_cat as $value) { 
									if($value->rootcategoryid == 0){
								  $check[$value->id] = array();
                                  if($value->id == $value->rootcategoryid){
                                  	$check[$value->id] = $value->rootcategoryid;
                                  }?>
								<div class="permission-item">
									<div class="item-header">
										<div class="custom-checkbox">
											<input name="main_cat_id[]" <?php if(isset($blogs->category) && in_array($value->id, $cat_id)){echo 'checked';}?> type="checkbox" value="<?php echo $value->id; ?>" class="custom-input main_cat">
											<label class="custom-label"><?php echo $value->name; ?></label>
										</div>
                                         <div class="right-btn">
											<button class="btn btn-primary check_class check-all" type="button" cat_val="<?php echo $value->id; ?>"><i class="far fa-fw fa-tasks"></i><span>Select all</span></button>
									
										</div>
										<a href="javascript:void(0)" class="btn-trigger"><i class="far fa-fw fa-angle-down"></i></a>
										</div>
									
									<div class="item-body">
										<ul class="permission-list">
											<?php if($all_cat){ foreach ($all_cat as $key => $val) { 
												if($value->id == $val->rootcategoryid){
											?>
											<li>
												<div class="custom-checkbox">
													<input name="sub_cat_id[]" <?php if(isset($blogs->category) && in_array($val->id, $cat_id)){echo 'checked';}?> type="checkbox" value="<?php echo $val->id; ?>" main_cat_val="<?php echo $val->rootcategoryid; ?>" class="custom-input sub_cat">
													<label class="custom-label"><?php echo $val->name; ?></label>
												</div>
											</li>
											<?php } } } ?>
										</ul>
									</div>
								</div>
								<?php } } } ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Short Description</label>
								<textarea class="form-control" id="short_description" name="short_description" rows="5" placeholder="Enter Short Description"><?php echo ($blogs && $blogs->short_description)?$blogs->short_description:''?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Description</label>
								<textarea class="form-control tinymce" id="description" name="description" rows="5" ><?php echo ($blogs && $blogs->description)?$blogs->description:''?></textarea>
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