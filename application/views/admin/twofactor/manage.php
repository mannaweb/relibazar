<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"> <?php if($enable_tfa == 1){ ?>Disable <?php }else{ ?>Enable <?php } ?>Two Factor Authentication</h6></div>
     <!--  <div class="col-sm-6 text-right">
        <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
        <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
      </div> -->
    </div>
  </div>
  <div class="card-body">
    <form class="user" id="manageForm">
    	<div class="row">
    	
				<div class="col-lg-12 col-xl-12">
				
					<div class="row d-flex justify-content-center">
            
            <div class="col-md-4">
                <?php
            // echo $enable_tfa;die;
            if($enable_tfa != 1){ ?>
              <div class="input-form">
            <!--  <?php echo $qrCodeUrl; ?> -->
             <img src="<?php echo $qrCodeUrl; ?>">
              </div>
         
              <div class="input-form">
           <!--  <label>Provided Key</label> -->
           
              <p>Provided Key : <?php echo $tfa_enabled_secret; ?></p>
              </div>
              <?php } ?>

             <div class="input-form">
             <label>Two factor Code</label>
            <input type="text"  data-validate-msg="Code field is required" class="form-control validate" name="code" >
             </div>
             </div>
					</div>
 <input type="hidden" name="secret" value="<?php echo $tfa_enabled_secret; ?>">
					<div class="row">
						<div class="col text-right">
                <?php if($enable_tfa == 1){ ?>
							<button class="btn btn-primary saveButton" type="button">Disable</button>
             <?php }else{ ?>
               <button class="btn btn-primary saveButton" type="button">Enable</button>
            <?php } ?>
							<button class="btn btn-danger cancelButton" type="button">Cancel</button>
						</div>
					</div>
				</div>
			</div>
    </form>
  </div>
</div>