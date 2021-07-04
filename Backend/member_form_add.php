<script>
$(document).ready(function() {
    ProfileImage();
    $('#submit').click(function() {
        // var id = document.getElementById('id').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var name = document.getElementById('name').value;
        var lastname = document.getElementById('lastname').value;
        var tel = document.getElementById('tel').value;
        var email = document.getElementById('email').value;
        var addr = document.getElementById('addr').value;

        var p_img = $('#fileUploadForm')[0];
        var form_data = new FormData(p_img);
        form_data.append('p_img', p_img);

        function upload() {
            $.ajax({
                method: 'POST',
                url: 'member_form_add_db_img.php?username=' + username,
                enctype: 'multipart/form-data',
                data: p_img = form_data,
                processData: false,
                contentType: false,
                cache: true,
                success: function(response) {
                    $('#data').html(response);
                }
            });
        }
        $.ajax({
            method: 'POST',
            url: 'member_form_add_db.php',
            data: {
                username: username,
                password: password,
                name: name,
                lastname: lastname,
                tel: tel,
                email: email,
                addr: addr
            },
            cache: true,
            success: function(response) {
                upload()
            }
        });
    });
});
</script>

<div class="row" style="justify-content: center; margin:1em 1em 1em 1em;">
    <div class="small-12 medium-2 large-2 columns">
        <div class="circle">
            <!-- User Profile Image -->
            <img class="profile-pic-upload"
                src="http://cdn.cutestpaw.com/wp-content/uploads/2012/07/l-Wittle-puppy-yawning.jpg">

            <!-- Default Image -->
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
        <input name="username" type="text" required class="form-control col-sm-8" id="username"
            placeholder="ชื่อผู้ใช้งาน" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">รหัสผ่าน :</label>
        <input name="password" type="password" required class="form-control col-sm-8" id="password"
            placeholder="รหัสผ่าน" pattern="^[a-zA-Z0-9]+$" minlength="2" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ชื่อ :</label>
        <input name="name" type="text" required class="form-control col-sm-8" id="name" placeholder="ชื่อ " />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">นามสกุล :</label>
        <input name="lastname" type="text" required class="form-control col-sm-8" id="lastname"
            placeholder="นามสกุล " />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">อีเมล :</label>
        <input name="email" type="email" class="form-control col-sm-8" id="email"
            placeholder=" อีเมล์ name@hotmail.com" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">เบอร์โทรศัพท์ :</label>
        <input name="tel" type="text" class="form-control col-sm-8" id="tel" placeholder="เบอร์โทร ตัวเลขเท่านั้น" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10" align="left">
        <label for="" class="obj-text col-sm-4">ที่อยู่ :</label>
        <textarea name="addr" class="form-control col-sm-8" id="addr" required></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-5" align="right">
        <button type="submit" class="btn btn-success" id="submit"><span class="glyphicon glyphicon-ok"></span>
            สมัครสมาชิก
        </button>
    </div>
</div>