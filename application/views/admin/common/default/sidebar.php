<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <?php $getUserDetails = getUserDetails($this->session->userdata('user_id')) ?>
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url()?>admin/dashboard">
  <div class="sidebar-brand-icon rounded-circle">
    <?php if(isset($getUserDetails->profile_image) && file_exists($getUserDetails->profile_image)){ ?>
        <img class="" src="<?php echo base_url().$getUserDetails->profile_image;?>">
      <?php }else{ ?>
        <img class="" src="<?php echo base_url().'assets/admin/img/user-default.png';?>">
      <?php } ?>
  </div>
  <div class="sidebar-brand-text mx-3"><?php echo $getUserDetails->name;?></div>
</a>
<hr class="sidebar-divider my-0">
<?php 
$getMenus = getMenus(json_decode($getUserDetails->access_management, true));
if($getMenus){ foreach($getMenus as $key=>$val){
?>
<?php if(isset($val['submenus'])){?>
<li class="nav-item <?php echo (in_array($val['codes'], $activeMenus) )?'active':'';?>">
  <a class="nav-link <?php echo (in_array($val['codes'], $activeMenus) )?'':'collapsed';?>" href="#" data-toggle="collapse" data-target="#collapse<?php echo $val['id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $val['id'];?>">
    <i class="<?php echo $val['icon'];?>"></i>
    <span><?php echo $val['name'];?></span>
  </a>
  <div id="collapse<?php echo $val['id'];?>" class="collapse <?php echo (in_array($val['codes'], $activeMenus) )?'show':'';?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="py-2 collapse-inner rounded">
      <?php foreach($val['submenus'] as $key1=>$val1){?>
      <a class="collapse-item <?php echo (in_array($val1['codes'], $activeMenus))?'active':'';?>" href="<?php echo base_url().$val1['link'];?>"><i class="<?php echo $val1['icon'];?>"></i> <?php echo $val1['name'];?></a>
      <?php } ?>
    </div>
  </div>
</li>
<?php } else { ?>
<li class="nav-item <?php echo (in_array('dashboard', $activeMenus))?'active':'';?>">
  <a class="nav-link" href="<?php echo base_url().$val['link'];?>">
    <i class="<?php echo $val['icon'];?>"></i>
    <span><?php echo $val['name'];?></span></a>
</li>
<?php } ?>
<?php } } ?>
<hr class="sidebar-divider d-none d-md-block">
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>