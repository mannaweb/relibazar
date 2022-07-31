<div class="card shadow mb-4">
	<div class="card-header py-3">
		<div class="row">
			<div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($howitworks && $howitworks->id)?'Edit How It Work':'Add How It Work'?></h6></div>
			<div class="col-sm-6 text-right">
				<button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
				<button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<ul class="nav nav-tabs tab-basic" role="tablist">
					<?php
					foreach ($site_langs as $key => $value) { ?>
						<li class="nav-item">
							<a class="nav-link <?php echo ($value['is_default'] == 1)?'active required':''; ?>" id="<?php echo $value['lang_code'];?>-tab" data-toggle="tab" href="#<?php echo $value['lang_code'];?>-tab-href" role="tab" aria-controls="<?php echo $value['lang_code'];?>-tab-href" aria-selected="false"><?php echo $value['name'];?></a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>

  	<div class="card-body">
    	<form class="user" id="manageForm">
    		<div class="row">
				<div class="col-lg-4 col-xl-3">
					<input type="hidden" name="id" value="<?php echo ($howitworks && $howitworks->id)?$howitworks->id:''?>">
					<input type="hidden" name="logo" value="<?php echo ($howitworks && $howitworks->logo)?$howitworks->logo:''?>">
					<div class="profile-image img-square">
						<div class="img-container">
							<img src="<?php echo getHowitworksImage( (($howitworks && $howitworks->id)?$howitworks->id:''),'logo');?>" class="upic" alt=""/>
						</div>
						<input type="file" id="image" class="input-file" name="image" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="image" id="upBtn2"><span class="fas fa-camera"></span></label>
					</div>
				</div>
				<div class="col-lg-8 col-xl-9">

					<div class="tab-content tab-content-basic">
						<?php
						foreach ($site_langs as $key => $value) { ?>
						<div class="tab-pane fade <?php echo ($value['is_default'] == 1)?'active show':''; ?>" id="<?php echo $value['lang_code'];?>-tab-href" role="tabpanel" aria-labelledby="<?php echo $value['lang_code'];?>-tab">
							<div class="row">
								<div class="col-md-12">
									<?php 
									if ($howitworks && isset($howitworks->title) && isset($howitworks->description)) {
										$titles = json_decode($howitworks->title,true);
										$descriptions = json_decode($howitworks->description,true);
									}
									?>
									<div class="form-group">
										<label class="control-label required">Title</label>
										<input type="text" class="form-control <?php echo ($value['is_default'] == 1)?'validate':''; ?>" autocomplete="off" name="title[<?php echo $value['lang_code'];?>]" data-validate-msg="Title field is required for <?php echo $value['name'];?>"  placeholder="Enter Title" value="<?php echo (isset($titles) && isset($titles[$value['lang_code']]))?$titles[$value['lang_code']]:''?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label required">Description</label>
										<textarea class="form-control <?php echo ($value['is_default'] == 1)?'validate':''; ?>" name="description[<?php echo $value['lang_code'];?>]" data-validate-msg="Description field is required for <?php echo $value['name'];?>" rows="5"><?php echo (isset($descriptions) && isset($descriptions[$value['lang_code']]))?$descriptions[$value['lang_code']]:''?></textarea>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
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