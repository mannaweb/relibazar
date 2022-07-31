 <!-- BREADCRUMB AREA START -->
<?php $category = $this->db->get_where('categories',array('status'=>1,'root_id'=>0))->result(); ?>
 <div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image" data-bg="https://amcorp.com.sg/uploads/topics/16155341809169.jpg">

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">

                        <div class="section-title-area ltn__section-title-2">

                            <!-- <h6 class="section-subtitle ltn__secondary-color">//  Welcome to our company</h6> -->

                            <h1 class="section-title white-color">Account</h1>

                        </div>

                        <div class="ltn__breadcrumb-list">

                            <ul>

                                <li><a href="<?php echo base_url(); ?>">Home</a></li>

                                <li>Register</li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- BREADCRUMB AREA END -->



    <!-- LOGIN AREA START (Register) -->

    <div class="ltn__login-area pb-110">

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="section-title-area text-center">
    <?php if($this->input->get('type') == 'vendor'){?>
                        <h1 class="section-title">Start Selling in 3 simple steps</h1>
                     <br>
                     <div class="d-flex justify-content-center">
                        <div class="steps">
  <div class="step done">1. Signup for free</div>
  <div class="step active">2. Upload your product & category</div>
  <div class="step">3. Start Sell</div>

</div>
</div>
<?php }else{?>
     <h1 class="section-title">Sign Up</h1>
<?php } ?>

            <div class="row">

                <div class="col-lg-6 offset-lg-3">

                    <div class="account-login-inner">

                        <form id="signupForm" class="ltn__form-box contact-form-box">

                            <input type="text" class="validate" name="name" data-validate-msg="Name field is required" placeholder="Full Name*">

                            <input type="text" class="validate" name="phone" data-validate-msg="Phone field is required" placeholder="Phone*">

                            <input type="text" class="validate" name="email" data-validate-msg="Email field is required"  placeholder="Email*">

                            <?php if($this->input->get('type') == 'vendor'){?>
                               
                                  <input type="text" class="validate" name="pin_code" data-validate-msg="Pin Code field is required"  placeholder="Pin Code*">
                                   <input type="text" class="validate" name="location" data-validate-msg="Location field is required"  placeholder="Nearest Location*">
                                    <input type="text" class="validate" name="shop_name" data-validate-msg="Shop Name field is required"  placeholder="Shop Name">
                                     <p>Upload your Shop Image</p>
                                       <input type="file" name="shop_image" data-validate-msg="Shop photo field is required"  placeholder="Shop Photo"><br><br><br>

                            <?php } ?>
                         
                              <p>Choose Category</p>
                                
                                  <?php foreach ($category as $key => $value) { ?>
                                      <label class="checkbox-inline">
                                    
                                <input type="checkbox" name="category[]" value="<?php echo $value->id; ?>">

                              <?php echo $value->name; ?>

                            </label>
                                       
                                  <?php } ?>
                                  
                             
                         
                             <br> <br>

  

                            <input type="password" class="validate" id="password1" name="password" placeholder="Password*" data-validate-msg="Password field is required">

                              <input type="hidden" name="type" value="<?php echo $this->input->get('type'); ?>">

                            

  

                            

                            <label class="checkbox-inline">

                                <input type="checkbox" value="1" id="chkval">

                                By clicking "create account", I consent to the privacy policy.

                            </label>

                            <div class="btn-wrapper">

                                <button class="theme-btn-1 btn reverse-color btn-block signupButton" type="button">CREATE ACCOUNT</button>

                            </div>

                        </form>

                        <div class="by-agree text-center">

                            <p>By creating an account, you agree to our:</p>

                            <p><a href="#">TERMS OF CONDITIONS  &nbsp; &nbsp; | &nbsp; &nbsp;  PRIVACY POLICY</a></p>

                            <div class="go-to-btn mt-50">

                                <a href="<?php echo base_url(); ?>login">ALREADY HAVE AN ACCOUNT ?</a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Lato');

.steps {
  display: flex;
  overflow: hidden;
  line-height: 1.5;
  border: 2px solid #90b33e;
  padding: 0;
  margin: 0;
  border-radius: 5px;
  width: 900px;

}
.step {
  flex: 1;
  color: snow;
  text-decoration: none;
  padding: 10px 0 10px 45px;
  background: #abc570;
  position: relative;
  display: flex;
}
.step:first-child {
  padding-left: 15px;
}
.step:last-child {
  padding-right: 15px;
}
.step.active {
  background-color: #90b33e;
  color: #fff;
}
.step.active:after {
  border-left-color: #90b33e;
}
.step:after {
  content: " ";
  display: block;
  width: 0;
  height: 0;
  border-top: 50px solid transparent;
/* Go big on the size, and let overflow hide */
  border-bottom: 50px solid transparent;
  border-left: 30px solid #fff;
  position: absolute;
  top: 50%;
  margin-top: -50px;
  left: 100%;
  z-index: 2;
}
.step:before {
  content: " ";
  display: block;
  width: 0;
  height: 0;
  border-top: 50px solid transparent;
/* Go big on the size, and let overflow hide */
  border-bottom: 50px solid transparent;
  border-left: 30px solid #414141;
  position: absolute;
  top: 50%;
  margin-top: -50px;
  margin-left: 2px;
  left: 100%;
  z-index: 1;
}

.done {
  background-color: #80b500;
  color: snow;
}
.done:after {
  border-left-color: #80b500;
}


    </style>

    <!-- LOGIN AREA END -->