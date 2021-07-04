<?php session_start(); 
include('../db.php');

  $ID = $_SESSION['ID'];
  $name = $_SESSION['name'];
  $level = $_SESSION['status'];
 	if($level!='3'){
    Header("Location: ../logout.php");  
  }  
?>
<!DOCTYPE html>
<html>
<head>
<?php include('h.php');?>
<head>
  <body>
    <div class="container">
  <?php include('navbar.php');?>
  <p></p>
    <div class="row">
      <div class="col-md-3">
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('sell_menu_left.php');?>
        <!-- Content Wrapper. Contains page content -->
      </div>

      <div class="col-md-9">
      <a href="sell_product.php?act=add" class="btn-info btn-sm">เพิ่ม</a>
      <p></p>
      <?php
            $act = $_GET['act'];
              if($act == 'add'){
                include('sell_product_form_add.php');
              }elseif ($act == 'edit') {
                include('sell_product_form_edit.php');
              }
              else {
                include('sell_product_list.php');
              }
          ?>
      </div>

    </div>
  </div>
  </body>
</html>