<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row mb-2">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto">Enquiry list</h6>
			</div>
			<div class="col-sm-6 text-right">
			
				<?php if(getUserDetails($this->session->userdata('user_id'),'access_management') && in_array('delete-enqiry', getUserDetails($this->session->userdata('user_id'),'access_management'))){?>
				<a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="deleteEnq('all')" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
				<?php } ?>
				<a href="javascript:void(0)" onclick="resetSearch()" class="btn btn-sm btn-primary" data-tooltip="Reset"><i class="fa fa-sync"></i></a>
			</div>
		</div>
		<div class="row form-row">
			<input type="hidden" id="sortByField" value="">
			<input type="hidden" id="sortBy" value="">
			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
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
			<div class="col-sm-8 col-md-9 col-lg-6 col-xl-3">
				<div class="form-group">
					<input type="text" class="form-control" id="keyword" placeholder="Search" onkeyup="searchFilter()" />
				</div>
			</div>

			

			<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="products" onchange="searchFilter()">
						<option value="" selected>Select Product</option>
						<?php 
						//print_r($products);die;
						if(count($products)>0){
							foreach ($products as $key => $value) { ?>
								<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
							<?php } } ?>
							
					</select>
				</div>
			</div>

			<input type="hidden" id="product_id" value="<?php echo $this->input->get('product'); ?>">
			

			<div class="col-sm-6 col-md-6 col-lg-2 col-xl-3">
				<div class="form-group">
					<input type="text"  name="startEnd" id="startEnd" placeholder="Created At" class="form-control" readonly/>
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
							<th width="50">
								Product
							</th>
							
							<th>
								<a href="javascript:void(0)" class="sorting name" onclick="sortBy('name','enquiries.name','ASC')">
									<span class="title">Name</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting name_DESC"></i>
										<i class="fas fa-sort-down commonSorting name_ASC"></i>
									</span>
								</a>
							</th>
                           <th>Email</th>
                           <th>Phone</th>
                           <th>Message</th>
							<th>
								<a href="javascript:void(0)" class="sorting created_at" onclick="sortBy('created_at','enquiries.created_at','ASC')">
									<span class="title">Created At</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting created_at_DESC"></i>
										<i class="fas fa-sort-down commonSorting created_at_ASC"></i>
									</span>
								</a>
							</th>
                        <th>Action</th>
							
						</tr>
					</thead>
					<tbody id="enquiriesList">
						<tr><td colspan="15" align="center">Searching Datas</td></tr>
					</tbody>
				</table>
			</div>
			<div class="row" id="paginationDiv"></div>
		</div>
	</div>
</div>