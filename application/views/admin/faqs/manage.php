<div class="card shadow mb-4">
	<div class="card-header py-3">
		<div class="row">
			<div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($faqs && $faqs->id)?'Edit Faq':'Add Faq'?></h6></div>
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
				<input type="hidden" name="id" value="<?php echo ($faqs && $faqs->id)?$faqs->id:''?>">
				<div class="col-md-12">
					<div class="tab-content tab-content-basic">
						<?php
						foreach ($site_langs as $key => $value) { ?>
						<div class="tab-pane fade <?php echo ($value['is_default'] == 1)?'active show':''; ?>" id="<?php echo $value['lang_code'];?>-tab-href" role="tabpanel" aria-labelledby="<?php echo $value['lang_code'];?>-tab">
							<div class="row">
								<div class="col-md-12">
									<?php 
									if (isset($faqs) && isset($faqs->question) && isset($faqs->answer)) {
										$questions = json_decode($faqs->question,true);
										$answers = json_decode($faqs->answer,true);
									}
									?>
									<div class="form-group">
										<label class="control-label required">Question</label>
										<textarea class="form-control tinymce <?php echo ($value['is_default'] == 1)?'validate':''; ?>" name="question[<?php echo $value['lang_code'];?>]" data-validate-msg="Question field is required for <?php echo $value['name'];?>" rows="5"><?php echo (isset($questions) && isset($questions[$value['lang_code']]))?$questions[$value['lang_code']]:''?></textarea>
									</div>
								</div>
							</div>
			                <div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label required">Answer</label>
										<textarea class="form-control tinymce <?php echo ($value['is_default'] == 1)?'validate':''; ?>" name="answer[<?php echo $value['lang_code'];?>]" rows="5" data-validate-msg="Answer field is required for <?php echo $value['name'];?>"><?php echo (isset($answers) && isset($answers[$value['lang_code']]))?$answers[$value['lang_code']]:''?></textarea>
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