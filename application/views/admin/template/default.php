<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <?php $this->load->helper('site_name_helper');?>
  <title><?php echo isset($pageTitle)?$pageTitle.' | Relibazar': 'Relibazar';?></title>
  <meta name="theme-color" content="#9298ff"> 
  <link href="<?php echo base_url();?>assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/admin/css/admin.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/admin/vendor/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/admin/vendor/select2/select2.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/admin/vendor/fancybox/jquery.fancybox.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/toastr.min.css">
 <?php if(isset($cssFiles)){ foreach ($cssFiles as $cssKey => $cssValue) { ?>
  <link href="<?php echo base_url();?>assets/admin/css/<?php echo $cssValue;?>.css" rel="stylesheet">
<?php } } ?>
  <link href="<?php echo base_url();?>assets/admin/css/style.css" rel="stylesheet">
</head>
<body id="page-top">
  <div id="wrapper">
    <?php $this->load->view('admin/common/default/sidebar'); ?>
    <div class="modal list-details-modal" id="listModal"></div>
    <div class="modal list-details-modal" id="userModal"></div>
      <div class="modal list-details-modal" id="orderModal"></div>
       <div class="modal status-details-modal" id="orderMaintance"></div>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php $this->load->view('admin/common/default/header'); ?> 
        <div class="container-fluid">
          <?php $this->load->view((isset($viewPage)?'admin/'.$viewPage:''));?>
        </div>
 </div>
<?php $this->load->view('admin/common/default/footer'); ?>
</body>
</html>
