<?php
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
    $('#submit').click(function() {
        var id = document.getElementById('id').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var name = document.getElementById('name').value;
        var lastname = document.getElementById('lastname').value;
        var tel = document.getElementById('tel').value;
        var email = document.getElementById('email').value;
        var addr = document.getElementById('addr').value;

        $.ajax({
            method: 'POST',
            url: 'member_form_edit_db.php',
            data: {
                id: id,
                username: username,
                password: password,
                name: name,
                lastname: lastname,
                tel: tel,
                addr: addr,
                email: email
            },
            cache: true,
            success: function(response) {
                $('#data').html(response);
            }
        });
    });
});
</script>
<input type="hidden" name="id" id="id" value="<?php echo $ID; ?>">
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ชื่อผู้ใช้งาน :</label>
        <input name="m_username" id="username" type="text" required class="form-control col-sm-8"
            value="<?=$username;?>" placeholder="ชื่อผู้ใช้งาน" pattern="^[a-zA-Z0-9]+$"
            title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">รหัสผ่าน :</label>
        <input name="m_password" id="password" type="m_password" required class="form-control col-sm-8"
            value="<?=$password;?>" placeholder="รหัสผ่าน" pattern="^[a-zA-Z0-9]+$" minlength="2" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ชื่อ :</label>
        <input name="m_name" id="name" type="text" required class="form-control col-sm-8" value="<?=$name;?>"
            placeholder="ชื่อ " />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">นามสกุล :</label>
        <input name="m_lastname" id="lastname" type="text" required class="form-control col-sm-8"
            value="<?=$lastname;?>" placeholder="นามสกุล " />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">อีเมล :</label>
        <input name="m_email" id="email" type="email" class="form-control col-sm-8" value="<?=$email;?>"
            placeholder=" อีเมล์ name@hotmail.com" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">เบอร์โทรศัพม์ :</label>
        <input name="m_tel" id="tel" type="text" class="form-control col-sm-8" value="<?=$tel;?>" />

    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ที่อยู่ :</label>
        <textarea name="m_addr" id="addr" class="form-control col-sm-8" value="<?=$addr;?>"
            required><?php echo $addr ?></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-5" align="right">
        <button type="submit" class="btn btn-success" id="submit"><span class="glyphicon glyphicon-ok"></span> บันทึก
        </button>
    </div>
</div>