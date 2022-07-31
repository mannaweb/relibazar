<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row mb-2">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto">Email list</h6>
			</div>
			<div class="col-sm-6 text-right">
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
						<option value="30">30 Per Page</option>
						<option value="50">50 Per Page</option>
						<option value="100">100 Per Page</option>
						<option value="10000000000">All</option>
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-md-9 col-lg-6 offset-lg-4 col-xl-6 offset-xl-1">
				<div class="form-group">
					<input type="text" class="form-control" id="keyword" placeholder="Search" onkeyup="searchFilter()" />
				</div>
			</div>
				<div class="col-sm-4 col-md-9 col-lg-4 col-xl-3">
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
			<div>
				<div class="table-responsive">
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
									<a href="javascript:void(0)" class="sorting code" onclick="sortBy('code','email.code','ASC')">
										<span class="title">Code</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting code_DESC"></i>
											<i class="fas fa-sort-down commonSorting code_ASC"></i>
										</span>
									</a>
								</th>
								<th>
									<a href="javascript:void(0)" class="sorting email_for" onclick="sortBy('email_for','email.email_for','ASC')">
										<span class="title">Email For</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting email_for_DESC"></i>
											<i class="fas fa-sort-down commonSorting email_for_ASC"></i>
										</span>
									</a>
								</th>


									<th>
									<a href="javascript:void(0)" class="sorting email_for" onclick="sortBy('created_at','email.created_at','ASC')">
										<span class="title">Date</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting created_at_DESC"></i>
											<i class="fas fa-sort-down commonSorting created_at_ASC"></i>
										</span>
									</a>
								</th>

								<th>
									<a href="javascript:void(0)" class="sorting subject" onclick="sortBy('subject','email.subject','ASC')">
										<span class="title">Subject</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting subject_DESC"></i>
											<i class="fas fa-sort-down commonSorting subject_ASC"></i>
										</span>
									</a>
								</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="emailsList">
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