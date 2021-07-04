<?php


//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
?>
<div class="container">
  <div class="row">
      <form  name="addproduct" action="sell_promotion_form_add_db.php" method="POST" enctype="multipart/form-data"  class="form-horizontal">
        <div class="form-group">
          <div class="col-sm-9">
            <p> ชื่อโปรโมชั่น</p>
            <input type="text"  name="pro_name" class="form-control" required placeholder="ชื่อโปรโมชั่น" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <p> รายละเอียดโปรโมชั่น </p>
             <textarea  name="pro_detail" rows="5" cols="60"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <p> ส่วนลด </p>
            <input type="text"  name="pro_discount" class="form-control" required placeholder="ส่วนลด" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <p> วันที่เริ่มต้น </p>
            <input type="date"  name="pro_start" class="form-control" required placeholder="วันที่เริ่มต้น" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <p> วันที่เริ่มต้น </p>
            <input type="date"  name="pro_end" class="form-control" required placeholder="วันที่สิ้นสุด" />
          </div>
        </div>

   
  
        <div class="form-group">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-success" name="btnadd"> บันทึก </button>
            
          </div>
        </div>
      </form>
    </div>
  </div>