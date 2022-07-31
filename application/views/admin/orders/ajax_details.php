<div class="modal-dialog">
	<div class="modal-content">
			
		<div class="modal-header">
			<h1 class="modal-title"><?php echo $orders->order_id; ?></h1>
			<button type="button" class="close" data-dismiss="modal">×</button>
		</div>		
		<div class="modal-body">
		
			<div class="details-wrap">
			 <div class="row">

			  	<div class="col-lg-6">
			  			<div class="alert alert-info">
			  		<h5>Order Info</h5>
			  		<ul>
			  			<li>Order ID : <?php echo $orders->order_id; ?></li>
			  			<li>Amount : ₹<?php echo $orders->total_amount; ?></li>
			  			<?php $orderStatus = $this->db->get_where('order_status',array('id'=>$orders->order_status))->row(); ?>
			  			<li>Current Status: <?php echo $orderStatus->title; ?></li>
			  			<li>Order Date : <?php echo date('d M, Y',strtotime($orders->created_at));?></li>
			  		</ul>
			  		 </div>
			  	</div>
			 
				<div class="col-lg-6">
					<div class="alert alert-info">
					<h5>User Info</h5>
					<ul>
			  			<li>Name : <?php $decode = json_decode($orders->user_info); echo $decode->user_name; ?></li>
			  			<li>Email : <?php echo $decode->email; ?></li>
			  			<li>Phone : <?php echo $decode->contact_number; ?></li>
			  			<li>Address : <?php echo $decode->delivery_address; ?></li>
			  		</ul>
			  	</div>
			  	</div>
			  	
<!-- <?php if($order_maintainence) { ?>
<div class="col-lg-12">
     <ul class="progress-tracker progress-tracker--text anim--path">
     	<?php foreach ($order_maintainence as $key => $val) { ?>
           <li class="progress-step is-active" aria-current="step">
              <a href="javascript::void(0)">
              <div class="progress-marker"></div>
              <div class="progress-text">
                <h4 class="progress-title"><?php echo $val->status_name; ?></h4>
              </div>
            </a>
          </li>
      <?php } ?>
        </ul>
</div>
<?php } ?> -->
<?php if($order_maintainence) { ?>
<div class="col-lg-12">
    <h5>Order Tracking</h5>
    <table class="table table-bordered track_tbl">
        <thead>
            <tr>
                <th></th>
                <th>S No</th>
                <th>Status</th>
                <th>Distibutor</th>
                <th>Date/Time</th>
            </tr>
        </thead>
        <tbody>
        	<?php 
        	$i =0;
        	foreach ($order_maintainence as $key => $val) {
        		$i++;
        	 ?>
            <tr class="active">
                <td class="track_dot">
                    <span class="track_line"></span>
                </td>
                <td><?php echo $i; ?></td>
                <td><?php echo $val->status_name; ?></td>
                <td>Singla Sweets</td>
                <td><?php echo date('d M, Y h:i A',strtotime($val->created_at));?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>

    <?php } ?>
 
<div class="col-lg-12">


 <h5>Order Details</h5>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Product Image</th>
      <th scope="col">Product Name</th>
       <th scope="col">Product Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Amount</th>
    </tr>
  </thead>
  <tbody>
  	<?php 
  	$decode_product = json_decode($orders->product_info);
  	$sum = 0;
  	foreach ($decode_product as $key => $value) { ?>
    <tr>
      <th scope="row"><img src="<?php echo base_url(); ?>uploads/products/<?php echo $value->product_image; ?>" class="img-thumbnail" width="70px"></th>
      <td><?php echo $value->product_name; ?></td>
       <td>₹<?php echo $value->product_price; ?></td>
      <td><?php echo $value->quantity; ?></td>
       <td>₹<?php echo $value->total; ?></td>
    </tr>
<?php 
 $sum+= $value->quantity;
} ?>
 <tr>
      <th scope="row"></th>
      <td></td>
       <td>Total Quantiny:</td>
      <td> <?php echo $sum; ?> &nbsp;&nbsp;&nbsp;&nbsp;Total Amount:</td>
      <td>₹<?php echo $orders->total_amount; ?></td>
    </tr>
  </tbody>
</table>
</div>




				</div>
			</div>
		</div>
	</div>
</div>

