<?php if($catlist){ foreach($catlist as $key=>$val){?>   
	<div class="single-dish col-lg-4">
							<div class="thumb">
								<img class="img-fluid"  src="<?php echo base_url().$val->image;?>" alt="">
							</div>
							<h4 class="text-uppercase pt-20 pb-20"><?php echo $val->name;?></h4>
							<p>
								<?php echo $val->short_description;?>
							</p>
</div>

<?php } } else { ?>
<p align="center" style="color: red;">No Category Found!</p>
<?php } ?>
