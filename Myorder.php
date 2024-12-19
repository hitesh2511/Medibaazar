<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Myorder.php :-  Track order deails                 --------->


<?php
include "includes/head.php";
$defaultImagePath="images/Defultmedicine.png";
?>
<style>

</style>
<head>
    <title>Medibazaar: My Orders</title>
    <meta name="description" content="Medibazaar.shop is trusted online pharmacy. Buy prescription medicines, OTC drugs, and health products online with fast delivery and affordable prices. Shop now!">
    <meta name="keywords" content="buy medicines online, prescription medicines, OTC drugs, health products">
</head>

<body>
    <?php
    include "includes/header.php";
    ?>


    <div class="shopping" style="margin: 10px; border-bottom: 4px; font-weight: bold;">
        <h5>My Orders</h5>
        <h1 class="border border-1.5" style="width: 100%;"></h1>
    </div>


    <!-- PRODUCTS-->
    <div class="container-fluid">
        <?php
        if (!empty($_SESSION['user_id'])) {
            @$userdata = Myorder($_SESSION['user_id']);
            if (!empty($userdata)) {
                
                foreach ($userdata as $order):
                    $item = get_item_id($order['item_id']);
                    ?>
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="images/<?php echo $item[0]['item_image']; ?>" class="img-fluid rounded-start" style="margin: 10px; width: 20.45rem; height: 15.45rem;" alt="..." onerror="this.onerror=null;this.src='<?php echo $defaultImagePath; ?>';">
                            </div>
                                    
                            <!--CATALOG FOR THE PRODUCT-->
                            <div class="col-md-4">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #000080;"><?php echo $item[0]['item_title']; ?></h5>
                                    <p>
                                    <small class="text-muted" style="font-weight: bold;">Order Date </small>
                                    <small style="color:#000080; font-weight: bold; padding:10px;">
                                        <?php 
                                            $order_date_timestamp = strtotime($order['order_date']); 
                                            $orderdate = date('d/m/y H:i A', $order_date_timestamp); 
                                            echo $orderdate; 
                                        ?>
                                    </small><br>
                                    <small class="text-muted" style="font-weight: bold;">Order ID </small>
                                    <small style="color:#000080; font-weight: bold; padding:10px;"><?php echo $order['order_id']; ?></small><br>
                                    <small class="text-muted" style="font-weight: bold;">Quantity </small>
                                    <small style="color: #000080; font-weight: bold; padding:10px;"><?php echo $order['order_quantity']; ?></small><br>
                                    <small class="text-muted" style="font-weight: bold;">MRP: </small>
                                    <small style="color: #000080; font-weight: bold;">₹<?php echo $item[0]['MRP']; ?></small><br>
                                    <small class="text-muted" style="font-weight: bold;">Amount: </small>
                                    <small style="color: #000080; font-weight: bold;">₹<?php echo $order['order_price']; ?></small><br>
                                    <small class="text-muted" style="font-weight: bold;">Shipping Charges: </small>
                                    <small style="color: #000080; font-weight: bold;">₹<?php echo $order['Shipping_charges']; ?></small><br>
                                    <small class="text-muted" style="font-weight: bold;">Total: </small>
                                    <small style="color: #000080; font-weight: bold;">₹<?php $total = $order['Shipping_charges'] + $order['order_price']; echo $total; ?></small><br>
                                    <h6 class="card-title" style="color: #154734;">Status: 
                                        <?php 
                                            if($order['order_status'] == 2) { 
                                                echo "Delivered"; 
                                            } elseif($order['order_status'] == 1) { 
                                                echo "Shipped"; 
                                            } elseif($order['order_status'] == 0) { 
                                                echo "Order Received"; 
                                            } 
                                        ?> 
                                    </h6>       
                                    <h5 style="color: #FF0000; font-weight: bold;">
                                        <?php if($item[0]['RX'] == 1) { echo "Rx"; } ?>
                                    </h5>
                                </div>
                            </div>     
                            <div class="col-md-4">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php
            } else {
            ?>
                <h1 style="text-align: center; font-family: 'calibri';">No orders received yet</h1>
                <br>
                
            <?php
            }
        } else {
            ?>
            <h1 style="text-align: center; font-family: 'calibri';">Please login to view your orders</h1>
            <br>
          
        <?php
        }
        ?>
    </div>
    <!-- end of PRODUCTS -->

    <!-- FOOTER -->
    <?php
    include "includes/footer.php";
    ?>
</body>
</html>
