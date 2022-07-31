<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-6 d-flex"><h6 class="title my-auto"><?php echo ($products && $products->id)?'Edit Product':'Add Product'?></h6></div>
      <div class="col-sm-6 text-right">
        <button class="btn btn-sm btn-primary saveButton" type="button">Save</button>
        <button class="btn btn-sm btn-danger cancelButton" type="button">Cancel</button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form class="user" id="manageForm">
    	<div class="row">
				<div class="col-lg-4 col-xl-3">
					<input type="hidden" name="id" value="<?php echo ($products && $products->id)?$products->id:''?>">
					<input type="hidden" name="logo" value="<?php echo ($products && $products->image)?$products->image:''?>">
					<div class="profile-image img-square">
						<div class="img-container">
							<img src="<?php echo getProductImage((($products && $products->id)?$products->id:''),'image');?>" class="upic" alt=""/>
						</div>
						<input type="file" id="image" class="input-file" name="image" data-multiple-caption="{count} files selected" onchange="readURL(this)" />
						<label class="btn-file" for="image" id="upBtn2"><span class="fas fa-camera"></span></label>
						<div class="note text-center">Minimum Dimension (350 x 250)</div>
					</div>
				</div>
				<div class="col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Product Name</label>
								<input type="text" class="form-control validate" autocomplete="off" id="title" name="name" data-validate-msg="Product Name field is required"  placeholder="Enter Product Name" value="<?php echo ($products && $products->name)?$products->name:''?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Alias</label>
								<input type="text" id="slug" class="form-control validate" id="slug" autocomplete="off" name="slug" data-validate-msg="Alias field is required"  placeholder="Enter Alias" value="<?php echo ($products && $products->slug)?$products->slug:''?>">
							</div> 
						</div>
					</div>
					<?php 
						$cat_id = array();
						if(isset($products->category_ids) && !empty($products->category_ids)){
							$cat_id = explode(',', $products->category_ids);
						}
						if(isset($products->subcategory_ids) && !empty($products->subcategory_ids)){
							$subcat_id = explode(',', $products->subcategory_ids);
						}
					?>
                      <div class="row">
                      	<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">SKU</label>
								<input type="text" id="sku" class="form-control validate" autocomplete="off" name="sku" data-validate-msg="SKU field is required"  placeholder="Enter SKU" value="<?php echo ($products && $products->sku)?$products->sku:''?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Business Type</label>
								<select class="form-control select2 validate" name="bussiness_type" data-validate-msg="Bussiness type field is required">
									<?php if($business_types){ foreach ($business_types as $value) { ?>
									<option value="<?php echo $value->id; ?>" <?php if(isset($products->bussiness_type) && $products->bussiness_type == $value->id){ echo "selected";} ?>><?php echo $value->name; ?></option>
									<?php } } ?>     
								</select>
							</div>
						</div>

                      	<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Category</label>
								<select name="category[]" class="form-control select2 validate" data-validate-msg="Please select categories" onchange="getSubcat(this.value)">
									<option>Select Category</option>
									<?php if($all_cat){ foreach ($all_cat as $value) { ?>
									<option value="<?php echo $value->id; ?>" <?php if(isset($products->category_ids) && in_array($value->id,$cat_id)){ echo "selected";} ?>><?php echo $value->name; ?></option>
									<?php } } ?>             
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Sub Category</label>
								<select name="subcategory[]" class="form-control select2 validate" data-validate-msg="Please select sub categories" multiple="" id="subcat">
								           
								</select>
							</div>
						</div>
					</div>					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Short Description</label>
								<textarea class="form-control" id="short_description" name="short_description" rows="5" placeholder="Enter Short Description"><?php echo ($products && $products->short_description)?$products->short_description:''?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Description</label>
								<textarea class="form-control tinymce" id="description" name="description" rows="5" ><?php echo ($products && $products->long_description	)?$products->long_description	:''?></textarea>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label required">Product Type</label>
								<select class="form-control select2" id="ptype" name="ptype" onchange="product_type(this.value)">
									<option value="1"<?php  if($products && $products->product_type == 1){ echo 'selected';} ?>>Simple Product</option>
									<option value="2"<?php  if($products && $products->product_type == 2){ echo 'selected';} ?>>Variable product</option>
									<option value="3"<?php  if($products && $products->product_type == 3){ echo 'selected';} ?>>Quantity product</option>

								</select>
							</div>
						</div>

						<div class="col-md-6" id="status_stock">
							<div class="form-group">
								<label class="control-label required">Stock Status</label>
								<select name="stock_status" class="form-control select2 validate" data-validate-msg="Please select stock status">
									<option value="instock" selected="selected">In stock</option>
									<option value="outofstock">Out of stock</option>
									<option value="onbackorder">On backorder</option>
								</select>
							</div>
						</div>
					
					</div>


					<div class="col-md-4">
							<div class="form-group">
								<label class="control-label ">Tax Status</label>
								<div class="custom-checkbox">
									<input type="checkbox" class="custom-input " id="tax_status" name="tax_status" value="1" data-validate-msg="Please select tax status" onclick="showTax();" <?php if($products && $products->tax_status ==1){ echo 'checked';}?>>
									<label class="custom-label" for="tax_status">Taxable</label>
								</div>								
							</div>
						</div>


					<div class="row" style="display: none;" id="taxDiv">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label required">Tax(%)</label>
								<input type="text" id="tax" class="form-control " autocomplete="off" name="tax" data-validate-msg="tax field is required"  placeholder="Enter tax" value="<?php echo ($products && $products->tax)?$products->tax:''?>">
							</div> 
						</div>
					</div>

        
					<div class="row" id="price_div">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required">Regular Price</label>
								<input type="text" id="regular_price" class="form-control" autocomplete="off" name="regular_price" onkeyup="product_product(this.value)" data-validate-msg="Product regular price field is required"  placeholder="Enter Regular Price" value="<?php echo ($products && $products->regular_price)?$products->regular_price:''?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label required">Sale Price</label>
								<input type="text" id="selling_price" class="form-control " autocomplete="off" name="selling_price" data-validate-msg="Product sale price field is required"  placeholder="Enter Sale Price" value="<?php echo ($products && $products->selling_price)?$products->selling_price:''?>">
							</div> 
						</div>
					</div>	
                 <?php if($this->uri->segment(2)=='add-product'){ ?>
                          <div id="append_div" style="display: none">

                
					<div class="row"  >

						<div class="col-md-2 weight_div" id="weight_div">
							<div class="form-group">
								<label class="control-label required">Weight</label>
								<input type="text" id="weight" class="form-control" autocomplete="off" name="weight[]" data-validate-msg="Weight field is required"  placeholder="Enter Weight" value="">
							</div>
						</div>

						<div class="col-md-2 piece_div" id="piece_div" style="display: none">
							<div class="form-group">
								<label class="control-label required">Piece</label>
								<input type="text" id="piece" class="form-control" autocomplete="off" name="piece[]" data-validate-msg="Weight field is required"  placeholder="Enter Piece" value="">
							</div>
						</div>


						<div class="col-md-2">
							<div class="form-group">
								<label class="control-label required">Product Price</label>
								<input type="text" id="price" class="form-control" autocomplete="off" onkeyup="cal_product_product(this.value,0)" name="product_price[]" data-validate-msg="Price field is required"  placeholder="Enter  Product Price" value="">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label required">Sale Price(include tax)</label>
								<input type="text" id="price0" class="form-control" autocomplete="off" name="price[]" data-validate-msg="Price field is required"  placeholder="Enter  Price" value="">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label required">Stock Status</label>
								<select name="stock[]" class="form-control select2 validate" data-validate-msg="Please select stock status">
									<option value="instock" selected="selected">In stock</option>
									<option value="outofstock">Out of stock</option>
									<option value="onbackorder">On backorder</option>
								</select>
							</div>
						</div>

						<div class="col-md-1">
						<div class="form-group">
							<label class="control-label">&nbsp;</label><br>
							
							<button type="button" class="btn btn-sm btn-primary addCF" onclick=""><i class="fal fa-plus"></i></button>
							 
						</div>
					</div>
						
					</div>
				
                    </div>
               
                  <?php } else { ?>
                         <div id="append_div" style="display: none">

                    	<?php
                    	$typ = array();
                    	if(isset($price->weight)){
                    		 $typ = isset($price->weight)?$price->weight:'';
                    		}else{
                              $typ = isset($price->piece)?$price->piece:'';
                    		}
                  
				  if(isset($typ) && isset($products) && !empty($typ)){
				  	$i = 0;
				  	foreach ($typ as $key => $value){
				  		$i++;
				?>
					<div class="row" id="row_url_<?php echo $value; ?>" >

						<div class="col-md-2 weight_div" id="weight_div">
							<div class="form-group">
								<label class="control-label required">Weight</label>
								<input type="text" id="weight" class="form-control" autocomplete="off" name="weight[]" data-validate-msg="Weight field is required"  placeholder="Enter Weight" value="<?php echo isset($value)?$value:''; ?>">
							</div>
						</div>

						<div class="col-md-2 piece_div" id="piece_div" style="display: none">
							<div class="form-group">
								<label class="control-label required">Piece</label>
								<input type="text" id="piece" class="form-control" autocomplete="off" name="piece[]" data-validate-msg="Weight field is required"  placeholder="Enter Piece" value="<?php echo isset($value)?$value:''; ?>">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label class="control-label required">Product Price</label>
								<input type="text" id="price" class="form-control" autocomplete="off" name="product_price[]" onkeyup="cal_product_product(this.value,<?php echo $key; ?>)" data-validate-msg="Price field is required"  placeholder="Enter  Price" value="<?php echo $price->product_price[$key]; ?>">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label required">Sale Price(include TAX)</label>
								<input type="text" id="price<?php echo $key; ?>" class="form-control" autocomplete="off" name="price[]" data-validate-msg="Price field is required"  placeholder="Enter  Price" value="<?php echo $price->price[$key]; ?>">
							</div>
						</div>
                      
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label required">Stock Status</label>
								<select name="stock[]" class="form-control select2 validate" data-validate-msg="Please select stock status">
									<option value="instock" <?php if($price->stock[$key] == 'instock'){ echo 'selected';} ?>>In stock</option>
									<option value="outofstock" <?php if($price->stock[$key] == 'outofstock'){ echo 'selected';} ?>>Out of stock</option>
									<option value="onbackorder"  <?php if($price->stock[$key] == 'onbackorder'){ echo 'selected';} ?>>On backorder</option>
								</select>
							</div>
						</div>

						<div class="col-md-1">
						<div class="form-group">
							<label class="control-label">&nbsp;</label><br>
								<?php if($i == 1){?>
							<button type="button" class="btn btn-sm btn-primary addCF" onclick=""><i class="fal fa-plus"></i></button>
							 <?php }else{?>
						      <button type="button" class="btn btn-sm btn-danger" onclick="remove_div('<?php echo $value; ?>')"><i class="fal fa-times"></i></button>
						    <?php }?>
						</div>
					</div>
						<input type="hidden" name="primary_id[]" value="">
						
					</div>
				<?php } }else{ ?>
                       
					<div class="row"  >

						<div class="col-md-2 weight_div" id="weight_div">
							<div class="form-group">
								<label class="control-label required">Weight</label>
								<input type="text" id="weight" class="form-control" autocomplete="off" name="weight[]" data-validate-msg="Weight field is required"  placeholder="Enter Weight" value="">
							</div>
						</div>

						<div class="col-md-2 piece_div" id="piece_div" style="display: none">
							<div class="form-group">
								<label class="control-label required">Piece</label>
								<input type="text" id="piece" class="form-control" autocomplete="off" name="piece[]" data-validate-msg="Weight field is required"  placeholder="Enter Piece" value="">
							</div>
						</div>



                        
						<div class="col-md-2">
							<div class="form-group">
								<label class="control-label required">ProductPrice</label>
								<input type="text"  class="form-control" autocomplete="off" onkeyup="cal_product_product(this.value,0)" name="product_price[]" data-validate-msg="Price field is required"  placeholder="Enter  Price" value="">
							</div>
						</div> 

						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label required">Sale Price(include TAX)</label>
								<input type="text" id="price0" class="form-control" autocomplete="off" name="price[]" data-validate-msg="Price field is required"  placeholder="Enter  Price" value="">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label required">Stock Status</label>
								<select name="stock[]" class="form-control select2 validate" data-validate-msg="Please select stock status">
									<option value="instock" selected="selected">In stock</option>
									<option value="outofstock">Out of stock</option>
									<option value="onbackorder">On backorder</option>
								</select>
							</div>
						</div>

						<div class="col-md-1">
						<div class="form-group">
							<label class="control-label">&nbsp;</label><br>
							
							<button type="button" class="btn btn-sm btn-primary addCF" onclick=""><i class="fal fa-plus"></i></button>
							 
						</div>
					</div>
						
					</div>
				<?php } ?>
                    </div>
                  <?php } ?>

                  <?php if(!empty($typ)){ 

                  	$keys = array_keys($typ);
                      $last = end($keys);

                  	?>

<input type="hidden" name="primary_id[]" value="">
						<input type="hidden" class="row_count" value="<?php echo $last; ?>">

                 <?php } else { ?>

<input type="hidden" name="primary_id[]" value="">
						<input type="hidden" class="row_count" value="0">

                 <?php } ?>


					
											
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