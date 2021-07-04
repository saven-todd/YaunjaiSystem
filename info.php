<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="include/style.css">
    <?php include_once "include/headerauth.php" ;
    require('db.php');
    include('auth.php');
    error_reporting( error_reporting() & ~E_NOTICE );
    //1. เชื่อมต่อ database:
    //2. query ข้อมูลจากตาราง tb_admin:
    if($ID !== ''){
      $query = "SELECT * FROM user WHERE ID = $ID ;";
    } else {
      $query = "SELECT * FROM user WHERE fb_id = '$fbid' ;";
    }
    //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
    $result = mysqli_query($con, $query);
    $num_row = mysqli_num_rows($result);
    //4 . Check data row ว่ามี user นี้อยู่ใน DB หรือไม่ (กรณี loginผ่าน FB):
    if($num_row == 1){
    //5 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
      $row_am = mysqli_fetch_assoc($result); 
    } else {
      $row_am['ID'] = $_SESSION['ID'];
      $row_am['username'] = $_SESSION['name'];
      $row_am['name'] = $_SESSION['name'];
      $row_am['lastname'] = '';
      $row_am['tel'] = '';
      $row_am['birthdate'] = '';
      $row_am['RemainingPoints'] = '';
      $row_am['email'] = '';
      $row_am['addr'] = '';
      $row_am['fbid'] = $_SESSION['fbid'];
    }

    
    if($action == 'act'){
        echo "<div class=\"alert alert-success\">แจ้งชำระเงินเรียบร้อย ทางร้านจะตรวจสอบภายใน 24 ชม. ค่ะ ♥</div>";
    }
    if($action == 'arg'){
        echo "<div class=\"alert alert-danger\">พบข้อผิดพลาด โปรดลองใหม่อีกครั้งหรือติดต่อผู้ดูแลระบบ ♥</div>";
    }
    ?>



</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="info.php" class="list-group-item list-group-item-action active">ข้อมูลส่วนตัว</a>
                    <a href="past_list.php" class="list-group-item list-group-item-action">รายการสั่งซื้อที่ผ่านมา</a>
                    <a href="#" class="list-group-item list-group-item-action">ดูเมนูโปรด</a>
                    <hr>
                    <a href="logout.php" class="list-group-item list-group-item-action "
                        onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?')">ออกจากระบบ</a>
                </div>
            </div>

            <div class="col-6">
                <h3 align="center">ข้อมูลส่วนตัว</h3>
                <br>
                <table class="table">
                    <tr>
                    <tr>
                        <th>ชื่อผู้ใช้งาน </th>
                        <td> <?php echo $row_am['username']; ?> </td>
                    </tr>
                    <tr>
                        <th> ชื่อ </th>
                        <td> <?php echo $row_am['name']; ?> </td>
                    </tr>
                    <tr>
                        <th> นามสกุล </th>
                        <td> <?php echo $row_am['lastname']; ?> </td>
                    </tr>
                    <tr>
                        <th> เบอร์โทร</th>
                        <td> <?php echo $row_am['tel']; ?> </td>
                    </tr>
                    <tr>
                        <th> วันเกิด </th>
                        <td>
                            <?php 
                              echo date('d/m/Y ',strtotime($row_am['birthdate']));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th> คะแนนสะสม </th>
                        <td> <?php echo $row_am['RemainingPoints']; ?> </td>
                    </tr>
                    <tr>
                        <th> อีเมล </th>
                        <td> <?php echo $row_am['email']; ?> </td>
                    </tr>
                    <tr>
                        <th> ที่อยู่ </th>
                        <td> <?php echo $row_am['addr']; ?> </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="text-align: center;"><a href="edit_info.php?act=edit&ID=<?=$row_am['ID']?>" class="btn btn-success btn-sm"> แก้ไข
                            </a>
                        </td>
                    </tr>
                    </tr>

                </table>

                <br>
                <br>
                <br>
                <br>
            </div>
        </div>


        <div class="col-3">

        </div>
    </div>
    <p></p>
</body>
<?php 
include "include/footer.php"; 
?>

</html>