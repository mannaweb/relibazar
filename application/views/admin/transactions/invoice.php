<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title><?php echo $getInvoice->inv_id;?></title>
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/front/img/favicon.png" type="image/x-icon">
	<style>
		@font-face{font-family: 'Nunito-EL';	src: url('<?php echo base_url();?>assets/front/font/Nunito/Nunito_ExtraLight.ttf');}
		@font-face{font-family: 'Nunito-L';		src: url('<?php echo base_url();?>assets/front/font/Nunito/Nunito_Light.ttf');}
		@font-face{font-family: 'Nunito-R';		src: url('<?php echo base_url();?>assets/front/font/Nunito/Nunito_Regular.ttf');}
		@font-face{font-family: 'Nunito-SB';	src: url('<?php echo base_url();?>assets/front/font/Nunito/Nunito_SemiBold.ttf');}
		@font-face{font-family: 'Nunito-B';		src: url('<?php echo base_url();?>assets/front/font/Nunito/Nunito_Bold.ttf');}
		@font-face{font-family: 'Nunito-EB';	src: url('<?php echo base_url();?>assets/front/font/Nunito/Nunito_ExtraBold.ttf');}
		@font-face{font-family: 'Nunito-BL';	src: url('<?php echo base_url();?>assets/front/font/Nunito/Nunito_Black.ttf');}
		
		@font-face{font-family:'Titillium-EL';	src:url('<?php echo base_url();?>assets/front/font/Titillium_Web/TitilliumWeb-ExtraLight.ttf');}
		@font-face{font-family:'Titillium-L';		src:url('<?php echo base_url();?>assets/front/font/Titillium_Web/TitilliumWeb-Light.ttf');}
		@font-face{font-family:'Titillium-R';		src:url('<?php echo base_url();?>assets/front/font/Titillium_Web/TitilliumWeb-Regular.ttf');}
		@font-face{font-family:'Titillium-SB';	src:url('<?php echo base_url();?>assets/front/font/Titillium_Web/TitilliumWeb-SemiBold.ttf');}
		@font-face{font-family:'Titillium-B';		src:url('<?php echo base_url();?>assets/front/font/Titillium_Web/TitilliumWeb-Bold.ttf');}
		@font-face{font-family:'Titillium-BL';	src:url('<?php echo base_url();?>assets/front/font/Titillium_Web/TitilliumWeb-Black.ttf');}
		
		@font-face{font-family:'Roboto-T';			src:url('<?php echo base_url();?>assets/front/font/Roboto/Roboto-Thin.ttf');}
		@font-face{font-family:'Roboto-L';			src:url('<?php echo base_url();?>assets/front/font/Roboto/Roboto-Light.ttf');}
		@font-face{font-family:'Roboto-R';			src:url('<?php echo base_url();?>assets/front/font/Roboto/Roboto-Regular.ttf');}
		@font-face{font-family:'Roboto-M';			src:url('<?php echo base_url();?>assets/front/font/Roboto/Roboto-Medium.ttf');}
		@font-face{font-family:'Roboto-B';			src:url('<?php echo base_url();?>assets/front/font/Roboto/Roboto-Bold.ttf');}
		@font-face {font-family: 'Roboto-BL';		src:url('<?php echo base_url();?>assets/front/font/Roboto/Roboto-Black.ttf');}
		
		@page {margin: 0cm;}
		*{box-sizing:border-box;}
		body{font-family: 'Nunito-L'; font-size: 14px; background: #f0f0f0; color:#000;width: 100%; height: 100%; padding: 120px 30px 50px; line-height: 10px;}
		.hr{margin: 10px 0;display: block; width: 100%; height: 1px; background: #eee; position: relative;}
		.ml-0{margin-left:0 !important;}
		.ml-5{margin-left:5px !important;}
		.ml-10{margin-left:10px !important;}
		.ml-15{margin-left:15px !important;}
		.ml-20{margin-left:20px !important;}
		.ml-25{margin-left:25px !important;}
		.ml-30{margin-left:30px !important;}
		.ml-p1{margin-left:1%;}
		.mr-0{margin-right:0 !important;}
		.mr-5{margin-right:5px !important;}
		.mr-10{margin-right:10px !important;}
		.mr-15{margin-right:15px !important;}
		.mr-20{margin-right:20px !important;}
		.mr-25{margin-right:25px !important;}
		.mr-30{margin-right:30px !important;}
		.mr-p1{margin-right:1%;}
		.mt-0{margin-top:0 !important;}
		.mt-5{margin-top:5px !important;}
		.mt-5{margin-top:5px !important;}
		.mt-10{margin-top:10px !important;}
		.mt-15{margin-top:15px !important;}
		.mt-20{margin-top:20px !important;}
		.mt-25{margin-top:25px !important;}
		.mt-30{margin-top:30px !important;}
		.mb-0{margin-bottom:0 !important;}
		.mb-5{margin-bottom:5px !important;}
		.mb-8{margin-bottom:8px !important;}
		.mb-10{margin-bottom:10px !important;}
		.mb-15{margin-bottom:15px !important;}
		.mb-20{margin-bottom:20px !important;}
		.mb-25{margin-bottom:25px !important;}
		.mb-30{margin-bottom:30px !important;}
		.mb-50{margin-bottom:50px !important;}
		.pl-0{padding-left:0 !important;}
		.pl-5{padding-left:5px !important;}
		.pl-10{padding-left:10px !important;}
		.pl-15{padding-left:15px !important;}
		.pl-20{padding-left:20px !important;}
		.pr-0{padding-right:0 !important;}
		.pr-5{padding-right:5px !important;}
		.pr-10{padding-right:10px !important;}
		.pr-15{padding-right:15px !important;}
		.pr-20{padding-right:20px !important;}
		.pt-0{padding-top:0 !important;}
		.pt-5{padding-top:5px !important;}
		.pt-10{padding-top:10px !important;}
		.pt-15{padding-top:15px !important;}
		.pt-20{padding-top:20px !important;}
		.pb-0{padding-bottom:0 !important;}
		.pb-5{padding-bottom:5px !important;}
		.pb-10{padding-bottom:10px !important;}
		.pb-15{padding-bottom:15px !important;}
		.pb-20{padding-bottom:20px !important;}
		.text-center{text-align:center;}
		.text-left{text-align:left;}
		.text-right{text-align:right;}
		.text-top{vertical-align:text-top;}
		.text-middle{vertical-align:middle;}
		.text-justify{vertical-align:justify;}
		.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12{float: left;position: relative;min-height: 1px; padding-left: 15px; padding-right: 15px;}
		.col-12{width: 100%;}
		.col-11{width: 91.66666667%;}
		.col-10{width: 83.33333333%;}
		.col-9{width: 75%;}
		.col-8{width: 66.66666667%;}
		.col-7{width: 58.33333333%;}
		.col-6{width: 50%;}
		.col-5{width: 41.66666667%;}
		.col-4{width: 33.33333333%;}
		.col-3{width: 25%;}
		.col-2{width: 16.66666667%;}
		.col-1{width: 8.33333333%;}
		.w-100{width:100%;}
		.w-80{width:80%;}
		.w-75{width:75%;}
		.w-60{width:60%;}
		.w-50{width:50%;}
		.w-40{width:40%;}
		.w-33{width:33.33%;}
		.w-30{width:30%;}
		.w-25{width:25%;}
		.w-20{width:20%;}
		.w-10{width:10%;}
		.cs-3{column-span:all;}
		.row {margin-right: -15px;margin-left: -15px;}
		.form-row {margin-right: -5px;margin-left: -5px;}
		.form-row > .col{padding-right: 5px;padding-left: 5px;}
		.clear-fix:before,.clear-fix:after,.row:before,.row:after{display: table;content:'';}
		.clear-fix:after,.row:after{clear: both;}
		.page-break-before{page-break-before: always;}
		.page-break-after{page-break-after: always;}
		.adjust-row{padding-left:15px;padding-right:15px;}
		.border-0{border:none !important;}
		.adjust-row > .row > .col-6{width:49%;}
		.adjust-row .panel .panel-body{padding: 10px 0;}
		.t-container{ display: table; width: 100%; overflow: hidden;}
		.t-container .t-row{ display: table-row;border-bottom:1px solid #eee;}
		.t-container .t-row:last-child{ border-bottom:none;}
		.t-container .t-row .t-cell{display: table-cell; vertical-align: text-top;}
		.bb{border-bottom: 1px solid #ddd;}
		.va-middle .t-cell{vertical-align:middle;}
		.text-cap{text-transform: capitalize}
		.text-limit{line-height:8px !important; max-height: 39px; overflow: hidden;}
		.lh-10{line-height:10px !important;}
		.lh-12{line-height:12px !important;}
		.lh-14{line-height:14px !important;}
		.fs-14{font-size:14px !important;}
		.fs-16{font-size:16px !important;}
		span.strong{font-family: 'Nunito-SB';}
		span.input-feild{ border-bottom: 1px solid #212121;border-top: 5px solid transparent; display: inline-block; padding: 0 5px;line-height: 8px !important; font-size: 14px !important; font-family: 'Nunito-SB' !important; text-align: center;}
		
		
		header{background: #fff;margin:0;padding:20px 30px 0;position: fixed;top:0px;left: 0px;right: 0px; width: 100%; height: 60px;}
		header .brand{max-width: 180px;max-height: 40px; margin: 0 0 20px;float: left;}
		header .brand img{height: 50px;}
		header .page-title{font-family: 'Roboto-B'; font-size: 24px; float: right; margin-top: 20px;}
		
		.section{background: #fff;padding: 15px; border-radius: 10px; overflow: hidden; margin: 0 0 20px;}
		.invoice-user{}
		.invoice-user .name{font-family: 'Nunito-B'; font-size: 20px; line-height: 12px;}
		.invoice-user .email{}
		.invoice-user .contact{}
		.invoice-info{ text-align: right;}
		.invoice-info .invoice-id{}
		.invoice-info .invoice-id .label{display:block;}
		.invoice-info .invoice-id .data{display:block;font-family: 'Nunito-B'; font-size: 16px; line-height: 12px;}
		.invoice-info .date{}
		
		.ct-container{ display: table; width: 100%;border-radius: 10px; overflow: hidden;}
		.ct-container .ct-row{ display: table-row;}
		.ct-container .ct-row:last-child .ct-td:first-child{ border-bottom-left-radius:10px;;}
		.ct-container .ct-row:last-child .ct-td:last-child{ border-bottom-right-radius:10px;;}
		.ct-container .ct-row .ct-th{display: table-cell;padding: 10px;background:#ddd; font-size: 12px; font-family:'Nunito-SB'; text-transform: uppercase; color: #000; vertical-align:middle; }
		.ct-container .ct-row .ct-td{display: table-cell;padding: 10px;background:#fff;border-bottom:1px solid #eee; }
		.ct-container .ct-row .ct-td:first-child{border-left:1px solid #eee;}
		.ct-container .ct-row .ct-td:last-child{border-right:1px solid #eee;border-left:1px solid #eee; width:100px;}
		.particulars{font-size: 15px; line-height: 14px; padding: 10px;}
		.amount{font-family:'Nunito-SB';font-size: 14px;padding: 10px 0;line-height: 14px;}
		.grand-total{font-family:'Nunito-SB';font-size: 15px; text-align: right;}
		.sub-total{font-family:'Nunito-SB';font-size: 13px; text-align: right;}
		.gt-amount{font-family:'Nunito-B';font-size: 15px;}
		.sb-amount{font-family:'Nunito-B';font-size: 14px;}
		.amount-details{ background: #fff; border: 1px solid #eee; border-radius: 10px; padding: 10px 15px; margin: 0 0 20px;}
		.amount-details .amount-text{font-family:'Nunito-SB';font-size: 15px; line-height: 14px;}
		.amount-details .amount{font-family:'Nunito-EB';font-size: 15px; text-align: right; padding: 0;}
		.note{font-family:'Nunito-R'; font-size: 11px; text-align: center; color: #666; margin: 5px 0 0;}
		.note span{font-family:'Nunito-SB';}
		
		.footer{border-top:1px solid #ddd; padding-top: 10px;}
		.footer .t-cell .data{font-family: 'Nunito-R';font-size: 11px; line-height: 10px;color: #666 !important;}
		footer{position: fixed;bottom: 0px;left: 0px;right: 0px;width: 100%; height: 40px; padding: 0 30px;}
		footer .footer-text{font-family: 'Nunito-L';color: #666;font-size: 11px; text-align: center; line-height: 8px;}
		footer .footer-text a{text-decoration:none; color: #666; font-family: 'Nunito-R';}
	</style>
	</head>
	<body>
		<header class="clear-fix mb-30">
			<div class="brand">
				<img src="<?php echo $site_setting->logo;?>" alt="">
			</div>
			<div class="page-title">Invoice</div>
		</header>

		<footer>
			<div class="footer-text">Copyright @ <a href="<?php echo base_url();?>" target="_blank"><?php echo $site_setting->title;?></a> <?php echo date('Y');?> | All rights & reserved</div>
			<div class="footer-text"><span class="pr-5">Contact us at: <?php echo $site_setting->phone;?></span><span class="pl-5">Mail us at: <?php echo $site_setting->email;?></span></div>
		</footer>
		
		<div class="section">
			<div class="t-container">
				<div class="t-row">
					<div class="t-cell w-50">
						<div class="invoice-user">
							<div class="name"><?php echo $userdata->name;?></div>
							<div class="email"><?php echo $userdata->email;?></div>
							<div class="contact"><?php echo $userdata->phone;?></div>
						</div>
					</div>
					<div class="t-cell w-50">
						<div class="invoice-info">
							<div class="invoice-id">
								<spna class="data"><?php echo $getInvoice->inv_id;?></spna>
							</div>
							<div class="date"><?php echo date('dS M Y',strtotime($getInvoice->created_at));?></div>
							<span class="label"><?php echo ($getInvoice->status == 1)?'Paid':'Pending'; ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="ct-container mb-20">
			<div class="ct-row">
				<div class="ct-th">Listing Details</div>
				<div class="ct-th"></div>
			</div>
			<div class="ct-row">
			<div class="ct-td">
					<div class="particulars">Listing</div>
				</div>
				<div class="ct-td">
					<div class="amount"><?php echo $getInvoice->title;?></div>
				</div>
			</div>
			<div class="ct-row">
				<div class="ct-td">
					<div class="particulars">Start - End Destination</div>
				</div>
				<div class="ct-td">
					<div class="amount"><?php echo $getInvoice->start_address;?> - <?php echo $getInvoice->end_address;?></div>
				</div>
			</div>
			<div class="ct-row">
				<div class="ct-td">
					<div class="particulars">Pick Up - Drop Date</div>
				</div>
				<div class="ct-td">
					<div class="amount"><?php echo date('jS M, y',strtotime($getInvoice->pick_up_date));?> - <?php echo date('jS M, y',strtotime($getInvoice->drop_off_date));?></div>
				</div>
			</div>
		</div>
		
		<div class="ct-container mb-20">
			<div class="ct-row">
				<div class="ct-th">Particulars</div>
				<div class="ct-th text-right">Amount(s)</div>
			</div>

			<div class="ct-row">
				<div class="ct-td">
					<div class="particulars">Awarded Price</div>
				</div>
				<div class="ct-td text-right">
					<div class="amount"><?php echo ($getDefaultCurrency->before_after == 1)?$getDefaultCurrency->symbol.' '.number_format($getInvoice->awarded_price,2):number_format($getInvoice->awarded_price,2).' '.$getDefaultCurrency->symbol;  ?></div>
				</div>
			</div>
			
			
			<div class="ct-row">
				<div class="ct-td">
					<div class="particulars">Handling Price(<?php echo round($getInvoice->handling_percentage); ?>%)</div>
				</div>
				<div class="ct-td text-right">
					<div class="amount"><?php echo ($getDefaultCurrency->before_after == 1)?$getDefaultCurrency->symbol.' '.number_format($getInvoice->handling_price,2):number_format($getInvoice->handling_price,2).' '.$getDefaultCurrency->symbol;  ?></div>
				</div>
			</div>
			
			<div class="ct-row">
				<div class="ct-td">
					<div class="grand-total">Grand Total</div>
				</div>
				<div class="ct-td text-right">
					<div class="gt-amount"><?php echo ($getDefaultCurrency->before_after == 1)?$getDefaultCurrency->symbol.' '.number_format($getInvoice->amount,2):number_format($getInvoice->amount,2).' '.$getDefaultCurrency->symbol;  ?></div>
				</div>
			</div>
		</div>
		<!-- <?php if(($getInvoice->paid_amount) > 0){?>
		<div class="amount-details">
			<div class="t-container">
				<div class="t-row">
					<div class="t-cell">
						<div class="amount-text">Paid Amount</div>
					</div>
					<div class="t-cell">
						<div class="amount">R<?php echo number_format($getInvoice->paid_amount,2);?></div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?> -->
		<div class="note"><span>Note:</span> This is a computer generated invoice. Signature is not required.</div>
	</body>
</html>
