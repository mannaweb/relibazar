<?php $this->load->view('front/common/default/page_banner'); ?>
<section class="sec-checkout-page">
	<div class="container">
		<center>
			<?php echo (isset($msg)?$msg:''); ?>
		<table cellspacing=4 cellpadding=4>
			<tr><td>Your Order ID: </td><td> <?php echo (isset($order_id)?$order_id:''); ?></td></tr>
		</table><br>
		</center>
    </div>
</section>