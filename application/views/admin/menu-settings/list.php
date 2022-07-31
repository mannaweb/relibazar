<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto">Menu settings</h6>
				<input type="hidden" id="count" value="0">
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12 col-lg-4 col-xl-3">
				<div class="menu-options">
                  <?php if($pages){?>
					<div class="menu-option-item">
						<div class="item-header">
							<a href="javascript:void(0)" class="active"><span>Pages</span> <i class="far fa-fw fa-angle-down"></i></a>
						</div>
						<div class="item-body active" style="display: block;">
							<div class="item-search">
								<input type="text" class="form-control" placeholder="Search" onkeyup="searchData(this.value,'page')" />
							</div>
							<ul class="item-list page">
								<?php foreach($pages as $key=>$val){ ?>
								<li>
									<div class="custom-checkbox">
										<input type="checkbox" class="custom-input" value="<?php echo $val->id?>">
										<label class="custom-label"><?php echo $val->title; ?></label>
									</div>
								</li>
								<?php } ?>
							</ul>
							<div class="item-action">
								<a href="javascript:void(0)" class="btn-select-all" onclick="selectAll('page')">Select All</a>
								<a href="javascript:void(0)" class="btn-addMenu" onclick="addToMenu('page')">Add to Menu</a>
							</div>
						</div>
					</div>
					<?php } ?>
					<!-- <?php if($posts){?>
					<div class="menu-option-item">
						<div class="item-header">
							<a href="javascript:void(0)" class=""><span>Posts</span> <i class="far fa-fw fa-angle-down"></i></a>
						</div>
						<div class="item-body">
							<div class="item-search">
								<input type="text" class="form-control" placeholder="Search" onkeyup="searchData(this.value,'post')"/>
							</div>
							<ul class="item-list post">
								<?php foreach($posts as $key=>$val){?>
								<li>
									<div class="custom-checkbox">
										<input type="checkbox" class="custom-input" value="<?php echo $val->id?>">
										<label class="custom-label"><?php echo $val->title?></label>
									</div>
								</li>
								<?php } ?>
							</ul>
							<div class="item-action">
								<a href="javascript:void(0)" class="btn-select-all" onclick="selectAll('post')">Select All</a>
								<a href="javascript:void(0)" class="btn-addMenu" onclick="addToMenu('post')">Add to Menu</a>
							</div>
						</div>
					</div>
					<?php } ?> -->
					<div class="menu-option-item">
						<div class="item-header">
							<a href="javascript:void(0)" class=""><span>Custom Link</span> <i class="far fa-fw fa-angle-down"></i></a>
						</div>
						<div class="item-body">
							<div class="item-search">
								<input type="text" class="form-control name" placeholder="Title" />
							</div>
							<div class="item-search">
								<input type="text" class="form-control url" placeholder="URL" />
							</div>
							<div class="item-action">
								<a href="javascript:void(0)" class="btn-addMenu" onclick="addToMenu('custom')">Add to Menu</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-8 col-xl-9">
				<div class="menu-manage"> 
					<div class="menu-selection">
						<label class="control-label">Select Menu : </label>
						<div class="input-field">
							<select class="form-control select2-nosearch menuname" onchange="menuChange(this.value)">
								<option value="" selected>Select Menu</option>
								<option value="header">Header</option>
								<option value="footer">Footer</option>
							</select>
						</div>
						<a href="javascript:void(0)" class="btn-saveMenu" onclick="saveData()">Save</a>
					</div>
					<div class="menu-organize">
						<div class="instruction">Drag each item into the order you prefer. Click the arrow on the right side of the item to reveal additional configuration options.</div>
						<div class="menu-box">
							<ul class="menu-list sortable">

							</ul>
						</div>
					</div>
					<div class="action-group">
						<a href="javascript:void(0)" class="btn-saveMenu" onclick="saveData()">Save</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>