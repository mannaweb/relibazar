<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row mb-2">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto">Blogs list</h6>
			</div>
			<div class="col-sm-6 text-right">
				<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('add-blog', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
				<a href="<?php echo base_url()?>admin/add-blog" class="btn btn-sm btn-success" data-tooltip="Add"><i class="fa fa-plus"></i></a>
				<?php } ?>
				<?php if(getUserDetails($this->session->userdata('user_id'),'role_manage') && in_array('delete-blog', getUserDetails($this->session->userdata('user_id'),'role_manage'))){?>
				<a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="deleteBlog('all')" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
				<?php } ?>
				<a href="javascript:void(0)" onclick="resetSearch()" class="btn btn-sm btn-primary" data-tooltip="Reset"><i class="fa fa-sync"></i></a>
				<button class="btn btn-sm btn-warning sorting_a" data-tooltip="Save Ranking Order"><i class="fa fa-sort"></i></button>
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
			<div class="col-sm-6 col-md-6 col-lg-6 offset-lg-4 col-xl-6 offset-xl-4">
				<div class="form-group mb-2">
					<input type="text" class="form-control" id="keyword" placeholder="Search" onkeyup="searchFilter()" />
				</div>
			</div>
			<div class="col-sm-3 col-md-3 col-lg-4 col-xl-4">
				<div class="form-group">
					<select class="form-control select2" id="category" onchange="searchFilter()">
						<option value="" selected>Select Category</option>
						 <?php if($main_cat){ foreach ($main_cat as $value) { ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
            <?php } } ?>   						
					</select>
				</div>
			</div>
			<div class="col-sm-3 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="status" onchange="searchFilter()">
						<option value="" selected>Select Status</option>
						<option value="1">Active</option>
						<option value="2">In-Active</option>
						<option value="3">Pending</option>
					</select>
				</div>
			</div>
			<div class="col-sm-3 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="featured" onchange="searchFilter()">
						<option value="" selected>Select Featured</option>
						<option value="1">Yes</option>
						<option value="2">No</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
				<div class="form-group">
					<input type="text" name="startEnd" id="startEnd" placeholder="Created At" class="form-control" readonly/>
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
									<div class="custom-checkbox">
										<input type="checkbox" class="custom-input checkAll" id="customCheckcheckAll">
										<label class="custom-label" for="customCheckcheckAll"></label>
									</div>
							</th>
							<th>
								<a href="javascript:void(0)" class="sorting ordering" onclick="sortBy('ordering','post.ordering','ASC')">
									<span class="title">Ordering</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting ordering_DESC"></i>
										<i class="fas fa-sort-down commonSorting ordering_ASC"></i>
									</span>
								</a>
							</th>
							<th width="100">Image</th>
							<th>
								<a href="javascript:void(0)" class="sorting title" onclick="sortBy('title','post.title','ASC')">
									<span class="title">Name</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting title_DESC"></i>
										<i class="fas fa-sort-down commonSorting title_ASC"></i>
									</span>
								</a>
							</th>
							<th width="100" class="nowrap">
								<a href="javascript:void(0)" class="sorting created_date" onclick="sortBy('created_date','post.created_date','ASC')">
									<span class="title">Date</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting created_date_DESC"></i>
										<i class="fas fa-sort-down commonSorting created_date_ASC"></i>
									</span>
								</a>
							</th>

							<th>Status</th>
							<th>Featured</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="blogsList">
						<tr><td colspan="15" align="center">Searching Datas...</td></tr>
					</tbody>
				</table>
			</div>
			<div class="row" id="paginationDiv"></div>
		</div>
	</div>
</div>