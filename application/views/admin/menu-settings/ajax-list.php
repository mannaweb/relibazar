<?php 
if($menus && isset($menus->setting_value) && $menus->setting_value){ 
	$getdata = unserialize($menus->setting_value);
	if($getdata){
	$count = 0;
	foreach($getdata as $key=>$val){
		$count++;
	?>
	<li>
		<div class="item">
			<div class="item-title"><?php echo $val['title'];?>
				<a href="javascript:void(0)" class="item-trigger" onclick="toggleMenu(this)"><i class="far fa-fw fa-angle-down"></i></a>
			</div>
			<div class="item-body">
				<input type="hidden" class="type" value="<?php echo $val['type']?>">
				<input type="hidden" class="id" value="<?php echo $val['id']?>">
				<div class="form-group">
					<label class="control-label">Name</label>
					<input class="form-control title" type="text" value="<?php echo $val['title']?>">
				</div>
				<?php if($val['type'] == 'custom'){?>
					<div class="form-group">
						<label class="control-label">Url</label>
						<input class="form-control href" type="text" value="<?php echo $val['href']?>">
					</div>
				<?php } else {?>
					<input class="form-control href" type="hidden" value="<?php echo $val['href']?>">
				<?php } ?>
				<div class="form-group">
					<label class="control-label">Class</label>
					<input class="form-control class" type="text" value="<?php echo $val['class']?>">
				</div>
				<div class="action-group">
					<a href="javascript:void(0)" class="btn-remove" onclick="removeMenu(this)">Remove</a>
					<a href="javascript:void(0)" class="btn-cancel" onclick="cancelMenu(this)">Cancel</a>
				</div>
			</div>
		</div>
		<?php if(isset($val['children']) && !empty($val['children'])){?>
		<ul>
			<?php foreach($val['children'] as $key2=>$val2){
				$count++;
			?>
			<li>
				<div class="item">
					<div class="item-title"><?php echo $val2['title'];?>
						<a href="javascript:void(0)" class="item-trigger" onclick="toggleMenu(this)"><i class="far fa-fw fa-angle-down"></i></a>
					</div>
					<div class="item-body">
						<input type="hidden" class="type" value="<?php echo $val2['type']?>">
						<input type="hidden" class="id" value="<?php echo $val2['id']?>">
						<div class="form-group">
							<label class="control-label">Name</label>
							<input class="form-control title" type="text" value="<?php echo $val2['title']?>">
						</div>
						<?php if($val2['type'] == 'custom'){?>
							<div class="form-group">
								<label class="control-label">Url</label>
								<input class="form-control href" type="text" value="<?php echo $val2['href']?>">
							</div>
						<?php }else{?>
							<input class="form-control href" type="hidden" value="<?php echo $val2['href']?>">
						<?php } ?>
						<div class="form-group">
							<label class="control-label">Class</label>
							<input class="form-control class" type="text" value="<?php echo $val2['class']?>">
						</div>
						<div class="action-group">
							<a href="javascript:void(0)" class="btn-remove" onclick="removeMenu(this)">Remove</a>
							<a href="javascript:void(0)" class="btn-cancel" onclick="cancelMenu(this)">Cancel</a>
						</div>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
		<?php } ?>
	</li>
<?php } } } ?>

<script type="text/javascript">
	$('#count').val("<?php echo $count;?>");
</script>