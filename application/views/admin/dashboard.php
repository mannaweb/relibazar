

<div class="row">
  <?php if($this->session->userdata('role') == 'admin'){?>
 <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?php echo base_url(); ?>admin/admins">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Admins</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $users; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>


  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?php echo base_url() ?>admin/categories">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Categories</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $categories; ?></div>
            </div>
            <div class="col-auto">
              <i class="fa fa-list-alt  fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

<div class="col-xl-3 col-md-6 mb-4">
    <a href="<?php echo base_url() ?>admin/products">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Products</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $products; ?></div>
            </div>
            <div class="col-auto">
              <i class="fab fa-product-hunt fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>


  <div class="col-xl-3 col-md-6 mb-4">
    <a href="<?php echo base_url() ?>admin/orders">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Orders</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $orders; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-gavel fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

<?php } ?>

    <div class="col-xl-12 col-md-12 mb-12">
   <label> Recent Orders</label>

   <div class="card shadow mb-4">
  
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
              <th>Action</th>
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
  </div>
 
 
</div>