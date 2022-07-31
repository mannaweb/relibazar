   
<section class="generic-banner relative">           
        <div class="container">
          <div class="row height align-items-center justify-content-center">
            <div class="col-lg-10">
              <div class="generic-banner-content">
                <h2 class="text-white">Commission</h2>
                <p class="text-white">It won’t be a bigger problem to find one video game lover in your <br> neighbor. Since the introduction of Virtual Game.</p>
              </div>
            </div>
          </div>
        </div>
      </section>  

   <div class="top-dish-area section-gap" id="dish">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <!-- <h3>Get In Touch</h3> -->
                    </div>
                </div>
            </div>
             
            <div class="row">
                <div class="col-12">
                    <p style="text-align: center;"> refer link - <?php echo base_url().'signup?refer='.$user->username; ?></p>
                    <div class="section-top-border">
                        <h3 class="mb-30">Commission</h3>
                        <?php if(!empty($user->refer_id)){
                            $exp = explode(',', $user->refer_id);
                            foreach ($exp as $key => $value) {
                              $getUser = $this->db->get_where('users',array('id'=>$value))->row();
                              $getOrder = $this->db->get_where('orders',array('user_id'=>$value))->row();
                             ?>
                          
                        <div class="row">
                            <div class="col-lg-12">
                                <blockquote class="generic-blockquote">
                                <ul>
                                     <li>Name : <?php echo $getUser->name; ?></li>
                                     <li>Email : <?php echo $getUser->email; ?></li>
                                     <li>Commission : 2</li>
                                     <li>Status : <?php if(!empty($getOrder)){ echo "success";}else{ echo "pending";}?></li>
                                </ul>
                                </blockquote>
                            </div>
                        </div>
                    <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>