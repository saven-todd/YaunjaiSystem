<?php 
session_start(); 
include('../db.php');
$ID = $_SESSION['ID'];
$name = $_SESSION['name'];
$profile_pic = $_SESSION['pic'];
$level = $_SESSION['status'];
$fbid = $_SESSION['fbid'];
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
        <?php include('menu_left.php');?>
        
        <!-- Content Wrapper. Contains page content -->
      </div>

      <div class="col-md-9">
      <a href="edite_admin.php?act=add" class="btn-info btn-sm">เพิ่ม</a>
      <p></p>
      <?php
            $act = $_GET['act'];
            if($act == 'add'){
            include('admin_form_add.php');
            }elseif ($act == 'edit') {
            include('admin_form_edite.php');
            }
            elseif ($act == 'rwd') {
              include('admin_form_rwd.php');
              }
            else {
            include('admin_list.php');
            }
            ?>
      </div>

    </div>
  </div>
  </body>
</html>