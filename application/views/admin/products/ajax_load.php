<div class="row ajax" id="row_url_<?php echo $last_id; ?>">


	<?php if($ptype == 2){ ?>
          <div class="col-md-2">
			<div class="form-group">
			<label class="control-label required">Weight</label>
			<input type="text" id="weight" class="form-control validate" autocomplete="off" name="weight[]" data-validate-msg="Weight field is required"  placeholder="Enter Weight" value="">
			</div>
			</div>
	<?php }else if($ptype == 3){ ?>
          <div class="col-md-2">
			<div class="form-group">
			<label class="control-label required">Piece</label>
			<input type="text" id="piece" class="form-control validate" autocomplete="off" name="piece[]" data-validate-msg="Weight field is required"  placeholder="Enter Piece" value="">
			</div>
			</div>
	<?php } ?>

			<div class="col-md-2">
							<div class="form-group">
								<label class="control-label required">Product Price</label>
								<input type="text" id="price" class="form-control" onkeyup="cal_product_product(this.value,<?php echo $last_id; ?>)" autocomplete="off" name="product_price[]" data-validate-msg="Price field is required"  placeholder="Enter  Product Price" value="">
							</div>
						</div>


			<div class="col-md-3">
			<div class="form-group">
			<label class="control-label required">Sale Price(Include TAX)</label>
			<input type="text" class="form-control validate" id="price<?php echo $last_id; ?>" autocomplete="off" name="price[]" data-validate-msg="Price field is required"  placeholder="Enter  Price" value="">
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
			<button type="button" class="btn btn-sm btn-danger" onclick="remove_div('<?php echo $last_id; ?>')"><i class="fal fa-times"></i></button>
		</div>
	</div>
	<input type="hidden" name="primary_id[]" value="">
</div>


