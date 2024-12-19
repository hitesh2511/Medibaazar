<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   update_cart_quantity.php :-  Update Cart quantity by + and - buttons                --------->


<?php
// Function to update cart quantity
function update_cart_quantity($item_id, $quantity) {
    // Start the session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Initialize updated quantity
    $updated_quantity = 0;

    // Check if the cart is set and not empty
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Loop through the cart to find and update the item's quantity
        foreach ($_SESSION['cart'] as $index => $cart_item) {
            if ($cart_item['item_id'] == $item_id) {
                $_SESSION['cart'][$index]['quantity'] = $quantity; // Update quantity directly
                $updated_quantity = $_SESSION['cart'][$index]['quantity'];
                break; // Stop the loop after updating the item
            }
        }
    }

    // Return the updated quantity
    return $updated_quantity;
}

// Check if item_id and quantity are set in GET request
if (isset($_GET['item_id']) && isset($_GET['quantity'])) {
    $item_id = $_GET['item_id'];
    $quantity = (int)$_GET['quantity']; // Cast quantity to integer
    $updated_quantity = update_cart_quantity($item_id, $quantity);
    echo $updated_quantity; // Output the updated quantity
}
?>
