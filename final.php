<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Final.php :-  Thank you page             --------->


<?php
include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php";
    ?>
    <div>
    <img src="images/shopingcartlogo.jpeg" alt="" style="width:50%; display: block; margin: 0 auto;">     
        <h5 style="text-align: center; color:green; font-weight:bold; font-family: Calibri,">Thank you! Your Order Successfully Placed
           <br>
        
    </div>
    <br>
    <a href="Myorder" style="text-decoration: none;"> <button  style=" display: block; margin: 0 auto;font-weight:bold; color:white;  background-color: #0d8592;" onmouseover="this.style.backgroundColor='#45a049'; this.style.color='#f1f1f1';" onmouseout="this.style.backgroundColor='#0d8592'; this.style.color='white';" type="button" class="btn btn-info btn-lg">My Orders </button></a><br>
    <a href="index" style="text-decoration: none;"> <button  style=" display: block; margin: 0 auto;font-weight:bold; color:white;  background-color: #0d8592;" onmouseover="this.style.backgroundColor='#45a049'; this.style.color='#f1f1f1';" onmouseout="this.style.backgroundColor='#0d8592'; this.style.color='white';" type="button" class="btn btn-info btn-lg">Go back to the store </button></a>
    <?php
    add_order();
    ?>
    <br>
    <!-- FOOTER -->
    <?php
    include "includes/footer.php"
    ?>

</body>