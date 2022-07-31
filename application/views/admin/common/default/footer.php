<!-- Footer -->
<footer class="sticky-footer">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Singla's Sweet <?php echo date('Y');?></span>
    </div>
  </div>
</footer>
<!-- End of Footer -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
			<div class="modal-footer justify-content-center">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a class="btn btn-primary" href="<?php echo base_url()?>admin/logout">Logout</a>
			</div>
		</div>
	</div>
</div>
<!-- Logout Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<input type="hidden" id="deleteData">
			<input type="hidden" id="deleteStatus">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ready to Delete?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">Select "Confirm" below if you are ready to delete your data.</div>
			<div class="modal-footer justify-content-center">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a class="btn btn-primary deleteButton" href="javascript:void(0)" onclick="deleteConfirm()">Confirm</a>
			</div>
		</div>
	</div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url();?>assets/admin/vendor/jquery/jquery.min.js"></script>
<script defer="defer" src="<?php echo base_url();?>assets/admin/vendor/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<!--<script src="<?php echo base_url();?>assets/admin/vendor/bootstrap/b4/popper.min.js"></script>-->
<script defer="defer" src="<?php echo base_url();?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<!--<script defer="defer" src="<?php echo base_url();?>assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>-->
<script defer="defer" src="<?php echo base_url();?>assets/admin/vendor/select2/select2.min.js"></script>
<script defer="defer" src="<?php echo base_url();?>assets/admin/vendor/fancybox/jquery.fancybox.min.js"></script>
<!-- Custom scripts for all pages-->
<script defer="defer" src="<?php echo base_url();?>assets/admin/js/tinymce/tinymce.min.js?apiKey=qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc"></script>
<!--<script defer="defer" src="<?php echo base_url();?>assets/admin/vendor/dropzone/dropzone.min.js"></script>-->
<script defer="defer" src="<?php echo base_url();?>assets/admin/js/admin.js"></script>
<script defer="defer" src="<?php echo base_url();?>assets/admin/js/toastr.min.js"></script>
<script defer="defer" type="text/javascript">
var BASE_URL = '<?php echo base_url();?>';
</script>
<?php if(isset($jsFiles)){ foreach ($jsFiles as $jsKey => $jsValue) { ?>
<script defer="defer" src="<?php echo base_url();?>assets/admin/js/<?php echo $jsValue;?>.js"></script>
<?php } } ?>