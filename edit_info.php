<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="include/style.css">
    <?php include_once "include/header.php" ;
    require('db.php');
    include('auth.php');
    error_reporting( error_reporting() & ~E_NOTICE );
    //1. เชื่อมต่อ database:
    //2. query ข้อมูลจากตาราง tb_admin:
    if($ID !== ''){
      $sql = "SELECT * FROM user WHERE ID = $ID ;";
    } else {
      $sql = "SELECT * FROM user WHERE fb_id = '$fbid' ;";
    }
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
    $num_row = mysqli_num_rows($result);
    if($num_row == 1){
      //5 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
      $row = mysqli_fetch_array($result);
      extract($row);
      } else {
        $ID = $_SESSION['ID'];
        $username = $_SESSION['name'];
        $password = '';
        $name = $_SESSION['name'];
        $lastname = '';
        $birthdate = '';
        $email = '';
        $tel = '';
        $addr = '';
        $fbid = $_SESSION['fbid'];
      }
?>


</head>

<body>
    <p></p>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="info.php" class="list-group-item list-group-item-action">ข้อมูลส่วนตัว</a>
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
                        <form name="register" action="info_form_edit_db.php" method="POST" class="form-horizontal">
                            <input type="hidden" name="id" value="<?=$ID;?>">
                            <input type="hidden" name="fbid" value="<?=$fbid;?>">

                            <div class="form-group">
                                <div class="col-sm-10" align="left">
                                    <label for="" class="obj-text">ชื่อผู้ใช้งาน</label>
                                    <input name="m_username" type="text" required class="form-control" id="m_username"
                                        value="<?=$username;?>" placeholder="ชื่อผู้ใช้งาน" pattern="^[a-zA-Z0-9]+$"
                                        title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10" align="left">
                                    <label for="" class="obj-text">รหัสผ่าน</label>
                                    <input name="m_password" type="m_password" required class="form-control"
                                        id="m_password" value="<?=$password;?>" placeholder="รหัสผ่าน"
                                        pattern="^[a-zA-Z0-9]+$" minlength="2" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10" align="left">
                                    <label for="" class="obj-text">ชื่อ</label>
                                    <input name="m_name" type="text" required class="form-control" id="m_name"
                                        value="<?=$name;?>" placeholder="ชื่อ " />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10" align="left">
                                    <label for="" class="obj-text">นามสกุล</label>
                                    <input name="m_lastname" type="text" required class="form-control" id="m_lastname"
                                        value="<?=$lastname;?>" placeholder="นามสกุล " />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10" align="left">
                                    <label for="" class="obj-text">วันเกิด</label>
                                    <input name="m_birthdate" type="date" required class="form-control" id="m_birthdate"
                                        value="<?=$birthdate;?>" placeholder="วันเกิด " />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10" align="left">
                                    <label for="" class="obj-text">อีเมล</label>
                                    <input name="m_email" type="email" class="form-control" id="m_email"
                                        value="<?=$email;?>" placeholder=" อีเมล์ name@hotmail.com" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10" align="left">
                                    <label for="" class="obj-text">เบอร์โทรศัพท์</label>
                                    <input name="m_tel" type="text" class="form-control" id="m_tel"
                                        value="<?=$tel;?>" />

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10" align="left">
                                    <label for="" class="obj-text">ที่อยู่</label>
                                    <textarea name="m_addr" class="form-control" id="m_addr" value="<?=$addr;?>"
                                        required><?php echo $addr ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5" align="right">
                                    <button type="submit" class="btn btn-success" id="btn"><span
                                            class="glyphicon glyphicon-ok"></span> บันทึก </button>
                                </div>
                            </div>
                        </form>
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
<?php include "include/footer.php" ?>

</html>