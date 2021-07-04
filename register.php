<!DOCTYPE html>
<html lang="en">

<head>
<?php include_once "include/headerauth.php" ?>
</head>

<body>

    <?php
        
        if(isset($_REQUEST['username'])){
            $name = stripslashes($_REQUEST['name']);
            $name = mysqli_real_escape_string($con, $name);

            $lastname = stripslashes($_REQUEST['lastname']);
            $lastname = mysqli_real_escape_string($con, $lastname);

            $tel = stripslashes($_REQUEST['tel']);
            $tel = mysqli_real_escape_string($con, $tel);

            $user = stripslashes($_REQUEST['username']);
            $user = mysqli_real_escape_string($con, $user);

            $pass = stripslashes($_REQUEST['password']);
            $pass = mysqli_real_escape_string($con, $pass);

            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con, $email);

            $status = "2";
           

            $trn_date = date("Y-m-d H:i:s");
            $check = "SELECT username 
            FROM user  
            WHERE username = '$user' 
            ";
            $result1 = mysqli_query($con, $check) or die($mysqli->error);
            $num=mysqli_num_rows($result1);

            if($num > 0)
            {
            echo "<script>";
            // echo "alert(' ข้อมูลซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
            echo "window.history.back();";
            echo "</script>";
            }else{
                $query = "INSERT INTO user (name, lastname, tel, username, password, email, status, trn_date)
                            VALUES ('$name', '$lastname', '$tel', '$user', '$pass', '$email', $status, '$trn_date') ;";
                $result = mysqli_query($con, $query);
            }
            if($result === true){
                echo "<script>";
                echo "alert(' สำเร็จ !');";
                echo "window.location.replace('login.php');";
                echo "</script>";
            }
        }else{              

    ?>
    <br>
    <div class="container">
        <div class="row">

            <div class="col-3">
            </div>

            <div align="center" class="col-6">
                <form name="registration" action="" method="post">
                    <div class="form-group">
                        <b>
                            <h2>สมัครสมาชิก</h2>
                        </b>
                        <label for="" class="register-box">ชื่อ</label>
                        <input type="text" class="form-control" name="name" placeholder="ชื่อ">

                        <label for="" class="register-box">นามสกุล</label>
                        <input type="text" class="form-control" name="lastname" placeholder="นามสกุล">

                        <label for="" class="register-box">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้งาน">

                        <label for="" class="register-box">รหัสผ่าน</label>
                        <input type="text" class="form-control" name="password" placeholder="รหัสผ่าน">

                        <label for="" class="register-box">รหัสผ่านอีกครั้ง</label>
                        <input type="text" class="form-control" name="repass" placeholder="รหัสผ่านอีกครั้ง">

                        <label for="" class="register-box">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" name="tel" placeholder="เบอร์โทร">

                        <label for="" class="register-box">อีเมล</label>
                        <input type="text" class="form-control" name="email" placeholder="อีเมล">
                        <br>
                    </div>
                    <input class="btn btn-outline-danger btn-lg btn-block" type="submit" name="submit"
                        value="สมัครสมาชิก">
                </form>
                <br>
                <p>มีชื่อผู้ใช้งานอยู่แล้ว <a href="login.php">เข้าสู่ระบบ</a></p>
            </div>

            <div class="col-3">
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php } ?>
</body>
<?php include "include/footer.php" ?>

</html>