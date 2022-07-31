<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row mb-2">
			<div class="col-lg-6 d-flex">
				<h6 class="title my-auto">Contact list</h6>
			</div>
			<div class="col-lg-6 text-right">
				<a href="javascript:void(0)" onclick="resetSearch()" class="btn btn-sm btn-primary" title="Reset"><i class="fa fa-sync"></i></a>
			</div>
		</div>
		<div class="row form-row">
			<input type="hidden" id="sortByField" value="">
			<input type="hidden" id="sortBy" value="">
			<div class="col-lg-2">
				<select class="form-control select2-nosearch" id="perPage" onchange="searchFilter()">
					<option disabled>Show Per Page</option>
					<option value="4">4 Per Page</option>
					<option value="10" selected>10 Per Page</option>
					<option value="20">20 Per Page</option>
					<option value="30">30 Per Page</option>
					<option value="50">50 Per Page</option>
					<option value="100">100 Per Page</option>
					<option value="10000000000">All</option>
				</select>
			</div>
			<div class="col-lg-6 offset-lg-3">
				<div class="form-group">
					<input type="text" class="form-control" id="keyword" placeholder="Search" onkeyup="searchFilter()" />

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
						
							<th>
								<a href="javascript:void(0)" class="sorting ordering" onclick="sortBy('ordering','contact.name','ASC')">
									<span class="title">Name</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting ordering_DESC"></i>
										<i class="fas fa-sort-down commonSorting ordering_ASC"></i>
									</span>
								</a>
							</th>
							<!-- <th width="100">Logo</th> -->
							<th>
								<a href="javascript:void(0)" class="sorting title" onclick="sortBy('title','contact.email','ASC')">
									<span class="title">Email</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting title_DESC"></i>
										<i class="fas fa-sort-down commonSorting title_ASC"></i>
									</span>
								</a>
							</th>
							<th>Phone</th>
							<th>Message</th>
						</tr>
					</thead>
					<tbody id="contactlist">
						<tr><td colspan="15" align="center">Searching Datas</td></tr>
					</tbody>
				</table>
			</div>
			<div class="row" id="paginationDiv"></div>
		</div>
	</div>
</div>