 <?php $this->load->view('front/common/default/page_banner'); ?>

 <div class="receipe-post-area section-padding-80">
        <!-- Receipe Slider -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="receipe-slider owl-carousel">
                        <img src="<?php echo productFileExists((isset($catDetails->image)?$catDetails->image:''),(isset($catDetails->image)?$catDetails->image:''));?>" alt="" style="width: 1110px;height: 425px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipe Content Area -->
        <div class="receipe-content-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="receipe-headline my-5">
                            <span><?php echo date('F d,Y',strtotime($catDetails->created_at));?></span>
                            <h2><?php echo $catDetails->name;?></h2>
                            <div class="receipe-duration">
                                <h6><?php echo $catDetails->long_description;;?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-12 col-md-4">
                        <div class="receipe-ratings text-right my-5">
                            <div class="ratings">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </div>
                            <a href="#" class="btn delicious-btn">For Begginers</a>
                        </div>
                    </div> -->
                </div>
                
        </div>
    </div>