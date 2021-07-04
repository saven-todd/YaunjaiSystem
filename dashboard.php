<?php session_start();
  $ID = $_SESSION['ID'];
  $name = $_SESSION['name'];
  $level = $_SESSION['status'];
  
  if($_SESSION["status"] == "1"){ 
    Header("Location: Backend/admin.php");
} else if($_SESSION["status"] == "3"){
    Header("Location: Backend/sell.php");
} else if($level!='2'){
    Header("Location: logout.php");  
  }  
   ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "include/headerauth.php" ;
    require('db.php');
    include('auth.php');
?>


</head>

<body>
    <p></p>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="info.php" class="list-group-item list-group-item-action">ข้อมูลส่วนตัว</a>
                    <a href="past_list.php"
                        class="list-group-item list-group-item-action">รายการสั่งซื้อที่ผ่านมา</a>
                    <a href="#" class="list-group-item list-group-item-action">ดูเมนูโปรด</a>

                    <hr>
                    
                    <a href="logout.php" class="list-group-item list-group-item-action "
                        onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?')">ออกจากระบบ</a>
                </div>
            </div>
            <div align="center" class="col-6">
                <h3>สวัสดี <?php echo $name; ?></h3>
            </div>
        </div>
        <div class="col-3">

        </div>
    </div>
</body>
<?php include "include/footer.php" ?>

</html>