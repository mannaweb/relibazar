<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto">Edit Review</h6></div>
      <div class="col-sm-6 text-right">
        <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
        <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form class="user" id="manageForm">
    	<div class="row">				
					<input type="hidden" name="id" value="<?php echo ($reviews && $reviews->id)?$reviews->id:''?>">				
				
				<div class="col-lg-12 col-xl-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Title</label>
								<input type="text" class="form-control validate" autocomplete="off" name="title" id="title" data-validate-msg="Title field is required"  placeholder="Enter Title" value="<?php echo ($reviews && $reviews->title)?$reviews->title:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Ratting</label>
								<input type="number" class="form-control validate" autocomplete="off" name="ratting" id="ratting" data-validate-msg="Ratting field is required"  placeholder="Enter Ratting" value="<?php echo ($reviews && $reviews->ratting)?$reviews->ratting:''?>" min="0" max="5">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label ">Comment</label>
								<textarea class="form-control" name="description" id="description" rows="5"><?php echo ($reviews && $reviews->description)?$reviews->description:''?></textarea>
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