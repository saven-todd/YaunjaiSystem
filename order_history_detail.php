<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งซื้อ</title>
    <?php include "include/headerauth.php" ?>
</head>

<body>
    <?php
        $order_id = $_GET['OrderID'];
        $sql = "SELECT * FROM v_receipt WHERE MemberID = $ID AND OrderID = $order_id ;";        
        $_stmt = mysqli_query($con,$sql);
        $_result =  mysqli_fetch_assoc($_stmt);

        switch ($_result['accept_FK']) {
        case 0:
            $accept_FK = "<span style='color: red;'>ยกเลิก</span>";
            break;
        case 1:
            $accept_FK = "<span style='color: purple;'>ยังไม่ตรวจสอบ</span>";
            break;
        case 2:
            $accept_FK = "<span style='color: blue;'>รอดำเนินการ</span>";
            break;
        case 3:
            $accept_FK = "<span style='color: green;'>สำเร็จ</span>";
            break;
            default:
              echo "ขัดข้องโปรดแจ้งผู้ดูแลระบบ!";
          }

          switch ($_result['PayStatus_W']) {
              case 0:
                  $PayStatus_W = "<span style='color: red;'>ยังไม่แจ้งการชำระเงิน                   
                                <a href='payment_notification.php?OrderID=$order_id' type='submit'
                                class='btn btn-primary btn-lg'
                                style='transform: scale(.5); margin:-15px auto;'>ดูคำสั่งซื้อ</a>
                                </span>";
                  break;
              case 1:
                  $PayStatus_W = "<span style='color: blue;'>รอตรวจสอบการชำระเงิน</span>";
                  break;
              case 2:
                  $PayStatus_W = "<span style='color: green;'>ตรวจสอบการชำระเงินเสร็จสิ้น</span>";
                  break;
              default:
              echo "ขัดข้องโปรดแจ้งผู้ดูแลระบบ!";
          }          
        
    ?>
    <div class="container" #>
        <div class="col-sm-10" align="left">
            <label for="exampleInputEmail1" class="obj-text col-sm-3">ชื่อ-นามสกุล </label>
            <label for="exampleInputEmail1" class="obj-text col-sm-7"> : <?=$_result['name'] ?? $_result['name']='' ?>
                <?=$_result['lastname'] ?? $_result['lastname']='' ?></label>
        </div>
        <div class="col-sm-10" align="left">
            <label for="exampleInputAddress" class="obj-text col-sm-3">ที่อยู่ </label>
            <label for="exampleInputEmail1" class="obj-text col-sm-7"> :
                <?=$_result['addr'] ?? $_result['addr']='' ?></label>
        </div>
        <div class="col-sm-10" align="left">
            <label for="exampleInputPhone" class="obj-text col-sm-3">เบอร์โทรศัพท์ </label>
            <label for="exampleInputEmail1" class="obj-text col-sm-7"> :
                <?=$_result['tel'] ?? $_result['tel']='' ?></label>
        </div>
        <div class="col-sm-10" align="left">
            <label for="exampleInputPhone" class="obj-text col-sm-3">วัน/เวลา </label>
            <label for="exampleInputEmail1" class="obj-text col-sm-7"> :
                <?=$_result['OrderDate'] ?? $_result['OrderDate']='' ?></label>
        </div>
        <div class="col-sm-10" align="left">
            <label for="exampleInputPhone" class="obj-text col-sm-3">สถานะรายการ </label>
            <label for="exampleInputEmail1" class="obj-text col-sm-7"> : <?=$accept_FK?></label>
        </div>
        <div class="col-sm-10" align="left">
            <label for="exampleInputPhone" class="obj-text col-sm-3">การชำระเงิน </label>
            <label for="exampleInputEmail1" class="obj-text col-sm-7"> : <?=$PayStatus_W?></label>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>รายละเอียด</th>
                    <th>จำนวน</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>จำนวนเงินรวม</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    $total_price = 0;
                    $num = 0;
                    foreach($_stmt AS $key => $value){
                        $total_price = $total_price + ($value['Price'] * $value['Number']);                        
                ?>
                <tr style="align-items: center;">
                    <td><?php echo $value['ProductID']; ?></td>
                    <td><?php echo $value['p_name']; ?></td>
                    <td><?php echo $value['p_detail']; ?></td>
                    <td><?php echo $value['Number']; ?></td>
                    <td><?php echo number_format($value['Price'], 2); ?></td>
                    <td><?php echo number_format(($value['Price'] * $value['Number']), 2);?></td>
                </tr>
                <?php  
                    }
                    mysqli_free_result($_stmt);
                    
                if($value['PointsNumber'] > 0 ){
                    ?>
    
                    <tr style="align-items: center;">
                        <td colspan="4"> ใช้แต้มส่วนลด </td>
                        <td><?= $value['PointsNumber'] ?></td>
                        <td><?php echo number_format($value['PointsNumber'] * 10, 2);?></td>
                    </tr>
    
                    <?php
                    
                    }
                ?>
                <tr>
                    <td colspan="8" style="text-align: right;">
                        <h5 class="total">จำนวนเงินรวมทั้งหมด <?=number_format($total_price - ($value['PointsNumber'] * 10), 2)?> บาท</h5>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>




</body>

<?php include "include/footer.php" ?>

</html>