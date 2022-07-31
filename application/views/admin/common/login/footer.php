<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url();?>assets/admin/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?php echo base_url();?>assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<!-- <script src="<?php echo base_url();?>assets/admin/js/admin.js"></script> -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/toastr.min.css">
<script src="<?php echo base_url();?>assets/admin/js/toastr.min.js"></script>


<script type="text/javascript">
var BASE_URL = '<?php echo base_url();?>';
</script>
<?php if(isset($jsFiles)){ foreach ($jsFiles as $jsKey => $jsValue) { ?>
<script src="<?php echo base_url();?>assets/admin/js/<?php echo $jsValue;?>.js"></script>
<?php } } ?>