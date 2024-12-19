<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Reset.php :-  Passowrd reset page                --------->


<?php
include "includes/head.php"

?>

<?php   function get_product_quantity_in_cart($product_id) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cart_item) {
            if ($cart_item['item_id'] == $product_id) {
                return $cart_item['quantity'];
            }
        }
    }
    return 0; // Return 0 if the product is not in the cart
} 

$defaultImagePath="images/Defultmedicine.png"

?>
<head>
<head>
    <title>medibazaar</title>
    <meta name="description" content="medibazaar.shop is online pharmacy. Buy prescription medicines, OTC drugs, and health products online with fast delivery and affordable prices. Shop now!">
    <meta name="keywords" content="buy medicines online, prescription medicines, OTC drugs, health products">
</head>

<script>
// Function to update the quantity in the cart
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const quantityDisplays = document.querySelectorAll('.quantity-display');

    // Function to update the quantity in the cart
    function updateCartQuantity(productId, newQuantity) {
        // AJAX request to update the session cart quantity
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Update the quantity display for the correct product
                document.querySelector('.quantity-display[data-product-id="' + productId + '"]').innerHTML  = `<strong>${newQuantity}</strong>`;
            }
        };
        xhttp.open("Post", "update_cart_quantity?item_id=" + productId + "&quantity=" + newQuantity, true);
        xhttp.send();
    }
  })
// Event listener for the Add to Cart button
document.addEventListener('DOMContentLoaded', function() {
    var addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var productId = this.getAttribute('data-product-id');
            var quantityInput = this.parentElement.querySelector('.quantity');
            var quantity = parseInt(quantityInput.value);
            updateCartQuantity(productId, quantity);
        });
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    const quantityControls = document.querySelectorAll(".quantity-controls");
    const quantityInputs = document.querySelectorAll(".quantity");
    const quantityDisplays = document.querySelectorAll(".quantity-display");
    const incrementButtons = document.querySelectorAll(".increment");
    const decrementButtons = document.querySelectorAll(".decrement");
            

             addToCartButtons.forEach((button, index) => {
        button.addEventListener("click", function () {
            let product_id = button.getAttribute("data-product-id");
            let quantity = parseInt(quantityInputs[index].value, 10);
            toggleVisibility(index, false); // Hide Add to Cart, show quantity controls
            updateCart(product_id, quantity);
        });
    });

    incrementButtons.forEach((button, index) => {
        button.addEventListener("click", function () {
            let quantity = parseInt(quantityInputs[index].value, 10);
            if (!isNaN(quantity) && quantity < 999) {
                quantity++;
                quantityInputs[index].value = quantity;
                quantityDisplays[index].innerHTML  = `<strong>${quantity}</strong>`;
                let product_id = incrementButtons[index].getAttribute("data-product-id+");
                updateCart(product_id, 1);
            }
        });
    });

    decrementButtons.forEach((button, index) => {
        button.addEventListener("click", function () {
            let quantity = parseInt(quantityInputs[index].value, 10);
            if (!isNaN(quantity) && quantity > 1) {
                quantity--;
                quantityInputs[index].value = quantity;
                quantityDisplays[index].innerHTML  = `<strong>${quantity}</strong>`;
                let product_id = decrementButtons[index].getAttribute("data-product-id-");
                updateCart(product_id, -1);
            } else {
                toggleVisibility(index, true); // Show Add to Cart, hide quantity controls
                quantityInputs[index].value = 1;
                quantityDisplays[index].innerHTML  = `<strong>1</strong>`;
                let product_id = decrementButtons[index].getAttribute("data-product-id-");
                deleteFromCart(product_id);
            }
        });
    });
    
            function toggleVisibility(index, showAddToCart) {
        if (showAddToCart) {
            addToCartButtons[index].style.display = "block";
            quantityControls[index].style.display = "none";
        } else {
            addToCartButtons[index].style.display = "none";
            quantityControls[index].style.display = "flex";
        }
    }

            function updateCart(product_id, quantity) {
                let queryString = `product_id=${product_id}&quantity=${quantity}&cart=`;
                fetch(`index?${queryString}`, {
                    method: 'Post'
                })
                .then(response => {
                    if (response.ok) {
                        // Optionally, handle successful response
                    } else {
                        // Optionally, handle error response
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            function deleteFromCart(productId) {
    let queryString = `delete=${productId}`;
    fetch(`index?${queryString}`, {
        method: 'Post'
    })
    .then(response => {
        if (response.ok) {
            // Refresh the page after successful deletion
            window.location.reload();
        } else {
            // Optionally, handle error response
            console.error('Failed to delete item from cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

        });

</script>

<style>
    
.quantity-controls {
    display: none;
    text-align: center;
    margin: 0 auto;
    justify-content: center;
    align-items: center;
  }
  .quantity-controls button {
    margin: 0 5px;
  }
  .add-to-cart, .submit-cart {
    display: block;
    margin: 0 auto;
    width: 100%;
    height: 100%;
    font-weight: bold;
    color: white;
    background-color: #0d8592;
  }
  .add-to-cart:hover, .submit-cart:hover {
    background-color: #45a049;
    color: #f1f1f1;
  }
.add-less-cart, .submit-cart {
    display: block;
    margin: 0 auto;
    width: 100%;
    height: 100%;
    font-weight: bold;
    color: white;
    background-color: #0d8592;
  }
  .add-less-cart:hover, .submit-cart:hover {
    background-color: #45a049;
    color: #f1f1f1;
  }

  .card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .button-section {
    text-align: center;
  }

    
    /* Adjustments for mobile devices */
    @media only screen and (max-width: 768px) {
        .col-sm-2 {
            width: 50% !important;
             /* Full width for mobile devices */
        }
        @media only screen and (max-width: 768px) {
      .carousel-img {
            height: 150px; /* Adjust height for mobile */
        }
      
      .text-muted{
        font-size: .75rem;
      }  
      .col {
            width: 33% !important;
            
             /* Full width for mobile devices */
        }
      .col-sm-2 {
            width: 50% !important;
            
             /* Full width for mobile devices */
        }
        .card-img-top {
            width: 80%!important; /* Full width for images on mobile devices */
            height: auto; /* Auto height to maintain aspect ratio */
        }
        .card-title {
            font-size: .9rem; /* Adjust font size for card titles on mobile devices */
        }
        .card-text {
            font-size: 1rem; /* Adjust font size for card titles on mobile devices */
        }
        .btn-outline-success {
            width: 100%; /* Full width for buttons on mobile devices */
            margin-top: 5px; /* Add some space between buttons */
        }
    }
    }
</style>
</head>

<body>

    <?php

    include "includes/header.php";

    ?>
    <div class="container-fluid ">
        <div class="row">
            <?php
            $data = search();
            if (!empty($data)) {
                $num = sizeof($data);
                for ($i = 0; $i < $num; $i++) {
                    $product_quantity = get_product_quantity_in_cart($data[$i]['item_id']);{

            ?>
                    <div class="col-sm-2" id="cards" style="text-decoration: none;">
    <div class="card border border-secondary h-100">
        <a href="product?product_id=<?php echo $data[$i]['item_id'] ?>" style="text-decoration: none;color: inherit;">
            <img src="images/<?php echo $data[$i]['item_image'];?>" class="card-img-top" style="width:200.3px; height:150px; margin:auto; display:block;" onerror="this.onerror=null;this.src='<?php echo $defaultImagePath; ?>';">
            <div class="card-body">
                <div class="title-section" style="height: 70px;">
                    <?php if (strlen($data[$i]['item_title']) <= 32) { ?>
                        <h6 class="card-title"><?php echo $data[$i]['item_title'] ?></h6>
                    <?php } else { ?>
                        <h6 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo substr($data[$i]['item_title'], 0, 32) . "..." ?></h6>
                    <?php } ?>
                    <small style="color:red;font-weight: bold;"><?php if ($data[$i]['RX']==1){ echo "Rx"; } ?></small><br>
                </div>
                <div class="price-section" style="height: 50px;">
                    <strong>
                    <h5 style="color:Black; font-family:calibri;font-weight: bold;" class="card-text">
                    &#x20B9;<?php echo $data[$i]['item_price']; 
                    if ($data[$i]['discount_percentage'] != 0.00) {
                    echo '<span class="card-text" style="color: #6B6b6b;font-size: 1rem;"> (<S>&#x20B9;'. $data[$i]['MRP'] . '</S>) </span>';
                    echo '<span class="card-text" style="color: #0A6522;font-weight: bold;"> ' . $data[$i]['discount_percentage'] . '% off </span>';
                    }
                    ?>
                    </h5>       
                </strong>
                </div>
                <div class="brand-section" style="margin-top: auto; margin-bottom: auto;">
                    <small class="text-muted" style="font-weight: bold;">Brand: <?php echo $data[$i]['item_brand'] ?></small>
                </div>
            </a>
            <?php if ($product_quantity == 0) { ?> 
    <div class="button-section">
        <ul class="list-group list-group-flush">
            <input type="hidden" class="quantity" value="1">
            <br>
             <?php if($data[$i]['item_quantity'] == 0){ ?>

                <b><p style="color: red; pointer-events: none; background-color:#f1f1f1" class="add-to-cart btn" >Out Of Stock</p></b>

            <?php
            }else{ ?>
            <button type="button" class="add-to-cart btn" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                Add to Cart
            </button>
            <?php } ?>
            <div class="quantity-controls">
                <button type="button" class="decrement btn btn-secondary" data-product-id-="<?php echo $data[$i]['item_id']; ?>">-</button>
                <span class="quantity-display" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                <b>1</b> 
                </span>
                <button type="button" class="increment btn btn-secondary" data-product-id+="<?php echo $data[$i]['item_id']; ?>">+</button>
                <!-- No need for the submit button -->
            </div>
        </ul>
    </div>
<?php } ?>

<?php if ($product_quantity > 0) { ?> 
    <div class="button-section">
        <ul class="list-group list-group-flush">
            <input type="hidden" class="quantity" value="<?php echo $product_quantity; ?>">
            <br>
            <button type="button" style="visibility: hidden;" type="hidden" class="add-to-cart btn" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                Add to Cart
            </button>
            <div class="quantity-controls" style="display: flex;">
                <button type="button" class="decrement btn btn-secondary" data-product-id-="<?php echo $data[$i]['item_id']; ?>">-</button>
                <span class="quantity-display" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                <b><?php echo $product_quantity; ?></b>
                </span>
                <button type="button" class="increment btn btn-secondary" data-product-id+="<?php echo $data[$i]['item_id']; ?>">+</button>
                <!-- No need for the submit button -->
            </div>
        </ul>
    </div>
<?php } }?>
     



        </div>
    </div>
</div>



                <?php
                }
                unset($data);
                if ($num < 11) {
                    $data = all_products();
                    $num = sizeof($data);

                ?>

                    <h5>You May Find These Useful: </h5>
                    <?php
                    for ($i = 0; $i < $num; $i++) {
                        $product_quantity = get_product_quantity_in_cart($data[$i]['item_id']);
                    ?>
  <div class="col-sm-2" id="cards" style="text-decoration: none;">
    <div class="card border border-secondary h-100">
        <a href="product?product_id=<?php echo $data[$i]['item_id'] ?>" style="text-decoration: none;color: inherit;">
            <img src="images/<?php echo $data[$i]['item_image'];?>" class="card-img-top" style="width:200.3px; height:150px; margin:auto; display:block;" onerror="this.onerror=null;this.src='<?php echo $defaultImagePath; ?>';">
            <div class="card-body">
                <div class="title-section" style="height: 70px;">
                    <?php if (strlen($data[$i]['item_title']) <= 32) { ?>
                        <h6 class="card-title"><?php echo $data[$i]['item_title'] ?></h6>
                    <?php } else { ?>
                        <h6 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo substr($data[$i]['item_title'], 0, 32) . "..." ?></h6>
                    <?php } ?>
                    <small style="color:red;font-weight: bold;"><?php if ($data[$i]['RX']==1){ echo "Rx"; } ?></small><br>
                </div>
                <div class="price-section" style="height: 50px;">
                    <strong>
                        <h5 style="color:Black; font-family:calibri;font-weight: bold;" class="card-text">&#x20B9;<?php echo $data[$i]['item_price']. '<span class="card-text" style="color: #6B6b6b;font-size: 1rem;"> (<S>'. $data[$i]['MRP'] .'</S>) </span>' .'<span class="card-text" style="color: #0A6522;font-weight: bold;"> '. $data[$i]['discount_percentage'] .'% off </span>' ?></h5>
                    </strong>
                </div>
                <div class="brand-section" style="margin-top: auto; margin-bottom: auto;">
                    <small class="text-muted" style="font-weight: bold;">Brand: <?php echo $data[$i]['item_brand'] ?></small>
                </div>
            </a>
            <?php if ($product_quantity == 0) { ?> 
    <div class="button-section">
        <ul class="list-group list-group-flush">
            <input type="hidden" class="quantity" value="1">
            <br>
            <?php if($data[$i]['item_quantity'] == 0){ ?>

                <b><p style="color: red; pointer-events: none; background-color:#f1f1f1" class="add-to-cart btn" >Out Of Stock</p></b>

            <?php
            }else{ ?>
            <button type="button" class="add-to-cart btn" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                Add to Cart
            </button>
            <?php } ?>
            <div class="quantity-controls">
                <button type="button" class="decrement btn btn-secondary" data-product-id-="<?php echo $data[$i]['item_id']; ?>">-</button>
                <span class="quantity-display" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                <b>1</b> 
                </span>
                <button type="button" class="increment btn btn-secondary" data-product-id+="<?php echo $data[$i]['item_id']; ?>">+</button>
                <!-- No need for the submit button -->
            </div>
        </ul>
    </div>
<?php } ?>

<?php if ($product_quantity > 0) { ?> 
    <div class="button-section">
        <ul class="list-group list-group-flush">
            <input type="hidden" class="quantity" value="<?php echo $product_quantity; ?>">
            <br>
            <button type="button" style="visibility: hidden;" type="hidden" class="add-to-cart btn" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                Add to Cart
            </button>
            <div class="quantity-controls" style="display: flex;">
                <button type="button" class="decrement btn btn-secondary" data-product-id-="<?php echo $data[$i]['item_id']; ?>">-</button>
                <span class="quantity-display" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                <b><?php echo $product_quantity; ?></b>
                </span>
                <button type="button" class="increment btn btn-secondary" data-product-id+="<?php echo $data[$i]['item_id']; ?>">+</button>
                <!-- No need for the submit button -->
            </div>
        </ul>
    </div>
<?php } ?>
     



        </div>
    </div>
</div>


                <?php
                        if ($i == 5) {
                            break;
                        }
                    }
                }
            } else {
                ?>
                <?php
                }
                unset($data);
                if ($num < 11) {
                    $data = all_products();
                    $num = sizeof($data);

                ?>
                <img src="images/1.gif" style="height: auto; width:auto; margin-left: auto; margin-right: auto;">
               <h5>You May Find These Useful: </h5>
                    <?php
                    for ($i = 0; $i < $num; $i++) {
                        $product_quantity = get_product_quantity_in_cart($data[$i]['item_id']);
                    ?>
  <div class="col-sm-2" id="cards" style="text-decoration: none;">
    <div class="card border border-secondary h-100">
        <a href="product?product_id=<?php echo $data[$i]['item_id'] ?>" style="text-decoration: none;color: inherit;">
            <img src="images/<?php echo $data[$i]['item_image'];?>" Alt="<?php echo $data[$i]['item_title'] ?>" class="card-img-top" style="width:200.3px; height:150px; margin:auto; display:block;" onerror="this.onerror=null;this.src='<?php echo $defaultImagePath; ?>';">
            <div class="card-body">
                <div class="title-section" style="height: 70px;">
                    <?php if (strlen($data[$i]['item_title']) <= 32) { ?>
                        <h6 class="card-title"><?php echo $data[$i]['item_title'] ?></h6>
                    <?php } else { ?>
                        <h6 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo substr($data[$i]['item_title'], 0, 32) . "..." ?></h6>
                    <?php } ?>
                    <small style="color:red;font-weight: bold;"><?php if ($data[$i]['RX']==1){ echo "Rx"; } ?></small><br>
                </div>
                <div class="price-section" style="height: 50px;">
                    <strong>
                        <h5 style="color:Black; font-family:calibri;font-weight: bold;" class="card-text">&#x20B9;<?php echo $data[$i]['item_price']. '<span class="card-text" style="color: #6B6b6b;font-size: 1rem;"> (<S>'. $data[$i]['MRP'] .'</S>) </span>' .'<span class="card-text" style="color: #0A6522;font-weight: bold;"> '. $data[$i]['discount_percentage'] .'% off </span>' ?></h5>
                    </strong>
                </div>
                <div class="brand-section" style="margin-top: auto; margin-bottom: auto;">
                    <small class="text-muted" style="font-weight: bold;">Brand: <?php echo $data[$i]['item_brand'] ?></small>
                </div>
            </a>
            <?php if ($product_quantity == 0) { ?> 
    <div class="button-section">
        <ul class="list-group list-group-flush">
            <input type="hidden" class="quantity" value="1">
            <br>
            <?php if($data[$i]['item_quantity'] == 0){ ?>

                <b><p style="color: red; pointer-events: none; background-color:#f1f1f1" class="add-to-cart btn" >Out Of Stock</p></b>

            <?php
            }else{ ?>
            <button type="button" class="add-to-cart btn" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                Add to Cart
            </button>
            <?php } ?>
            <div class="quantity-controls">
                <button type="button" class="decrement btn btn-secondary" data-product-id-="<?php echo $data[$i]['item_id']; ?>">-</button>
                <span class="quantity-display" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                <b>1</b> 
                </span>
                <button type="button" class="increment btn btn-secondary" data-product-id+="<?php echo $data[$i]['item_id']; ?>">+</button>
                <!-- No need for the submit button -->
            </div>
        </ul>
    </div>
<?php } ?>

<?php if ($product_quantity > 0) { ?> 
    <div class="button-section">
        <ul class="list-group list-group-flush">
            <input type="hidden" class="quantity" value="<?php echo $product_quantity; ?>">
            <br>
            <button type="button" style="visibility: hidden;" type="hidden" class="add-to-cart btn" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                Add to Cart
            </button>
            <div class="quantity-controls" style="display: flex;">
                <button type="button" class="decrement btn btn-secondary" data-product-id-="<?php echo $data[$i]['item_id']; ?>">-</button>
                <span class="quantity-display" data-product-id="<?php echo $data[$i]['item_id']; ?>">
                    <b><?php echo $product_quantity; ?></b>
                </span>
                <button type="button" class="increment btn btn-secondary" data-product-id+="<?php echo $data[$i]['item_id']; ?>">+</button>
                <!-- No need for the submit button -->
            </div>
        </ul>
    </div>
<?php } ?>
     



        </div>
    </div>
</div>


                  <?php
                    if ($i == 5) {
                        break;
                    }
                }
            }

            ?>
        </div>
    </div>

    <!-- FOOTER -->
    <?php
    include "includes/footer.php"
    ?>
</body>

</html>