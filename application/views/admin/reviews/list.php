<div class="card shadow mb-4">
	<div class="card-header py-3 forms">
		<div class="row form-row mb-2">
			<div class="col-sm-6 d-flex">
				<h6 class="title my-auto">Reviews List</h6>
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
			<div class="col-sm-8 col-md-9 col-lg-4 col-xl-4">
				<div class="form-group">
					<input type="text" class="form-control" id="keyword" autocomplete="off" placeholder="Search" onkeyup="searchFilter()" />
				</div>
			</div>
			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-3">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="listing_id" onchange="searchFilter()">
						<option value="">Listing</option>
						<?php foreach ($listings as $key => $value) { ?>							
							<option value="<?php echo $value->id; ?>" <?php echo ((isset($_GET['listing_id']) && $_GET['listing_id'] == $value->id)?'selected':'') ?>><?php echo $value->title; ?></option>
						<?php } ?>						
					</select>
				</div>
			</div>
			<div class="col-sm-8 col-md-9 col-lg-4 col-xl-3">
				<div class="form-group">
					<input type="text"  name="startEnd" id="startEnd" placeholder="Date" class="form-control" readonly/>
				</div>
			</div>

		</div>
		<div class="row form-row mb-2">
			<!-- <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="status" onchange="searchFilter()">
						<option value="">Editable Review</option>
						<option value="1">Yes</option>
						<option value="2">No</option>
					</select>
				</div>
			</div> -->
			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="reviewTo_user_id" onchange="searchFilter()">
						<option value="">Review To</option>
						<?php foreach ($users as $key => $value) { ?>							
							<option value="<?php echo $value->id; ?>" <?php echo ((isset($_GET['reviewTo_user_id']) && $_GET['reviewTo_user_id'] == $value->id)?'selected':'') ?>><?php echo $value->name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-md-3 col-lg-2 col-xl-2">
				<div class="form-group">
					<select class="form-control select2-nosearch" id="reviewBy_user_id" onchange="searchFilter()">
						<option value="">Review By</option>
						<?php foreach ($users as $key => $value) { ?>							
							<option value="<?php echo $value->id; ?>" <?php echo ((isset($_GET['reviewBy_user_id']) && $_GET['reviewBy_user_id'] == $value->id)?'selected':'') ?>><?php echo $value->name; ?></option>
						<?php } ?>						
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
									<a href="javascript:void(0)" class="sorting title" onclick="sortBy('title','listing_reviews.title','ASC')">
										<span class="title">Review Title</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting list_title_DESC"></i>
											<i class="fas fa-sort-down commonSorting list_title_ASC"></i>
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
									<a href="javascript:void(0)" class="sorting name" onclick="sortBy('name','susers.name','ASC')">
										<span class="title">Review To</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting name_DESC"></i>
											<i class="fas fa-sort-down commonSorting name_ASC"></i>
										</span>
									</a>
								</th>
								<th>
									<a href="javascript:void(0)" class="sorting name" onclick="sortBy('name','rusers.name','ASC')">
										<span class="title">Review By</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting name_DESC"></i>
											<i class="fas fa-sort-down commonSorting name_ASC"></i>
										</span>
									</a>
								</th>

								<th width="150">
									<a href="javascript:void(0)" class="sorting ratting" onclick="sortBy('ratting','listing_reviews.ratting','ASC')">
										<span class="title">Ratting</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting ratting_DESC"></i>
											<i class="fas fa-sort-down commonSorting ratting_ASC"></i>
										</span>
									</a>
								</th>
								<th width="300">
									<a href="javascript:void(0)" class="sorting description" onclick="sortBy('description','listing_reviews.description','ASC')">
										<span class="title">Comment</span>
										<span class="sorting-icon">
											<i class="fas fa-sort-up commonSorting description_DESC"></i>
											<i class="fas fa-sort-down commonSorting description_ASC"></i>
										</span>
									</a>
								</th>
                                <th>
								<a href="javascript:void(0)" class="sorting created_at" onclick="sortBy('created_at','listing_reviews.created_at','ASC')">
									<span class="title">Date</span>
									<span class="sorting-icon">
										<i class="fas fa-sort-up commonSorting created_at_DESC"></i>
										<i class="fas fa-sort-down commonSorting created_at_ASC"></i>
									</span>
								</a>
							</th>
							<!-- <th>Editable Review</th> -->
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="reviewsList">
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