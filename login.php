<?php 
session_start();

            include_once "db.php";

        if(isset($_POST['username'])){
                  $username = $_POST['username'];
                  $password = $_POST['password'];

                  $sql="SELECT * FROM user WHERE username='$username' AND password='$password' ;";
                  $result = mysqli_query($con,$sql);				
                  if(mysqli_num_rows($result)==1){
                    $row = mysqli_fetch_array($result);         
                    $_SESSION["ID"] = $row['ID'];
                    $_SESSION["name"] = $row["name"];
                    $_SESSION["pic"] = $row["Picture"];
                    $_SESSION["status"] = $row["status"];
                    $_SESSION['fbid'] = $row['fb_id']; 
                    $_SESSION['email'] = $row['email']; 
                    $_SESSION['remainPoints'] = $row['RemainingPoints']; 

                    if($_SESSION["status"] == "1"){ 
                        Header("Location: Backend/admin.php");
                    } else if($_SESSION["status"] == "3"){
                        Header("Location: Backend/sell.php");
                    } else {                        
                        Header("Location: shopping.php");
                    }
                  }else{
                    echo "<script>";
                        echo "alert(\" user หรือ  password ไม่ถูกต้อง\");"; 
                        echo "window.history.back()";
                    echo "</script>"; 
                  }
        }

        if(isset($_SESSION['ID'])){    
            $ID = $_SESSION['ID'] ? : $_SESSION['fbid'];
            $name = $_SESSION['name'];
            $profile_pic = $_SESSION['pic'];
            $level = $_SESSION['status'];
            $fbid = $_SESSION['fbid'];
            
            if($_SESSION["status"] == "1"){ 
                Header("Location: Backend/admin.php");
            } else if($_SESSION["status"] == "3"){
                Header("Location: Backend/sell.php");
            } else {                        
                Header("Location: shopping.php");
              }
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "include/headerauth.php"; ?>
    <!-- <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v9.0&appId=132676765347554&autoLogAppEvents=1"
        nonce="RKsJiqW4"></script> -->
</head>

<body>
    <!-- JAVA Script -->
    <script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: '435016447776871',
            autoLogAppEvents: true,
            xfbml: true,
            version: 'v10.0'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    function checkLoginState() { // Called when a person is finished with the Login Button.        
        FB.login(function(response) {
            if (response.status === 'connected') {
                // Logged into your webpage and Facebook.
                testAPI();
            } else {
                // The person is not logged into your webpage or we are unable to tell. 
                alert(" user หรือ  password ไม่ถูกต้อง");
            }
        });
    }

    function testAPI() { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
            // console.log('LOGIN Successful ID: ' + JSON.stringify(response));
            // console.log('Successful ID: ' + response.id);
            // console.log('Successful login for: ' + response.name);
            $.ajax({
                type: "POST",
                url: "login_fb.php",
                data: {
                    id: '',
                    name: response.name,
                    fbid: response.id,
                    status: 2
                },
                success: function() {
                    location.href = "shopping.php";
                },
                fail: function() {
                    location.href = "login.php";
                }
            });
        });
    }
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js"></script>

    <?php
        if(!isset($_SESSION['status'])){
    ?>
    <br>
    <div class="container">
        <div class="row">

            <div class="col-3">
            </div>
            <div align="center" class="col-6">
                <form action="" method="post" name="login">
                    <div class="form-group">
                        <b>
                            <h2>เข้าสู่ระบบ</h2>
                        </b>
                        <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้งาน">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน">
                    </div>
                    <input class="btn btn-danger btn-lg btn-block" type="submit" name="submit" value="เข้าสู่ระบบ">
                </form>

                <br>
                <p>หรือ</p>
                <!-- <button type="submit" id="fb-login" class="btn btn-primary btn-lg btn-block">เข้าสู่ระบบด้วย
                    FACEBOOK</button> -->
                <div id="fb-root"></div>
                <fb:login-button scope="public_profile,email" onlogin="checkLoginState();" class="fb-login-button"
                    data-width="" data-size="large" data-button-type="continue_with" data-layout="rounded"
                    data-auto-logout-link="false" data-use-continue-as="false">
                </fb:login-button>
                <hr>
                <a href="register.php">
                    <button type="submit" class="btn btn-outline-secondary btn-lg btn-block">สมัครสมาชิก</button>
                </a>
            </div>
        </div>
    </div>
    <?php } ?>
</body>
<?php include_once "include/footer.php"; ?>

</html>