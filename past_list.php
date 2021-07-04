<?php
    session_start();
    include_once 'Backend/function.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <style>
    .table-filter-container {
        text-align: right;
    }
    </style>
    <link rel="stylesheet" href="include/style.css">
    <?php include_once "include/headerauth.php" ;
    require('db.php');
    include('auth.php');
    error_reporting( error_reporting() & ~E_NOTICE );
    //1. เชื่อมต่อ database:
    //2. query ข้อมูลจากตาราง tb_admin:
    
    $sql = "SELECT * FROM noti_ul WHERE MemberID = '$ID' OR MemberID = '$fbid' ;";    
    $sql_user = "SELECT * FROM user WHERE ID = '$ID' OR fb_id = '$fbid' ;";

    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));    
    $result_user = mysqli_query($con, $sql_user) or die ("Error in query: $sql " . mysqli_error($con));

    $num = mysqli_num_rows($result);
    $data = mysqli_fetch_assoc($result);
    $data_user = mysqli_fetch_assoc($result_user);

    $num_row = mysqli_num_rows($result);
?>
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
    if($action == 'succsess'){
        echo "<div class=\"alert alert-success\">สั่งซื้อสินค้าเรียบร้อยแล้ว</div>";
    }elseif($action == 'orderfail'){
        echo "<div class=\"alert alert-warning\">สั่งซื้อสินค้าไม่สำเร็จ มีข้อผิดพลาดเกิดขึ้นกรุณาลองใหม่อีกครั้ง</div>";
    }
    ?>
    <p></p>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="info.php" class="list-group-item list-group-item-action">ข้อมูลส่วนตัว</a>
                    <a href="past_list.php"
                        class="list-group-item list-group-item-action active">รายการสั่งซื้อที่ผ่านมา</a>
                    <a href="#" class="list-group-item list-group-item-action">ดูเมนูโปรด</a>

                    <hr>
                    <a href="logout.php" class="list-group-item list-group-item-action "
                        onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?')">ออกจากระบบ</a>
                </div>
            </div>
            <div class="col-9">
                <h2> รายการสั่งซื้อที่ผ่านมา </h2>


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

                <table border="2" class="display table table-bordered" id="dataTable" align="center">
                    <thead>
                        <tr class="info">
                            <td style="width:10%">วันที่</td>
                            <td style="width:55%">รายละเอียด</td>
                            <td>ราคา</td>
                            <td>สถานะ</td>
                            <td>ตรวจสอบ</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($num > 0){ do { ?>

                        <tr>
                            <td><?=$data['OrderDate']; ?></td>
                            <td><?=$data['p_name'] ?></td>
                            <td><?=number_format($data['total'],2) ?></td>
                            <td><?=Switchaccept_FK($data['accept_FK']); ?></td>
                            <td>
                                <a href="order_history_detail.php?OrderID=<?=$data['OrderID']?>" id="submit"
                                    type="submit" class="btn btn-primary btn-lg"
                                    style="transform: scale(.5); margin:-15px auto;">ดูคำสั่งซื้อ</a>
                            </td>
                        </tr>

                        <?php } while ($data =  mysqli_fetch_assoc($result)); }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p></p>
</body>
<?php include "include/footer.php" ?>

</html>