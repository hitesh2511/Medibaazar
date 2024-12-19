<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   products.php :- add or update products                 --------->
<?php
include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php"
    ?>


    <?php
    include "includes/sidebar.php";
    ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <?php
        message();
        ?>
        <div class="container">
            <div class="row align-items-start">
                <div class="col">
                    <br>
                    <h2>Products details</h2>
                    <br>
                </div>
                <div class="col">
                </div>
                <div class="col">
                    <br>
                    <form class="d-flex" method="GET" action="products.php">
                        <input class="form-control me-2 col" type="search" name="search_item_name" placeholder="Search for product" aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit" name="search_item" value="search">Search</button>
                    </form>
                    <br>
                </div>
            </div>
        </div>
        <?php
        edit_item(@$_SESSION['id']);

        if (isset($_GET['edit'])) {
            $_SESSION['id'] = $_GET['edit'];
            $data = get_item($_SESSION['id']);

        ?>
            <br>
            <h2>Edit Product Details</h2>
            <form action="products.php" method="POST">
                <div class=" form-group mb-3">
                    <label>Product name</label>
                    <input  id="exampleInputText1" type="text" class="form-control" value="<?php echo $data[0]['item_title'] ?>" name="name">
                    <div class="form-text">please enter the product name in range(1-25) character/s , special character not allowed !</div>
                </div>
                <div class="form-group">
                    <label>Brand name</label>
                    <input pattern="[A-Za-z0-9_]{1,25}" id="validationTooltip01" type="text" class="form-control" value="<?php echo $data[0]['item_brand'] ?>" name="brand">
                    <div class="form-text">please enter the brand name in range(1-25) character/s , special character not allowed !</div>
                
                </div>
                <div class="form-group">
                    <label>Composition</label>
                    <input pattern="[A-Za-z0-9_]{1,25}" id="validationTooltip01" type="text" class="form-control" value="<?php echo $data[0]['Composition'] ?>" name="Composition">
                    <div class="form-text">please enter the Composition name in range(1-25) character/s , special character not allowed !</div>
                
                </div>

                <div class="input-group mb-3 form-group">
                    <label class="input-group-text" for="inputGroupSelect01">category</label>
                    <select name="cat" class="form-select" id="inputGroupSelect01">
                        <option selected>Choose...</option>
                        <?php
                            $options=get_list();    
                            
                            // Loop through the array and create an option element for each item
                            foreach ($options as $option) {
                                echo "<option>$option</option>";
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Product tags</label>
                    <input pattern="^[#.0-9a-zA-Z\s,-]+$" id="validationTooltip01" type="text" class="form-control" value="<?php echo $data[0]['item_tags'] ?>" name="tags">
                    <div class="form-text">please enter tags for the product in range(1-250) character/s , special character not allowed !</div>
                </div>
                <div class="form-group">
                    <label>Product image</label>
                    <input type="file" accept="image/*" class="form-control" >" name="image">
                    <div class="form-text">please enter image for the product .</div>
                </div>
                <div class="form-group">
                    <label>Product quantity</label>
                    <input type="number" class="form-control" value="<?php echo $data[0]['item_quantity'] ?>" name="quantity" min="1" max="999">
                    <div class="form-text">please enter the quantity of the product in range(1-999) .</div>
                </div>
                <div class="input-group mb-3 form-group">
                    <span class="input-group-text">₹</span>
                    <input pattern="[0-9]+" id="validationTooltip01" type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="MRP" value="<?php echo $data[0]['MRP'] ?>">
                    
                </div>
                <div class="form-text">please enter the MRP of the product .</div>

                <div class="input-group mb-3 form-group">
                    <span class="input-group-text">₹</span>
                    <input pattern="[0-9]+" id="validationTooltip01" type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" value="<?php echo $data[0]['item_price'] ?>">
                    
                </div>
                <div class="form-text">please enter the price of the product .</div>
                
                <div class="form-group">
                    <label for="inputAddress2">Product details</label>
                    <input type="text" class="form-control" value="<?php echo $data[0]['item_details'] ?>" name="details">
                </div>
                <div class="form-text">please enter the product details .</div>
                <br>
                <button type="submit" class="btn btn-outline-primary" value="update" name="update">Submit</button>
                <button type=" submit" class="btn btn-outline-danger" value="cancel" name="cancel">Cancel</button>
                <br> <br>
            </form>
        <?php
        }
        ?>
            
            <?php
error_reporting(E_ALL); // Enable error reporting to catch all errors

$msg = "";
$_SESSION["productimage"] = "";

// If upload button is clicked ...
if (isset($_POST['add_item'])) {

    date_default_timezone_set("Asia/Kolkata");
    $filename = $_FILES["image"]["name"];
    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $filenamewith = $filename . "." . $extension;
    $_SESSION["productimage"] = $filenamewith;
    $folder = "/home/images/"; // Specify the folder path
    
    // Move uploaded file to the destination folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $folder . $filenamewith)) {
        echo '<script>alert("image uploaded successfully")</script>';
        add_item(); // 
    } else {
        // Display the exact error message when upload fails
        echo '<script>alert("Failed to upload Prescription: ' . $_FILES["image"]["error"] . '")</script>';        
    }
}
   
        if (isset($_GET['add'])) {
        ?>
            <br>
            <h2>Add Product</h2>
            <form action="products.php" method="POST" enctype="multipart/form-data">
                <div class=" form-group mb-3">
                    <label>Product name</label>
                    <input id="exampleInputText1" type="text" class="form-control" placeholder="product name" name="name">
                    <div class="form-text">please enter the product name in range(1-25) character/s , special character not allowed !</div>
                </div>
                <div class="form-group">

                <div class=" form-group mb-3">
                    <label>Composition</label>
                    <input id="exampleInputText1" type="text" class="form-control" placeholder="Composition" name="Composition">
                    <div class="form-text">please enter the product Composition in range(1-25) character/s , special character not allowed !</div>
                </div>
                <div class="form-group">  
                
                    <label>Brand name</label>
                    <input id="validationTooltip01" type="text" class="form-control" placeholder="product brand" name="brand">
                    <div class="form-text">please enter the brand name in range(1-25) character/s , special character not allowed !</div>
                </div>
                <div class="input-group mb-3 form-group">
                    <label class="input-group-text" for="inputGroupSelect01">category</label>
                    <select name="cat" class="form-select" id="inputGroupSelect01">
                        <option value="" selected>Choose...</option>
                        <?php
                            $options=get_list();    
                            
                            // Loop through the array and create an option element for each item
                            foreach ($options as $option) {
                                echo "<option>$option</option>";
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Product tags</label>
                    <input id="validationTooltip01" type="text" class="form-control" placeholder="product tags" name="tags">
                    <div class="form-text">please enter tags for the product in range(1-250) character/s , special character not allowed !</div>
                </div>
                <div class="form-group">
                    <label>Product image</label>
                    <input type="file" accept="image/*" class="form-control" placeholder="image" name="image">
                    <div class="form-text">please enter image for the product .</div>
                </div>
                <div class="form-group">
                    <label>Product quantity</label>
                    <input type="number" class="form-control" placeholder="product quantity" name="quantity" min="1" max="999">
                    <div class="form-text">please enter the quantity of the product in range(1-999) .</div>
                </div>
                
                <div class="input-group mb-3 form-group">
                    <span class="input-group-text">₹</span>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" placeholder="MRP">
                    
                </div>

                <div class="input-group mb-3 form-group">
                    <span class="input-group-text">₹</span>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" placeholder="product price">
                    
                </div>
                <div class="form-text">please enter the price of the product .</div>
                <div class="form-group">
                    <label for="inputAddress2">Product details</label>
                    <input type="text" class="form-control" placeholder="product details" name="details">
                </div>
                <div class="form-text">please enter the product details .</div>
                <br>
                <button type="submit" class="btn btn-outline-primary" value="update" name="add_item">Submit</button>
                <button type=" submit" class="btn btn-outline-danger" value="cancel" name="cancel">Cancel</button>
                <br> <br>
            </form>
        <?php
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Category</th>
                        <th scope="col">Tags</th>
                        <th scope="col">Image</th>
                        <th scope="col">quantity</th>
                        <th scope="col">MRP</th>
                        <th scope="col">price</th>                        
                        <th scope="col">details</th>
                        <th>
                        <th>
                            <button type="button" class="btn btn-outline-primary"><a style="text-decoration: none; color:black;" href="products.php?add=1"> &nbsp;&nbsp;Add&nbsp;&nbsp;</a></button>
                        </th>
                        </th>

                </thead>

                <tbody>
                    <?php
                    $data = all_items();
                    delete_item();
                    if (isset($_GET['search_item'])) {
                        $query = search_item();
                        if (isset($query)) {
                            $data = $query;
                        } else {
                            get_redirect("products.php");
                        }
                    } elseif (isset($_GET['id'])) {
                        $data = get_item_details();
                    }
                    if (isset($data)) {


                        $num = sizeof($data);
                        for ($i = 0; $i < $num; $i++) {
                    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $data[$i]['item_id'] ?></td>
                                <td><?php echo $data[$i]['item_title'] ?></td>
                                <td><?php echo $data[$i]['item_brand'] ?></td>
                                <td><?php echo $data[$i]['item_cat'] ?></td>
                                <td><?php echo $data[$i]['item_tags'] ?></td>
                                <td><?php echo $data[$i]['item_image'] ?></td>
                                <td><?php echo $data[$i]['item_quantity'] ?></td>
                                <td><?php echo $data[$i]['MRP'] ?></td>
                                <td><?php echo $data[$i]['item_price'] ?></td>
                                <td><?php echo $data[$i]['item_details'] ?></td>
                                <td>
                                    <button type="button" class="btn pull-left btn-outline-warning"><a style="text-decoration: none; color:black;" href="products.php?edit=<?php echo $data[$i]['item_id'] ?>">Edit</a></button>
                                </td>
                                <td>
                                    <button type="button" class="btn pull-left btn-outline-danger"><a style="text-decoration: none; color:black;" href="products.php?delete=<?php echo $data[$i]['item_id'] ?>">Delete</a></button>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    </div>
    </div>
    <?php
    include "includes/footer.php"
    ?>
</body>