<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('admin/common/login/header'); ?> 
<body class="bg-gradient-primary">
	<div class="login-page">
		<div class="container m-auto">
			<?php $this->load->view((isset($viewPage)?'admin/'.$viewPage:''));?> 
		</div>
	</div>

	<?php $this->load->view('admin/common/login/footer'); ?>

</body>

</html>