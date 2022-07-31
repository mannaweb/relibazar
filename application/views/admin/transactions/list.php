<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row mb-2">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto">Transactions List</h6>
			</div>
			<div class="col-sm-6 text-right">
				<a href="javascript:void(0)" onclick="resetSearch()" class="btn btn-sm btn-primary" data-tooltip="Reset"><i class="fa fa-sync"></i></a>
			</div>
		</div>
		<div class="row form-row mb-2">
			<input type="hidden" id="sortByField" value="">
			<input type="hidden" id="sortBy" value="">
			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="perPage" onchange="searchFilter()">
						<option disabled>Show Per Page</option>
						<option value="5">5 Per Page</option>
						<option value="10" selected>10 Per Page</option>
						<option value="20">20 Per Page</option>
						<option value="50">50 Per Page</option>
						<option value="100">100 Per Page</option>
						<option value="10000000000">All</option>
					</select>
				</div>
			</div>
			<div class="col-sm-8 col-md-9 col-lg-4 col-xl-3">
				<div class="form-group">
					<input type="text" class="form-control" id="keyword" autocomplete="off" placeholder="Search" onkeyup="searchFilter()" />
				</div>
			</div>
			<div class="col-sm-8 col-md-9 col-lg-4 col-xl-3">
				<div class="form-group">
					<input type="text"  name="startEnd" id="startEnd" placeholder="Date" class="form-control" readonly/>
				</div>
			</div>

			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2" id="listing_id" onchange="searchFilter()">
						<option value="">Listing</option>
						<?php foreach ($listings as  $value) { ?>
							<option value="<?php echo $value->id; ?>"<?php echo ((isset($_GET['listing_id']) && $_GET['listing_id'] == $value->id)?'selected':'') ?>><?php echo $value->title; ?></option>
						<?php } ?>
						
						
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2" id="user_id" onchange="searchFilter()">
						<option value="">User</option>
						<?php foreach ($users as  $value) { ?>
							<option value="<?php echo $value->id; ?>" <?php echo ((isset($_GET['user_id']) && $_GET['user_id'] == $value->id)?'selected':'') ?>><?php echo $value->name; ?></option>
						<?php } ?>
						
						
					</select>
				</div>
			</div>
			
      
		</div>
		<div class="row form-row mb-2">
			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="status" onchange="searchFilter()">
						<option value="">Pay Status</option>
						<option value="1">Paid</option>
						<option value="2">Pending</option>
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="pay_for" onchange="searchFilter()">
						<option value="">Payment For</option>
						<option value="1">Tensporter</option>
						<option value="2">Sender</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-wrap">
			<div class="preloader">
				<?php $this->load->view('admin/common/default/loader');?>
			</div>
			<div>
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								
								<th>
									<a href="javascript:void(0)" class="sorting name" onclick="sortBy('name','users.name','ASC')">
										<span class="title">User</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting name_DESC"></i>
											<i class="fas fa-sort-down commonSorting name_ASC"></i>
										</span>
									</a>
								</th>
								<th>
									<a href="javascript:void(0)" class="sorting title" onclick="sortBy('title','listings.title','ASC')">
										<span class="title">Listing</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting title_DESC"></i>
											<i class="fas fa-sort-down commonSorting title_ASC"></i>
										</span>
									</a>
								</th>

								<th>
									<a href="javascript:void(0)" class="sorting invoice_id" onclick="sortBy('invoice_id','transactions.invoice_id','ASC')">
										<span class="title">Invoice Id</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting invoice_id_DESC"></i>
											<i class="fas fa-sort-down commonSorting invoice_id_ASC"></i>
										</span>
									</a>
								</th>
								<th>
									<a href="javascript:void(0)" class="sorting awarded_price" onclick="sortBy('awarded_price','transactions.awarded_price','ASC')">
										<span class="title">Awarded Price</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting awarded_price_DESC"></i>
											<i class="fas fa-sort-down commonSorting awarded_price_ASC"></i>
										</span>
									</a>
								</th>
								<!-- <th>
									<a href="javascript:void(0)" class="sorting handling_percentage" onclick="sortBy('handling_percentage','transactions.handling_percentage','ASC')">
										<span class="title">Handling Percentage(%)</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting handling_percentage_DESC"></i>
											<i class="fas fa-sort-down commonSorting handling_percentage_ASC"></i>
										</span>
									</a>
								</th> -->
								<th>
									<a href="javascript:void(0)" class="sorting handling_price" onclick="sortBy('handling_price','transactions.handling_price','ASC')">
										<span class="title">Handling Price (%)</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting handling_price_DESC"></i>
											<i class="fas fa-sort-down commonSorting handling_price_ASC"></i>
										</span>
									</a>
								</th>
								<th>
									<a href="javascript:void(0)" class="sorting amount" onclick="sortBy('amount','transactions.amount','ASC')">
										<span class="title">Total Amount</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting amount_DESC"></i>
											<i class="fas fa-sort-down commonSorting amount_ASC"></i>
										</span>
									</a>
								</th>
								<th>
									<a href="javascript:void(0)" class="sorting status" onclick="sortBy('status','transactions.status','ASC')">
										<span class="title">Payment Status</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting status_DESC"></i>
											<i class="fas fa-sort-down commonSorting status_ASC"></i>
										</span>
									</a>
								</th>
								
                                <th>
								<a href="javascript:void(0)" class="sorting created_at" onclick="sortBy('created_at','transactions.created_at','ASC')">
									<span class="title">Date</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting created_at_DESC"></i>
										<i class="fas fa-sort-down commonSorting created_at_ASC"></i>
									</span>
								</a>
							</th>
							<th>Payment For</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="transactionsList">
							<tr><td colspan="15" align="center">Searching Datas...</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="row" id="paginationDiv"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="payModal"></div>