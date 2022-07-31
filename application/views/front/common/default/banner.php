<?php 
$getBanner = getBanner(array('type'=>'home'));
if($getBanner){
?>
<section class="hero-area">
        <div class="hero-slides owl-carousel">
            <?php foreach($getBanner as $k=>$banner){?>
            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img" style="background-image: url(<?php echo bannerFileExists($banner->image);?>);">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                            <div class="hero-slides-content" data-animation="fadeInUp" data-delay="100ms">
                                <h2 data-animation="fadeInUp" data-delay="300ms"><?php echo (isset($banner->title)?$banner->title:'')?></h2>
                                <div class="text" data-animation="fadeInUp" data-delay="700ms"><?php echo (isset($banner->description)?$banner->description:'')?></div>
                                <?php if($banner->link){ ?>
                                     <a href="<?php echo $banner->link; ?>" class="btn delicious-btn" data-animation="fadeInUp" data-delay="1000ms">Explore</a>
                               <?php } ?>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <?php }?>

        </div>
    </section>
    <?php }?>