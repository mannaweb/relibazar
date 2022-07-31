<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto">Edit Email</h6></div>
      <div class="col-sm-6 text-right">
        <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
        <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form class="user" id="manageForm">
    	<div class="row">
    		<input type="hidden" name="id" value="<?php echo ($emails && $emails->id)?$emails->id:''?>">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Subject</label>
								<input type="text" class="form-control validate" autocomplete="off" id="subject" name="subject" data-validate-msg="Subject field is required"  placeholder="Enter Subject" value="<?php echo ($emails && $emails->subject)?$emails->subject:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Code</label>
								<input type="text" class="form-control validate" autocomplete="off" id="code" name="code" data-validate-msg="Code field is required" readonly  placeholder="Enter code..." value="<?php echo ($emails && $emails->code)?$emails->code:''?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required">Email For</label>
								<input type="text" class="form-control validate" autocomplete="off" id="email_for" name="email_for" data-validate-msg="Email for field is required" readonly  placeholder="Enter Email For" value="<?php echo ($emails && $emails->email_for)?$emails->email_for:''?>">
							</div> 
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required">From Email</label>
								<input type="text" class="form-control validate" autocomplete="off" id="from_email" name="from_email" data-validate-msg="From email field is required"  placeholder="Enter From Email" value="<?php echo ($emails && $emails->from_email)?$emails->from_email:''; ?>">
							</div> 
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required">From Name</label>
								<input type="text" class="form-control validate" autocomplete="off" name="from_name" id="from_name"data-validate-msg="From name field is required"  placeholder="From Name" value="<?php echo isset($emails->from_name)?$emails->from_name:'' ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea class="form-control tinymce" id="content" name="content" rows="5"><?php echo ($emails && $emails->content)?$emails->content:''?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							Only allow those variables: <?php echo ($emails && $emails->variables)?$emails->variables:''?>
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