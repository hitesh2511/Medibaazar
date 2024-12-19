<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   product.php :-  Product Discription                 --------->


<?php
include "includes/head.php";
include "includes/header.php";

$defaultImagePath="images/Defultmedicine.png";

$data = get_item();
if (isset($_GET['cart']) || isset($_GET['buy'])) {
  
  
  add_cart($_SESSION['item_id']);


}
?>

<head>
<title><?php echo $data[0]['item_title'] ?>: Uses, Discription & Price  | Medibazaar</title>
    <meta name="description" content="Purchase Paracetamol tablets online at Medibazaar.shop. Get fast delivery and great discounts on all medicines. Order now from your trusted online pharmacy.">
    <meta name="keywords" content="<?php echo $data[0]['item_title'] ?>, online pharmacy, Medibazaar.shop">
</head>

<body>
  <br>
  <div class="container-fluid bg-3 text-center">
    <div class="row">
      <div class="col">
        <img src="images/<?php echo $data[0]['item_image'] ?>" alt="<?php echo $data[0]['item_title'] ?>" class="img-fluid" onerror="this.onerror=null;this.src='<?php echo $defaultImagePath; ?>';">
      </div>
      <div class="col">
        <br>
        <h4 style="font-weight: bold;"><?php echo $data[0]['item_title'] ?><br></h4>
        <br>
        <div class="border border-1" style="width: 100%;"></div>
        <div class="container">
          <div class="row">
            <div class="col-6 col-sm-4" style="font-weight: bold;">Brand&nbsp;:</div>
            <div class="col-6 col-sm-4" style="margin-left: .1rem; color: #363636;"><?php echo $data[0]['item_brand'] ?></div>
            <div class="w-100 d-none d-md-block"></div>
            <div class="col-6 col-sm-4" style="font-weight: bold;">Category&nbsp;:</div>
            <div class="col-6 col-sm-4" style="margin-left: .1rem; color: #363636;"><?php echo $data[0]['item_cat'] ?></div>
            <div class="w-100 d-none d-md-block"></div>
            <?php if (!empty($data[0]['Composition'])) { ?>
              <div class="col-6 col-sm-4" style="font-weight: bold;">Composition&nbsp;:</div>
              <div class="col-6 col-sm-4" style="margin-left: .1rem; color: #363636;"><?php echo htmlspecialchars($data[0]['Composition']); ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="border border-1" style="width: 100%;"></div>
        <br>
        <h5 style="width: 100%; padding-right: 10rem; font-weight: bold;">About this item:</h5>
        <br>
        <p style="color: #363636;"><?php echo $data[0]['item_details'] ?></p>
        <div class="border border-1" style="width: 100%;"></div>
        <br>
      </div>
      <div class="col-sm-4" style="padding-left: 5rem;">
        <div class="card" style="width: 18rem;">
          <div class="card-body">
          <h5 style="color:Black; font-family:calibri;font-weight: bold;" class="card-text">
                    &#x20B9;<?php echo $data[0]['item_price']; 
                    if ($data[0]['discount_percentage'] != 0.00) {
                    echo '<span class="card-text" style="color: #6B6b6b;font-size: 1rem;"> (<S>&#x20B9;'. $data[0]['MRP'] . '</S>) </span>';
                    echo '<span class="card-text" style="color: #0A6522;font-weight: bold;"> ' . $data[0]['discount_percentage'] . '% off </span>';
                    }
                    ?>
                    </h5>
            <?php if ($data[0]['item_quantity'] > 0) { ?>
              <h6 style="color: #0A6522;">In Stock</h6>
            <?php } else { $out = 1; ?>
              <small style="color: red;">Out Of Stock</small>
            <?php } ?>
            <p class="card-text">
              <?php if (isset($_SESSION['user_id'])) { ?>
                <span style="color: #000080;">Deliver to :</span>
                <?php
                $user = get_user($_SESSION['user_id']);
                global $encryptionKey;
                echo decryptData($user[0]['user_address'], $encryptionKey);
              } ?>
            </p>
            <?php if (@$out != 1) { ?>
              <form action="product" method="GET">
                <div class="form-group">
                  <input value="1" type="number" class="form-control" name="quantity" min="1" max="999">
                </div>
                <br>
                <button type="submit" value="buy" name="buy" class="btn btn-warning" style="display: block; margin: 0 auto; font-weight: bold; color: white; background-color: #0d8592;" onmouseover="this.style.backgroundColor='#45a049'; this.style.color='#f1f1f1';" onmouseout="this.style.backgroundColor='#0d8592'; this.style.color='white';">Buy Now</button>
                <br>
                <button type="submit" value="" name="cart" class="btn btn-warning" style="display: block; margin: 0 auto; font-weight: bold; color: white; background-color: #0d8592;" onmouseover="this.style.backgroundColor='#45a049'; this.style.color='#f1f1f1';" onmouseout="this.style.backgroundColor='#0d8592'; this.style.color='white';">Add to Cart</button>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <br>
  </div>
</body>
  
  

  <?php
  include "includes/footer.php"
  ?>


</html>