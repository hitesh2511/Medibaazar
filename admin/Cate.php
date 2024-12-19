<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Cate.php :-  create and update Categorys                 --------->

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
                    <h2>Category</h2>
                    <br>
                </div>
                <div class="col">
                </div>
                <div class="col">
                    <br>
                    
                </div>
            </div>
        </div>

       
        <?php
error_reporting(E_ALL); // Enable error reporting to catch all errors

$msg = "";
$_SESSION["filecat"] = "";

// If upload button is clicked ...
if (isset($_POST['add'])) {

    date_default_timezone_set("Asia/Kolkata");
    $filename = $_FILES["image"]["name"];
    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $filenamewith = $filename . "." . $extension;
    $_SESSION["filecat"] = $filenamewith;
    $folder = "/Var/www/html/images/"; // folder path of system
    
    // Move uploaded file to the destination folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $folder . $filenamewith)) {
        echo '<script>alert("Successfully order placed by precription, We will create your order shortly!!")</script>';
        addCategory(); 
    } else {
        // Display the exact error message when upload fails
        echo '<script>alert("Failed to upload Prescription: ' . $_FILES["image"]["error"] . '")</script>';        
    }
}
       
        if (isset($_GET['add'])) {

        ?>
            <h2>Add Category </h2>
            <form action="Cate.php" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                    <label for="validationTooltip01">Category</label>
                    <input id="validationTooltip01" type="text" class="form-control" name="Category">
                    <div class="form-text">please enter the Category</div>
                </div>

                <div class="form-group">
                    <label for="validationTooltip01">Tagline</label>
                    <input id="validationTooltip01" type="text" class="form-control" name="Tagline">
                    <div class="form-text">please enter the Tagline</div>
                </div>    
            <div class="form-group">
                    <label>Product image</label>
                    <input type="file" accept="image/*" class="form-control" name="image">
                    <div class="form-text">please enter image for the product .</div>
                    <button type="submit" class="btn btn-outline-primary" value="add" name="add">Submit</button>
                            <button type=" submit" class="btn btn-outline-danger" value="cancel" name="cancel">Cancel</button>
                            <br> <br>            

                </div>
                
            </form>

        <?php
    
          } ?>   
         <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Tagline</th>
                        <th scope="col">Images</th>
                        <th scope="col">
                            <button type="button" class="btn btn-outline-primary "><a style="text-decoration: none; color:black;" href="Cate.php?add=1"> &nbsp;&nbsp;Add&nbsp;&nbsp;</a></button>
                        </th>
                        
                </thead>

                <tbody>
                    <?php
                    $data = Category();
                    delete_category();
                    
                    $num = sizeof($data);
                    for ($i = 0; $i < $num; $i++) {

                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $data[$i]['ID'] ?></td>
                            <td><?php echo $data[$i]['Tagline'] ?></td>
                            <?php echo '<td><img Style="width:100px; height:100px" src="/' . $data[$i]['Images'] . '" > </td>' ?>                            
                            
                            <?php  
                            ?>
                            <td>
                                <button type="button" class="btn pull-left btn-outline-danger"><a style="text-decoration: none; color:black;" href="Cate.php?delete=<?php echo $data[$i]['ID'] ?>">Delete</a></button>
                            </td>
                                                        
                        </tr>
                    <?php
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