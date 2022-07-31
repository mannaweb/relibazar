<section class="generic-banner relative">           
        <div class="container">
          <div class="row height align-items-center justify-content-center">
            <div class="col-lg-10">
              <div class="generic-banner-content">
                <h2 class="text-white">Orders</h2>
                <p class="text-white">It won’t be a bigger problem to find one video game lover in your <br> neighbor. Since the introduction of Virtual Game.</p>
              </div>
            </div>
          </div>
        </div>
      </section>  

        <div class="top-dish-area section-gap" id="dish">
            <div class="container">
                <form action="#" method="post">
                    <div class="row mb-4">                        
                        <div class="col-6 col-lg-6">
                            <input type="search" id="keyword" class="common-input mt-10" name="keyword" placeholder="Search" onkeyup="searchFilter();">
                        </div>

                         <div class="col-4 col-lg-4">
                            <input type="text" id="startEnd" class="common-input mt-10" name="startEnd" placeholder="Date" readonly>
                        </div>

                        
                        <div class="col-2 col-lg-2">
                            <button type="button" class="genric-btn primary" onclick="resetFilter();"><i class="fa fa-sync"></i></button>
                        </div>
                    </div>

               

                </form>
            </div>
        </div>

        <div class="container">
            <div class="row">
               <table class="table">
  <thead>
    <tr>
      <th scope="col">#Order ID</th>
     <!--  <th scope="col">Order</th> -->
    
      <th scope="col">Amount</th>
       <th scope="col">Date</th>
    
      <th scope="col">Order Status</th>
      <th scope="col">Payment Status</th>
       <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="orderList">
  </tbody>
  </table>

            </div>
        </div>
  
    <!-- ##### Blog Area End ##### -->