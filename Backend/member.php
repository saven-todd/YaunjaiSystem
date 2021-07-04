<?php session_start(); 
include('../db.php');

  $ID = $_SESSION['ID'];
  $name = $_SESSION['name'];
  $level = $_SESSION['status'];
 	if($level!='1'){
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
            <?php include('menu_left.php');?>
        </div>
        <div class="col-md-9">
        <a href="member.php?act=add" class="btn-info btn-sm">เพิ่ม</a>
      <p></p>
      <?php
            $act = $_GET['act'];
            if($act == 'add'){
            include('member_form_add.php');
            }elseif ($act == 'edit') {
            include('member_form_edit.php');
            }
            else {
            include('member_list.php');
            }
            ?>
        </div>
        </div>
  </div>
  </body>
</html>

