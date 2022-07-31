<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>404 Page not found | Compare & Quote</title>
	<link rel="icon" href="<?php echo base_url();?>assets/front/img/favicon.png" type="image/png">
	
	<style>
	@import url('https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Roboto+Condensed:300,400,700&display=swap');
	/*
	font-family: 'Roboto Condensed', sans-serif;
	font-family: 'Open Sans Condensed', sans-serif;
	*/

	/* ********|| INITIALIZATION STARTS ||******** */
	body, html { width: 100%; line-height:17px; margin:0 !important;padding:0 !important;font-family: 'Roboto Condensed', sans-serif;font-display: auto; font-weight: 400; -webkit-font-smoothing: subpixel-antialiased;text-shadow: 1px 1px 1px rgba(0,0,0,0.004);font-size: 14px;  color:#212121; background: #fff;position: relative; z-index: 0; }


	*:focus{outline: none !important;outline-offset: none !important;outline-offset: 0 !important;}
	a {text-decoration: none ;-webkit-transition: all 0.3s ease; -moz-transition: all 0.3s ease; -o-transition: all 0.3s ease; -ms-transition: all 0.3s ease;transition: all 0.3s ease;}
	a:hover{text-decoration: none;}
	a:focus{ outline: none;text-decoration: none;}
	input:focus, label:focus{outline: none !important;outline-offset: none !important;outline-offset: 0 !important;}
	/* ********|| INITIALIZATION ENDS ||******** */


	/* ********|| PSEUDO ELEMENTS STARTS ||******** */
	::selection{ background-color:#212121; color:#fff} 
	::-moz-selection{ background-color:#212121; color:#fff}
	::-webkit-selection{ background-color:#212121; color:#fff}

	:-webkit-focus { outline: none !important; }
	:-moz-focus { outline: none !important; }
	:focus { outline: none !important; }

	select:-webkit-focusring { color: #c62827 !important;text-shadow: 0 0 0 #333;}
	select:-moz-focusring {color: #c62827 !important;text-shadow: 0 0 0 #333;}
	select:focusring {color: #c62827 !important; text-shadow: 0 0 0 #333;}

	::input-placeholder{ color:#999 !important;}
	::-moz-input-placeholder{ color:#999 !important;}
	::-webkit-input-placeholder{ color:#999 !important;}

	/*::-webkit-scrollbar-track{	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);box-shadow: inset 0 0 6px rgba(0,0,0,0.1);background-color: #ccc;}
	::-webkit-scrollbar{width: 5px;height: 5px;background-color: #ccc;}
	::-webkit-scrollbar-thumb{background-color: #ff7043;}*/
	/* ********|| PSEUDO ELEMENTS ENDS ||******** */

	.section-404{width: 100%;height: 100%;min-height: 100vh;position: relative;display: flex;z-index: 1;overflow: hidden;/*background-image: url(../img/bg-404-01.jpg);background-repeat: no-repeat;background-size: cover;background-position: bottom center;background-attachment: fixed;*/background: linear-gradient(-45deg,#de5cf3,#4ccfed);}
	.section-404 #projector {position: absolute;top: 0px;left: 0px;width: 100%;height: 100%;}
	/*.section-404:before{content: '';background-image: url(../img/bg-404.jpeg);background-repeat: no-repeat;background-size: cover;background-position: bottom center;width: 100%;height: 100%;top: 50%;left: 50%;transform: translate(-50%,-50%) scale(1.1,1.1);position: absolute;z-index: 2;filter: blur(4px);}*/
	/*.section-404:before {content: '';position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: linear-gradient(to left, #2ec4b6, #1c1d28);opacity: 0.9;}*/
	.section-404 .content-404{margin:auto auto auto 10%;width: 100%;max-width: 800px;position: relative;z-index: 3;background: inherit;overflow: hidden;border-radius: 30px;padding: 30px;box-shadow: rgba(0,0,0,0.2) 0 2px 5px;}
	.section-404 .content-404:before{content: '';width: calc(100% + 50px);height: calc(100% + 50px);position: absolute;top: -25px;left: -25px;bottom: -25px;right: -25px;background: inherit;box-shadow: inset 0 0 0 300px rgba(255,255,255,0.5);filter: blur(5px);z-index: -1;}
	.section-404 .content-404 .title{font-size: 280px;line-height: 250px;text-transform: uppercase;font-weight: 900;display: flex;letter-spacing: -15px;color: #978eee;text-shadow: rgba(0,0,0,0.3) 2px 2px 0px;margin: 0 0 20px;}
	.section-404 .content-404 .title .span-404{background: linear-gradient(-45deg,#de5cf3,#4ccfed);-webkit-background-clip: text;-webkit-text-fill-color: transparent;text-shadow: none;}
	.section-404 .content-404 .title .span{font-size: 90px;line-height: 70px;display: block;margin: auto 0;letter-spacing: 0;margin-left: 20px;color: #1c1d28;text-shadow: none;}
	.section-404 .content-404 .title .span2{font-size: 90px;line-height: 70px;margin: auto 0;letter-spacing: 0;margin-left: 20px; display: none;color: #1c1d28;text-shadow: none;}
	.section-404 .content-404 .sub-title{font-size: 30px;line-height: 30px;letter-spacing: 0;text-transform: uppercase;font-weight: 700;color: #1c1d28;text-shadow: rgba(255, 255, 255, 1) 0px 0px 20px;}
	.section-404 .content-404 .text{font-size: 20px;line-height: 20px;letter-spacing: 0;text-transform: uppercase;font-weight: 700;color: #1c1d28;text-shadow: rgba(255, 255, 255, 1) 0px 0px 20px;margin: 20px 0 10px;}
	.section-404 .content-404 .text a{color:#1c1d28;border: 1px solid #1c1d28;padding: 2px 10px;margin: 0 5px;border-radius: 4px;}
	.section-404 .content-404 .text a:hover{color:#fff;background: linear-gradient(-45deg,#de5cf3,#4ccfed);border-color: #978eee; text-shadow: none;}
	.section-404 .brand{position: absolute;padding: 10px;background: rgba(255, 255, 255, 0.5);border-radius: 10px;bottom: 15px;right: 15px;box-shadow: rgba(0,0,0,0.2) 0 2px 5px;}
	.section-404 .brand .logo{display: block;width: 160px;overflow: hidden; margin: 0 auto;}
	.section-404 .brand .logo img{width: 100%;height: 100%;object-fit: contain;}
	.section-404 .brand .copyright{color: #1c1d28;font-size: 9px;line-height: 10px;text-transform: uppercase;font-weight: 600;opacity: 0.8;text-align: center;}

	@media screen and (max-width:1280px){
	.section-404 .content-404 .title{font-size: 250px;line-height: 220px;}
	.section-404 .content-404 .title .span{font-size: 70px;line-height: 65px;}
	.section-404 .content-404 .sub-title{font-size: 28px;line-height: 28px;}
	}

	@media screen and (max-width:1024px){
	.section-404 .content-404{max-width: 560px;}
	.section-404 .content-404 .title{font-size: 200px;line-height: 200px;}
	.section-404 .content-404 .title .span{font-size: 60px;line-height: 50px;}
	.section-404 .content-404 .sub-title{font-size: 22px;line-height: 22px;}
	.section-404 .content-404 .text{font-size: 18px;line-height: 18px;}
	.section-404 .content-404 .navigation .navigation-menu > li a{font-size: 14px;line-height: 18px;}
	}
	@media screen and (max-width:990px){
	.section-404 .content-404{margin: auto;width: calc(100% - 120px);max-width: none;text-align: center;}
	.section-404 .content-404 .title{font-size: 200px;line-height: 200px;justify-content: center;letter-spacing: -10px;}
	.section-404 .content-404 .title .span{font-size: 60px;line-height: 50px;text-align: left;}
	.section-404 .content-404 .sub-title{font-size: 24px;line-height: 24px;}
	.section-404 .content-404 .text{font-size: 20px;line-height: 30px;}
	.section-404 .content-404 .navigation .navigation-menu{justify-content: center;}
	.section-404 .content-404 .navigation .navigation-menu > li a{font-size: 18px;line-height: 20px;}
	.section-404 .brand{left: 50%; transform: translateX(-50%); right: auto;}
	}
	@media screen and (max-width:990px) and (orientation:landscape){
	.section-404{flex-wrap: wrap;}
	.section-404 .content-404{margin: 30px auto;}
	.section-404 .content-404 .title{line-height: 160px;letter-spacing: -10px;}
	.section-404 .brand{position:relative;left: 50%; transform: translateX(-50%); right: auto;margin: auto 0;}
	}
	@media screen and (max-width:767px){
	.section-404{flex-wrap: wrap;}
	.section-404 .content-404 .title{flex-wrap: wrap;letter-spacing: -2px;}
	.section-404 .brand{position:relative; left: 50%; transform: translateX(-50%); right: auto;margin: auto 0;}
	}
	@media screen and (max-width:767px) and (orientation:portrait){
	.section-404 .content-404 .title .span{display: none;}
	.section-404 .content-404 .title .span2{margin: 0;display: block;width: 100%;text-align: center;font-size: 50px;line-height: 50px;}
	.section-404 .content-404 .sub-title {font-size: 26px;line-height: 26px;}
	}
	@media screen and (max-width:360px){
	.section-404 .content-404 .title{font-size: 140px;line-height: 140px;}
	}


	</style>
	
	<script type="text/javascript" src="<?php echo  base_url();?>assets/front/lib/jQuery/jquery-3.3.1.js"></script>
</head>

<body>
	<div class="section-404">
	<canvas id="projector" width="1349" height="371">Your browser does not support the Canvas element.</canvas>
		<div class="content-404">
			<div class="title"><span class="span-404">404</span><span class="span">Page<br>Not<br>Found</span><span class="span2">Page Not<br>Found</span></div>
			<div class="sub-title">Sorry the page you are looking for does not exist</div>
			<div class="text">You can explore our site back to the <a href="<?php echo base_url();?>">Homepage</a></div>
		</div>
		<div class="brand">
			<a href="<?php echo base_url();?>" class="logo"><img src="https://compareandquote.mdemo.us/uploads/settings/logo/logo2.png" alt=""/></a>
			<div class="copyright">Copyright &copy; 2019 | All rights & reserve</div>
		</div>
	</div>
	<script defer="defer" type="text/javascript" src="<?php echo  base_url();?>assets/front/lib/particles/easeljs-0.7.1.min.js"></script>
	<script defer="defer" type="text/javascript" src="<?php echo  base_url();?>assets/front/lib/particles/TweenMax.min.js"></script>
	<script defer="defer" type="text/javascript" src="<?php echo  base_url();?>assets/front/js/404page.js"></script>
</body>
</html>