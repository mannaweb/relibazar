<input type="hidden" id="start" value="<?php echo $start;?>">
<input type="hidden" id="end" value="<?php echo $end;?>">
<?php if($products){ foreach($products as $key=>$val){?>
	<tr>
		<td width="50">
			<div class="custom-checkbox">
					<input type="checkbox" class="custom-input singleCheck" id="customCheck<?php echo $val->id;?>" value="<?php echo $val->id;?>">
					<label class="custom-label" for="customCheck<?php echo $val->id;?>"></label>
				</div>
		</td>	
		<td width="100">
		<div class="form-group m-0">
			<input type="hidden" class="form-control ids" value="<?php echo $val->id;?>">
			<input type="number" min="0" class="form-control ordering" value="<?php echo $val->ordering;?>">
		</div>
		</td>	
		<td width="100"><div class="img-container"><a href="<?php echo getProductImage($val->id,'image');?>" class="d-block w-100 h-100" data-fancybox=""><img src="<?php echo getProductImage($val->id,'image');?>" alt=""/></a></div></td>

		<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-product', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
		<td><a href="<?php echo base_url()?>admin/edit-product/<?php echo $val->slug;?>" target="_blank"><?php echo $val->name;?></a></td>
		 <td></td>
	    <td width="100" class="nowrap"><a href="<?php echo base_url()?>admin/edit-product/<?php echo $val->slug;?>" target="_blank"> <?php echo date('d M, Y',strtotime($val->created_at));?></a></td>
		 <?php } else { ?>
        <td><?php echo $val->name;?></td>
         <td></td>
	    <td><?php echo date('d M, Y',strtotime($val->created_at));?></td>
		<?php } ?>
		<!-- <td>
			<?php if($val->stock_status == 'instock'){ ?>
				<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">In stock</span></span>
			<?php }else if($val->stock_status == 'outofstock'){ ?>
				<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Out of stock</span></span>
			<?php }else{ ?>
				<span class="btn btn-xs btn-warning btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">On backorder</span></span>
			<?php } ?>
		</td> -->
 <?php if($val->product_type == 1){
    	
        $price = $val->selling_price;
        $min_weight ='';
        $parm = '';
    }else if($val->product_type == 2){
   		$jsonPrice = json_decode($val->selling_price,true);
   		$min_weight = min($jsonPrice['weight']);
        $min_price = min($jsonPrice['price']);
       
        $price = $min_price;
        $foreachData = $jsonPrice['weight'];
        $parm = 'gm';
    }else if($val->product_type == 3){
   		$jsonPrice = json_decode($val->selling_price,true);
   		$min_weight = min($jsonPrice['piece']);
        $min_price = min($jsonPrice['price']);
       
        $price = $min_price;
        $foreachData = $jsonPrice['piece'];
        $parm = 'pc';
    } ?>
<?php if($val->product_type == 1){ ?>
		<td>₹<?php echo number_format((float)$val->selling_price, 2, '.', ''); ?>-<?php if($val->stock_status == 'instock'){?> <i class="badge badge-success">In Stock</i><?php }else if($val->stock_status == 'outofstock'){ ?><i class="badge badge-danger">Out of stock</i><?php }else{?><i class="badge badge-warning">On Backorder</i><?php } ?></td>
	<?php }else{ ?>
		<td>
       <?php 
					foreach($foreachData as $jkey => $jweight){
						$rowPrice = $jsonPrice['price'][$jkey];
					?>
					<p><span>₹<?php echo number_format((float)$rowPrice, 2, '.', ''); ?>(<?php echo $jweight ?><?php echo $parm;?>) - <?php if($jsonPrice['stock'][$jkey] == 'outofstock'){ ?> <i class="badge badge-danger">Out of Stock</i> <?php } ?> <?php if($jsonPrice['stock'][$jkey] == 'instock'){ ?><i class="badge badge-success">In Stock</i><?php } ?></span></p>
				    <?php } ?>
				</td>
	<?php } ?>
	<td><?php echo $val->tax; ?></td>
	    <td id="status_td_<?php echo $val->id;?>">
			<?php if($val->status == 1){ ?>
				<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Active</span></span>			
			<?php }else{ ?>
				<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Inactive</span></span>	
			<?php } ?>
		</td>	
        <td id="featured_td_<?php echo $val->id;?>"><?php echo ($val->featured == 1)?'<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Yes</span></span>':'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">No</span></span>';?></td>	
		<td>
			<div class="dropdown">
				<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Action</button>
				<div class="dropdown-menu dropdown-menu-right">
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('edit-blog', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/edit-product/<?php echo $val->slug;?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('gallery', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/gallery/product/<?php echo $val->slug;?>" target="_blank"><i class="fas fa-fw fa-images"></i> Image Gallery</a>
					<?php } ?>

					  <a class="dropdown-item" href="<?php echo base_url()?>admin/orders?product_id=<?php echo $val->id;?>" target="_blank"><i class="fas fa-gavel"></i> Orders</a>
                    <a class="dropdown-item" href="<?php echo base_url()?>admin/enquiries?product=<?php echo $val->id;?>" target="_blank"><i class="fa fa-question-circle"></i> Enquiries</a>



					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('change-status-product', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="statusChange(<?php echo $val->id;?>,<?php echo ($val->status == 1)?2:1;?>)" id="status_a_<?php echo $val->id;?>"><?php echo ($val->status == 1)?'<i class="fas fa-fw fa-times-circle"></i>  Deactivate':'<i class="fas fa-fw fa-check-circle"></i>  Activate';?></a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('change-featured-product', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="productFeatured(<?php echo $val->id;?>,<?php echo ($val->featured == 1)?2:1;?>)" id="featured_a_<?php echo $val->id;?>"><?php echo ($val->featured == 1)?'<i class="fas fa-fw fa-times-circle"></i> Non Featured':'<i class="fas fa-fw fa-check-circle"></i>  Featured';?></a>
					<?php } ?>

					

					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('seo', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="<?php echo base_url()?>admin/seo/product/<?php echo $val->id;?>" target="_blank"><i class="fab fa-fw fa-amazon"></i> SEO</a>
					<?php } ?>
					<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('delete-product', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
					<a class="dropdown-item" href="javascript:void(0)" onclick="deleteProduct(<?php echo $val->id;?>)"><i class="fas fa-fw fa-trash"></i> Delete</a>
					<?php } ?>
					</div>
			      </div>
            </td>
	</tr>
<?php } } else { ?>
	<tr><td colspan="15" align="center">No Products Found!</td>
	</tr>
<?php } ?>