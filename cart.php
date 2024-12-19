<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   cart.php :-  Cart Page                 --------->


<?php
include "includes/head.php"
?>
<style>
.container {
    display: flex;
     
    align-items: center; 
}
</style>

<?php
error_reporting(0);

$msg = "";
$imguploaded = false;
$_SESSION["filenameonpri"] = "";

$defaultImagePath="images/Defultmedicine.png";

if (isset($_POST['upload'])) {
    date_default_timezone_set("Asia/Kolkata");

    // Check if 'user_id' session variable exists and is not empty
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        $msg = "User session not found. Please log in again."; // Set error message
    } else {
        $filename = $_SESSION['user_id'] . "_" . date("d-m-y_H-i-s");
        $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
        $file = $filename . "." . $extension;
        $_SESSION["filenameonpri"] = $file;
        $folder = "/Prescription/";

        // Check if the destination folder exists and has write permissions
        if (!file_exists($folder)) {
            $msg = "Destination folder does not exist.".$folder ;
        } elseif (!is_writable($folder)) {
            $msg = "Destination folder is not writable.".$folder ;
            
        } elseif (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $folder . $file)) {
            $msg = "Prescription uploaded successfully!";
            $imguploaded = true;
        } else {
            $msg = "Failed to upload Prescription!";
        }
    }
}

// Display the message in your HTML
if (!empty($msg)) {
    echo '<script>alert("' . $msg . '")</script>';
}
?>
<head>
    <title>Medibazaar: Cart</title>
    <meta name="description" content="Medibazaar.shop trusted online pharmacy. Buy prescription medicines, OTC drugs, and health products online with fast delivery and affordable prices. Shop now!">
    <meta name="keywords" content="buy medicines online, prescription medicines, OTC drugs, health products">
</head>

<body>
    <?php
    include "includes/header.php";
    ?>


    </div>
    <!-- PRODUCT header-->
    <div class="shopping" style="margin: 10px; border-bottom: 4px; font-weight: bold;">
        <h5> Shopping Cart</h5>
        <h1 class="border border-1.5" style="width: 100%;"> </h1>
    </div>
    
    <?php 
    $current_time = strtotime('now');

    // Convert the current time to the server's timezone
    $current_hour = date('H', $current_time);

    $current_day = date('w', $current_time); 
    
    if (($current_hour >= 18 || $current_hour < 11) && $current_day<>0) { ?>
        <div class="shopping" style="text-align: Center; margin: 20px; border-bottom: 4px; font-weight: bold; color: red" >
            <h5 style="font-family:calibri;font-weight: bold">Our outlet is currently closed. Orders placed after 6:00 PM and before 11:00 AM will be delivered after 11:00 AM the following morning.<br> Thank you for your understanding and patience!</h5>
            
        </div>
        </div>
   <?php } 
    
    if ($current_day == 0) { ?>
    <div class="shopping" style="text-align: Center; margin: 20px; border-bottom: 4px; font-weight: bold; color: red" >
        <h5 style="font-family:calibri;font-weight: bold">"Our outlet is closed on Sundays. All orders placed on Sunday will be delivered after 11:00 AM the following morning.<br> Thank you for your understanding and patience!</h5>
        
    </div>
   <?php } ?>      

   
    <!-- end of PRODUCT header-->

    <!-- PRODUCTS-->
    <div class="container-fluid">
        <?php
        if (!empty($_SESSION['cart'])) {
            $data = get_cart();
            delete_from_cart();
            $num = sizeof($data);
            $total = 0; // Initialize total price variable
            $hasRx = false;

            for ($i = 0; $i < $num; $i++) {
                if (isset($data[$i])) {
                    $item_price = $data[$i][0]['item_price'] * $_SESSION['cart'][$i]['quantity'] ;//
                    $MRP= $data[$i][0]['MRP'] * $_SESSION['cart'][$i]['quantity'];
                    $item_quantity = $_SESSION['cart'][$i]['quantity'];
                    $total += $item_price; // Add item price to total
                    ?>
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="images/<?php echo $data[$i][0]['item_image'] ?>" class="img-fluid rounded-start" style="margin: 10px; width: 20.45rem; height: 15.45rem; " alt="..." onerror="this.onerror=null;this.src='<?php echo $defaultImagePath; ?>';">
                            </div>

                            <!--CATALOG FOR THE PRODUCT-->
                            <div class="col-md-4">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data[$i][0]['item_title'] ?></h5>

                                    <?php if ($data[$i][0]['item_quantity'] > 0) { ?>
                                        <small style="color:Black;font-weight: bold">In Stock</small>
                                    <?php } else { ?>
                                        <small style="color: red; font-weight: bold">Out Of Stock</small>
                                    <?php } ?>

                                    </p>
                                    <h5 style="color:Black; font-family:calibri;font-weight: bold;">₹<?php echo $item_price . '<span Style="color: #6B6b6b;font-size: 1.1rem;"> (<S>'. $MRP .'</S>) </span>'.'<span Style="color: #0A6522;font-size: 1.1rem;font-weight: bold;">'. $data[$i][0]['discount_percentage'] .'% off </span>' ?></><br>
                                    
                                    <small class="text-muted" style="font-weight: bold;">Brand Name </small>
                                    <small style="color:Black; font-family:calibri;font-weight: bold;padding:10px ;"><?php echo $data[$i][0]['item_brand'] ?></small><br>
                                    <small class="text-muted" style="font-weight: bold;">Quantity </small>
                                    <small style="color:Black; font-family:calibri;font-weight: bold;padding:10px ;"><?php echo $item_quantity ?></small><br>
                                    <H5 style="color: #FF0000;font-weight: bold;"><?php if($data[$i][0]['RX']==1){echo "Rx";}?></small><br><br>
                                    <a href="cart?delete=<?php echo $data[$i][0]['item_id'] ?>" class="btn btn-danger ">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                }
            }
        ?>
        
            <!-- end of PRODUCTS -->

            <!-- TOTAL -->
            <div class="shopping" style="margin: 10px; border-bottom: 4px; font-weight: bold;">
                <h5 style="color:Black; font-family:calibri;font-weight: bold;" class="card-text"> Total </h5>
                <h1 class="border border-1.5" style="width: 100%;"> </h1>
            </div>
            <div style="margin-left: 10%;">
                <br>
                               
               <h5 style="color:Black; font-family:calibri;font-weight: bold;" class="card-text"><?php 
               if ($total<500) { $Shppingfee=50; echo "Shipping charges :  ₹ $Shppingfee<br>"; echo "Total (";
                            echo $num . " ";
                            if ($num == 1 or $num == 0) {
                                echo "item";
                            } else {
                             echo "items ";
                            }  $Total1=$total+$Shppingfee;  echo ") : ₹ $Total1 ";} elseif($total>500){  echo "Total (";
                                echo $num . " ";
                                if ($num == 1 or $num == 0) {
                                    echo "item";
                                } else {
                                    echo "items";
                                }  echo ") : ₹ $total" ;} ?>  </h5>
                            
                
               <h5 style="color:Black; font-family:calibri;font-weight: bold;" class="card-text"> Payment Mode: Cash On Delivery/UPI On Delivery </h5>
               <br>
           <?php
                   foreach ($data as $item) {
                    // Check if the current item has "Rx" set to 1
                    if ($item[0]['RX'] == 1) {
                        // "Rx" found, set $hasRx to true and exit the loop
                        $hasRx = true;
                        break;
                    }
                }                                            
                   if ($hasRx==true And $imguploaded==false ) : 
                    ?>
                    <h5 style="color:red; font-family:calibri;font-weight: bold;"> Please upload Prescription on the below button </h5>
                    <?php endif
            ?> 

            </div>
            </div>
            <div class="container" style="margin-left: 1%">
                <a href="cart?delete_all=1" class="btn btn-danger btn"> Delete all Products !</a>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        
                    
                <?php if ($hasRx == true AND $imguploaded==false) : ?>
                    <div style="margin-top:5%" id="uploadButton">   
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input class="form-control input-file" type="file" style="width: 90%;" name="uploadfile" value="" accept=".jpg, .jpeg, .png, .pdf"/><br>
                            <button class="btn btn-primary upload-btn" type="submit" name="upload">UPLOAD</button>
                        </form>
                    </div>
                <?php elseif ($hasRx == false OR $imguploaded==true) : ?>
                    <a href="final?order=done" class="btn btn-success btn"> &nbsp;Proceed to Buy &nbsp;</a>
                <?php endif; ?>
                
                
                <br><br>
            </div>
        <?php
        } else {
        ?>
            <h1 style="text-align: center; font-family: 'Fredoka One', cursive;">No products in the Cart</h1>
            <p style="text-align: center; font-family: 'Fredoka One', cursive;">Please add at least product to Buy</p>
            <img style="width:50%; margin:auto; display:block;" src="images/nocart.png" alt="">
        <?php
        }
        ?>

    </div>
   
    <!-- end of TOTAL -->
    <!-- FOOTER -->
    <?php
    include "includes/footer.php"
    ?>

</body>

</html>
