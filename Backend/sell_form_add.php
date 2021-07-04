<?php 
include("h.php");
?>
<form  name="sell" action="sell_form_db.php" method="POST" id="sell" class="form-horizontal">
          <div class="form-group">
          
            <div class="col-sm-10" align="left">
              <input  name="a_username" type="text" required class="form-control" id="a_username" placeholder="ชื่อผู้ใช้งาน" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2"  />
            </div>
          </div>
          
          <div class="form-group">
       
            <div class="col-sm-10" align="left">
              <input  name="a_password" type="password" required class="form-control" id="a_password" placeholder="รหัสผ่าน" pattern="^[a-zA-Z0-9]+$" minlength="2" />
            </div>
          </div>
          <div class="form-group">
   
            <div class="col-sm-10" align="left">
              <input  name="a_name" type="text" required class="form-control" id="a_name" placeholder="ชื่อ" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-10" align="left">
                <input  name="a_lastname" type="text" required class="form-control" id="a_lastname" placeholder="นามสกุล" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10" align="left">
                <input  name="a_tel" type="text" required class="form-control" id="a_tel" placeholder="เบอร์โทรศัพท์" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10" align="left">
                <input  name="a_email" type="text" required class="form-control" id="a_email" placeholder="อีเมล" />
            </div>
        </div>
          
          <div class="form-group">
            <div class="col-sm-3"> </div>
            <div class="col-sm-6" align="right">
              <button type="submit" class="btn btn-success" id="btn"> <span class="glyphicon glyphicon-saved"></span> +เพิ่ม  </button>      
            </div> 
          </div>
        </form>