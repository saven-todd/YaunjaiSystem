<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งซื้อ</title>
    <?php include "include/headerauth.php" ?>
    
    <style>
    .table-filter-container {
        text-align: right;
    }
    </style>
    <script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            dom: 'lr<"table-filter-container">tip',
            order: [
                [0, "desc"]
            ],
            initComplete: function(settings) {
                var api = new $.fn.dataTable.Api(settings);
                $('.table-filter-container', api.table().container()).append(
                    $('#table-filter').detach().show()
                );

                $('#table-filter select').on('change', function() {
                    table.search(this.value).draw();
                });
            }
        });
    });
    </script>
</head>

<body>
    <?php
        $sql = "SELECT * FROM vreceipt WHERE MemberID = $ID ;";        
        $_stmt = mysqli_query($con,$sql);
        $_result =  mysqli_fetch_assoc($_stmt);
        
    ?>
    <div class="container">

        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="info.php" class="list-group-item list-group-item-action">ข้อมูลส่วนตัว</a>
                    <a href="past_list.php" class="list-group-item list-group-item-action">รายการสั่งซื้อที่ผ่านมา</a>
                    <a href="#" class="list-group-item list-group-item-action">ดูเมนูโปรด</a>
                    <hr>
                    <a href="logout.php" class="list-group-item list-group-item-action "
                        onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?')">ออกจากระบบ</a>
                </div>
            </div>


            <p id="table-filter" style="display:none">
                ค้นหา :
                <select>
                    <option value="">ทั้งหมด</option>
                    <option>ยกเลิก</option>
                    <option>ยังไม่ตรวจสอบ</option>
                    <option>รอดำเนินการ</option>
                    <option>สำเร็จ</option>
                </select>
            </p>
            <table class="table table-striped table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>เลขที่สั่งซื้อ</th>
                        <th>วันที่สั่งซื้อ</th>
                        <th>ราคารวม</th>
                        <th>สถานะคำสั่ง</th>
                        <th>การชำระเงิน</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                    $num = 0;
                    foreach($_stmt AS $key => $value){
                        $total_price = $total_price + ($value['Price'] * $value['Number']); 

                        switch ($value['accept_FK']) {
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

                        switch ($value['PayStatus_W']) {
                            case 0:
                                $PayStatus_W = "<span style='color: red;'>ยังไม่แจ้งการชำระเงิน</span>";
                                break;
                            case 1:
                                $PayStatus_W = "<span style='color: blue;'>รอตรวจสอบการชำระเงิน</span>";
                                break;
                            case 2:
                                $PayStatus_W = "<span style='color: green;'>ชำระเงินเสร็จสิ้น</span>";
                                break;
                            default:
                            echo "ขัดข้องโปรดแจ้งผู้ดูแลระบบ!";
                        }                       
                ?>
                    <tr style="align-items: center;">
                        <td><?php echo $value['OrderID']; ?></td>
                        <td><?php echo $value['OrderDate']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($value['sum'],2); ?></td>
                        <td><?php echo $accept_FK; ?></td>
                        <td><?php echo $PayStatus_W; ?></td>
                        <td>
                            <a href="order_history_detail.php?OrderID=<?=$value['OrderID']?>" id="submit" type="submit"
                                class="btn btn-primary btn-lg"
                                style="transform: scale(.5); margin:-15px auto;">ดูคำสั่งซื้อ</a>
                        </td>
                    </tr>
                    <?php  
                    }
                    mysqli_free_result($_stmt);
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<?php include "include/footer.php" ?>

</html>