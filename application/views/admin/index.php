<?php 
  // check is_logged_in status
  if(user() && !user()->is_logged_in){
    redirect(base_url('/admin/setupfirst'));
  }
?>
<?php include'include/header.php';?>
<?php 
include'include/left_sideber.php';
?>
  <?php echo $main_content;?>
<?php include'include/footer.php';?>