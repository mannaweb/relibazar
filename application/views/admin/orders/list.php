<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row mb-2">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto">Orders List</h6>
			</div>
			<div class="col-sm-6 text-right">				
				<a href="javascript:void(0)" onclick="resetSearch()" class="btn btn-sm btn-primary" data-tooltip="Reset"><i class="fa fa-sync"></i></a>				
			</div>
		</div>
		<div class="row form-row mb-2">
			<input type="hidden" id="sortByField" value="">
			<input type="hidden" id="sortBy" value="">
			<div class="col-sm-3 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group mb-2">
					<select class="form-control select2-nosearch" id="perPage" onchange="searchFilter()">
						<option value="5">5 Per Page</option>
						<option value="10" selected>10 Per Page</option>
						<option value="20">20 Per Page</option>
						<option value="50">50 Per Page</option>
						<option value="100">100 Per Page</option>
						<option value="10000000000">All</option>
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4 offset-lg-2 col-xl-4 offset-xl-2">
				<div class="form-group mb-2">
					<input type="text" class="form-control" id="keyword" placeholder="Search by Order ID,price" onkeyup="searchFilter()" />
				</div>
			</div>
			<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3" style="display: none">
				<div class="form-group">
					<select class="form-control select2" id="product_id" onchange="searchFilter()" >
						<option value="" selected>Select Product</option>
						 <?php if($product_info){ foreach ($product_info as $value) { ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } } ?>   						
					</select>
				</div>
			</div>

			<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3" style="display: none">
				<div class="form-group">
					<select class="form-control select2" id="user_id" onchange="searchFilter()">
						<option value="" selected>Select user by email</option>
						 <?php
                         
						  if($user_email){ foreach ($user_email as $user) {
						  	 $decode = json_decode($user->user_info);
						   ?>

						  <option value="<?php echo $decode->email; ?>"><?php echo $decode->email; ?></option>
                         <?php } } ?>   						
					</select>
				</div>
			</div>


			<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3" style="display: none">
				<div class="form-group">
					<select class="form-control select2" id="user_phone" onchange="searchFilter()">
						<option value="" selected>Select user by phone</option>
						 <?php
                         
						  if($user_phone){ foreach ($user_phone as $user) {
						  	 $decode = json_decode($user->user_info);
						   ?>

						  <option value="<?php echo $decode->contact_number; ?>"><?php echo $decode->contact_number; ?></option>
                         <?php } } ?>   						
					</select>
				</div>
			</div>

			<div class="col-sm-3 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2" id="status" onchange="searchFilter()">
						<option value="" selected>Select Status</option>
						<?php if($status_info){ foreach($status_info as $status){?>
						<option value="<?php echo $status->id; ?>"><?php echo $status->title; ?></option>
					    <?php } } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
				<div class="form-group">
					<input type="text" name="startEnd" id="startEnd" placeholder="Date" class="form-control" readonly/>
				</div>
			</div>
		</div>

	</div>
	<div class="card-body">
		<div class="table-wrap">
			<div class="preloader">
				<?php $this->load->view('admin/common/default/loader');?>
			</div>
			<div class="table-responsive scrollTop">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							
							<!-- <th>
								<a href="javascript:void(0)" class="sorting ordering" onclick="sortBy('ordering','products.ordering','ASC')">
									<span class="title">Ordering</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting ordering_DESC"></i>
										<i class="fas fa-sort-down commonSorting ordering_ASC"></i>
									</span>
								</a>
							</th> -->
							<th width="100" class="nowrap">
								<a href="javascript:void(0)" class="sorting title" onclick="sortBy('name','products.name','ASC')">
									<span class="title">Order ID</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting title_DESC"></i>
										<i class="fas fa-sort-down commonSorting title_ASC"></i>
									</span>
								</a>
							</th>
						
							<th width="100" class="nowrap">
								<a href="javascript:void(0)" class="sorting created_date" onclick="sortBy('created_at','products.created_at','ASC')">
									<span class="title">Date</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting created_date_DESC"></i>
										<i class="fas fa-sort-down commonSorting created_date_ASC"></i>
									</span>
								</a>
							</th>
							<th>User Email/Phone</th>
							<th>Price</th>
							<th>Order Status</th>
							<th>Payment Status</th>
							 <?php if($this->uri->segment(2) != 'dashboard'){ ?>
							<th>Action</th>
						<?php } ?>
						</tr>
					</thead>
					<tbody id="ordersList">
						<tr><td colspan="15" align="center">Searching Datas...</td></tr>
					</tbody>
				</table>
			</div>
			<div class="row" id="paginationDiv"></div>
		</div>
	</div>
</div>