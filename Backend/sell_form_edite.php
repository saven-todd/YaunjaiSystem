<?php
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$ID = $_REQUEST["ID"];
//2. query ข้อมูลจากตาราง:
$sql = "SELECT * FROM user WHERE id='$ID' ";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($edit));
$row = mysqli_fetch_array($result);
extract($row);
?>
<?php 
include("h.php");
?>
<form  name="sell" action="sell_form_edit_db.php" method="POST" id="sell" class="form-horizontal" >
  <img src="../IMG/profile/img_avatar.png" alt="" class="profile-avatar">
  <!-- <input type="file" name="picture" id="picture"> -->
         <input type="hidden" name="id" value="<?php echo $ID; ?>">
          <div class="form-group">
            <div class="col-sm-10" align="left">
            <label for="" class="obj-text">ชื่อผู้ใช้งาน :</label>
              <input  name="a_username" type="text" required class="form-control" id="a_username" value="<?=$username;?>" placeholder="ชื่อผู้ใช้งาน" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2"  />
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-10" align="left">
            <label for="" class="obj-text">รหัสผ่าน :</label>
              <input  name="a_password" type="text" required class="form-control" id="a_password" value="<?=$password; ?>" placeholder="รหัสผ่าน" pattern="^[a-zA-Z0-9]+$" minlength="2" />
            </div>
          </div>
          <div class="form-group">
   
            <div class="col-sm-10" align="left">
            <label for="" class="obj-text">ชื่อ :</label>
              <input  name="a_name" type="text" required class="form-control" id="a_name" value="<?=$name;?>" placeholder="ชื่อ" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-10" align="left">
            <label for="" class="obj-text">นามสกุล :</label>
                <input  name="a_lastname" type="text" required class="form-control" id="a_lastname" value="<?=$lastname; ?>" placeholder="นามสกุล" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10" align="left">
            <label for="" class="obj-text">เบอร์โทรศัพท์ :</label>
                <input  name="a_tel" type="text" required class="form-control" id="a_tel" value="<?=$tel; ?>" placeholder="เบอร์โทรศัพท์" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10" align="left">
            <label for="" class="obj-text">อีเมล :</label>
                <input  name="a_email" type="text" required class="form-control" id="a_email" value="<?=$email; ?>" placeholder="อีเมล" />
            </div>
        </div>
          
          <div class="form-group">
            <div class="col-sm-3"> </div>
            <div class="col-sm-6" align="right">
              <button type="submit" class="btn btn-success" id="btn"> <span class="glyphicon glyphicon-saved"></span> บันทึก  </button>      
            </div> 
          </div>
        </form>
        <?php
        