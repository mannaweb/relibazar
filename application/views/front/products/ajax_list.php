<?php 
if($products){ 
    foreach($products as $key=>$val){
    
    
    
    
?>


<div class="single-dish col-lg-4">
              <div class="thumb">
                <img class="img-fluid"  src="<?php echo productFileExists('uploads/products/'.$val->image,$val->image);?>" alt="">
              </div>
              <h4 class="text-uppercase pt-20 pb-20"><?php echo $val->name;?><span style="float: right;"><a href="javascript:void(0)"  onclick="addToCart(<?php echo $val->id; ?>)" class="genric-btn primary medium">Add</a></span></h4>
              <p>
                <?php echo $val->selling_price;?> INR
              </p>
            </div>

 
<?php } } else { ?>
    <p align="center" style="color: red;">No Product Found!</p>
    </tr>
<?php } ?>

