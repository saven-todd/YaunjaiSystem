<?php
//1. เชื่อมต่อ database:
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$p_id = $_GET["ID"];
//2. query ข้อมูลจากตาราง:
$sql = "SELECT * FROM tbl_promotion WHere Pro_ID = $p_id ORDER BY Pro_ID asc";
$result2 = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result2);
extract($row);

?>
<div class="container">
  <div class="row">
      <form  name="addproduct" action="sell_promotion_form_edit_db.php" method="POST" enctype="multipart/form-data"  class="form-horizontal">
        <div class="form-group">
          <div class="col-sm-9">
            <p> ชื่อโปรโมชั่น</p>
            <input type="text"  name="pro_name" class="form-control" required placeholder="ชื่อโปรโมชั่น" / value="<?php echo $Pro_Name; ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <p> รายละเอียดโปรโมชั่น </p>
             <textarea  name="Pro_Des" rows="5" cols="60"><?php echo $Pro_Des; ?>
             </textarea>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-12">
            <p> ส่วนลด</p>
            <input type="text"  name="Discount" class="form-control" required placeholder="ส่วนลด" value="<?php echo $Discount; ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <p> วันที่เริ่มต้น </p>
            <input type="date"  name="pro_start" class="form-control" required placeholder="วันที่เริ่มต้น" value="<?php echo $StartDate; ?>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <p> วันที่สิ้นสุด </p>
            <input type="date"  name="pro_end" class="form-control" required placeholder="วันที่สิ้นสุด" value="<?php echo $EndDate; ?>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
             <input type="hidden" name="p_id" value="<?php echo $p_id; ?>" />
             <input type="hidden" name="img2" value="<?php echo $p_img; ?>" />
            <button type="submit" class="btn btn-success" name="btnadd"> บันทึก </button>
            
          </div>
        </div>
      </form>
    </div>
  </div>