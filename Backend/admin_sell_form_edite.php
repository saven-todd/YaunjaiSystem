<?php session_start();
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$ID = $_REQUEST["ID"];
//2. query ข้อมูลจากตาราง:
$sql = "SELECT * FROM user WHERE id='$ID' ";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
$row = mysqli_fetch_array($result);
extract($row);
?>
<script>
$(document).ready(function() {
    ProfileImage();
    $('#submit').click(function() {
        var id = document.getElementById('id').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var name = document.getElementById('name').value;
        var lastname = document.getElementById('lastname').value;
        var tel = document.getElementById('tel').value;
        var email = document.getElementById('email').value;
        var p_img2 = document.getElementById('p_img2').value;

        var p_img = $('#fileUploadForm')[0];
        var form_data = new FormData(p_img);
        form_data.append('p_img', p_img);

        $.ajax({
            method: 'POST',
            url: 'admin_sell_form_add_db_img.php?id=' + id + '&p_img2=' + p_img2,
            enctype: 'multipart/form-data',
            data: p_img = form_data,
            processData: false,
            contentType: false,
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });

        $.ajax({
            method: 'POST',
            url: 'admin_sell_form_edit_db.php',
            data: {
                ID:<?=$ID?>,
                id: id,
                username: username,
                password: password,
                name: name,
                lastname: lastname,
                tel: tel,
                email: email
            },
            cache: true,
            success: function(response) {
            }
        });
    });
});
</script>

<input type="hidden" name="id" id="id" value="<?php echo $ID; ?>">

<div class="row" style="justify-content: center; margin:1em 1em 1em 1em;">
    <div class="small-12 medium-2 large-2 columns">
        <div class="circle">
            <!-- User Profile Image -->
            <img class="profile-pic-upload" src="../IMG/profile/<?=$Picture?>">

            <!-- Default Image -->

            <input type="hidden" id="p_img2" name="p_img2" value="<?=$Picture;?>" />
            <!-- <i class="fa fa-user fa-5x"></i> -->
        </div>
        <div class="p-image">
            <i class="fa fa-camera upload-button"></i>
            <form method="POST" enctype="multipart/form-data" id="fileUploadForm">
                <input class="file-upload" type="file" name="p_img" id="p_img" />
            </form>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ชื่อผู้ใช้งาน :</label>
        <input name="a_username" id="username" type="text" required class="form-control col-sm-8"id="a_username"
            value="<?=$username;?>" placeholder="ชื่อผู้ใช้งาน" pattern="^[a-zA-Z0-9]+$"
            title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2" />
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">รหัสผ่าน :</label>
        <input name="a_password" id="password" type="text" required class="form-control col-sm-8"id="a_password"
            value="<?=$password; ?>" placeholder="รหัสผ่าน" pattern="^[a-zA-Z0-9]+$" minlength="2" />
    </div>
</div>
<div class="form-group">

    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ชื่อ :</label>
        <input name="a_name" id="name" type="text" required class="form-control col-sm-8"id="a_name" value="<?=$name;?>"
            placeholder="ชื่อ" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ชื่อนามสกุล :</label>
        <input name="a_lastname" id="lastname" type="text" required class="form-control col-sm-8"id="a_lastname"
            value="<?=$lastname; ?>" placeholder="นามสกุล" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">เบอร์โทรศัพท์ :</label>
        <input name="a_tel" id="tel" type="text" required class="form-control col-sm-8"id="a_tel" value="<?=$tel; ?>"
            placeholder="เบอร์โทรศัพท์" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">อีเมล :</label>
        <input name="a_email" id="email" type="text" required class="form-control col-sm-8"id="a_email" value="<?=$email; ?>"
            placeholder="อีเมล" />
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3"> </div>
    <div class="col-sm-6" align="right">
        <button type="submit" class="btn btn-success" id="submit"> <span class="glyphicon glyphicon-saved"></span>
            บันทึก </button>
    </div>
</div>