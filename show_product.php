<?php

$query_product = "SELECT * FROM tbl_product as p
INNER JOIN tbl_type as t
ON p.type_id = t.type_id
ORDER BY p.p_id ASC";
$result_pro = mysqli_query($con,$query_product) or die ("Error in query: $query_product " . mysqli_error($con));
// echo($query_product);
// exit()
?>


<div class="row row-product">
    <?php foreach($result_pro as $row_pro){ ?>
    <div class="card-product">
        <div class="imgBx">
            <img src="Backend/p_img/<?php echo $row_pro['p_img']; ?>" alt="ญวนใจขนมปัง YaunJai bakery">
        </div>
        <div class="content-box">
                <h2 class="card-tittle"><?php echo $row_pro['p_name']; ?></h2>
            <h3><?php echo $row_pro['p_detail']; ?></h3>
            <h4>ราคา : <?php echo number_format($row_pro['p_price'], 2); ?> ฿</h4>
            <a href="show_product_detail.php?p_id=<?php echo $row_pro['p_id']; ?>"
                class="buy-product">สั่งสินค้า</a>
        </div>
    </div>
    <?php } ?>
</div>