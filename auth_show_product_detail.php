<?php 
session_start();
include('db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
// $pid = $_GET['p_id'];
// $query_product = "SELECT * FROM tbl_product as p
// INNER JOIN tbl_type as t ON p.type_id = t.type_id where p.p_id = $pid ;";
// $result_pro = mysqli_query($con,$query_product) or die ("Error in query: $query_product " . mysqli_error($con));
// echo($query_product);
// exit()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    include_once "include/headerauth.php" ;
    ?>
</head>

<body>
    <br>
    <br>
    <br>
    <!--Start Top Product-->

    <!-- Main component for a primary marketing message or call to action -->
    <div class="container">
        <?php
            if ($action == 'removed')
            {
                echo "<div class=\"alert alert-warning\">ลบสินค้าเรียบร้อยแล้ว</div>";
            }

            if ($meCount == 0)
            {
                echo "<div class=\"alert alert-warning\">ไม่มีสินค้าอยู่ในตะกร้า</div>";
            } else
            {
                ?>
        <form action="updatecart.php" method="post" name="fromupdate">


            <table class="table margin=30">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">รหัสสินค้า</th>
                        <th scope="col">ชื่อสินค้า</th>
                        <th scope="col">รายละเอียด</th>
                        <th scope="col">จำนวน</th>
                        <th scope="col">ราคาต่อหน่วย(บาท)</th>
                        <th scope="col">จำนวนเงิน</th>
                        <th scope="col">ดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // print_r($result_pro);

                    $total_price = 0;
                    $num = 0;
                    $runnum=1;
                    while ($data = mysqli_fetch_assoc($meQuery)) {
                        $key = array_search($data['p_id'], $_SESSION['cart']);
                        $total_price = $total_price + ($data['p_price'] * $_SESSION['qty'][$key]);
                ?>
                    <tr scope="row">
                        <td>
                            <?=$runnum; ?>
                        </td>
                        <td width="100px"><img src="Backend/p_img/<?=$data['p_img'];?>" alt="..." class="img-thumbnail"
                                width="100%">
                        </td>
                        <td><?=$data['p_id']; ?></td>
                        <td>
                            <?=$data['p_name']; ?>
                        </td>
                        <td>
                            <?=$data['p_detail']; ?>
                        </td>
                        <td>
                            <input type="text" name="qty[<?=$num; ?>]" value="<?=$_SESSION['qty'][$key]; ?>"
                                class="form-control" style="width: 60px;text-align: center;">
                            <input type="hidden" name="arr_key_<?=$num; ?>" value="<?=$key; ?>">
                        </td>
                        <td>
                            <?=number_format($data['p_price'],2); ?>
                        </td>
                        <td>
                            <?=number_format(($data['p_price'] * $_SESSION['qty'][$key]),2); ?>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-lg" href="removecart.php?itemId=<?=$data['p_id']; ?>"
                                role="button">
                                <span class="glyphicon glyphicon-trash"></span>
                                ลบทิ้ง
                            </a>
                        </td>
                    </tr>
                    <?php
                    $num++;
                    $runnum++;
                    }
                ?>
                    <tr>
                        <td colspan="9" style="text-align: left; ">
                            <h4 style="text-align: right;"> จำนวนเงินรวมทั้งหมด
                                <?=number_format($total_price,2); ?> บาท</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: right;">
							<a href="shopping.php" type="button" class="btn btn-primary btn-lg">กลับไปเลือกสินค้าเพิ่ม</a>
                            <button type="submit" class="btn btn-info btn-lg">คำนวณราคาสินค้าใหม่</button>
                            <a href="order.php" type="button" class="btn btn-primary btn-lg">สังซื้อสินค้า</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    <?php } ?>


    <!--End Top Product-->
</body>
<?php include "include/footer.php" ?>

</html>