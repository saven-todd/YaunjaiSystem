<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        include_once "include/headerauth.php";
        include('db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
        $pid = $_GET['p_id'];
        $query_product = "SELECT * FROM tbl_product as p
        INNER JOIN tbl_type as t ON p.type_id = t.type_id where p.p_id = $pid ";
        $result_pro = mysqli_query($con,$query_product) or die ("Error in query: $query_product " . mysqli_error($con));
        // echo($query_product);
        // exit();    
    ?>
</head>

<body>
    <br>
    <br>
    <br>
    <!--Start Top Product-->

    <div class="row">
        <div class="col-md-3">
        </div>
        <?php foreach($result_pro as $row_pro){ ?>
        <div class="col-md-4">
            <div class="card-body">
                <h1 class="card-tittle"><?php echo $row_pro['p_name']; ?></h1>
                <p class="card-text"><?php echo $row_pro['p_detail']; ?></p>
                <p>ราคา ฿<?php echo number_format($row_pro['p_price'],2); ?></p>
            </div>
            <?php
                // if($action == 'exists'){
                //     echo "<div class=\"alert alert-warning\">เพิ่มจำนวนสินค้าแล้ว</div>";
                // }
                // if($action == 'add'){
                //     echo "<div class=\"alert alert-success\">เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว</div>";
                // }
                // if($action == 'order'){
                //     echo "<div class=\"alert alert-success\">สั่งซื้อสินค้าเรียบร้อยแล้ว</div>";
                // }
                // if($action == 'orderfail'){
                //     echo "<div class=\"alert alert-warning\">สั่งซื้อสินค้าไม่สำเร็จ มีข้อผิดพลาดเกิดขึ้นกรุณาลองใหม่อีกครั้ง</div>";
                // }
                ?>

            <a href="updatecart.php?itemId=<?php echo $row_pro['p_id']; ?>"
                class="btn btn-danger btn-lg btn-block">เพิ่มสินค้าลงตะกร้า</a>
            <a href="index.php" class="btn btn-secondary btn-lg btn-block">ย้อนกลับ</a>
        </div>

        <div class="col-md-2">
            <img class="card-img-top product-img" src="Backend/p_img/<?php echo $row_pro['p_img']; ?>" width="100%" 
                alt="Card image cap">
            <br>
        </div>
        <div class="col-md-3">
        </div>
    </div>

    <?php } ?>
    <!--End Top Product-->
</body>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include "include/footer.php" ?>

</html>
</div>