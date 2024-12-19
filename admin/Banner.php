<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Banner.php :-  upload banners images                 --------->


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
                    <h2>Banners</h2>
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
session_start(); // Start session

$msg = "";
$_SESSION["filebannername"] = "";

// If upload button is clicked ...
if (isset($_POST['add'])) {

    date_default_timezone_set("Asia/Kolkata");
    $filename = $_FILES["image"]["name"];
    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $filenamewith = $filename;
    $_SESSION["filebannername"] = $filenamewith;
    $folder = "/Var/www/html/images/"; // Specify the folder path
    
    // Move uploaded file to the destination folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $folder . $filenamewith)) {
        echo '<script>alert("Image uploaded successfully")</script>';
        addimage();
    } else {
        // Display the exact error message when upload fails
        echo '<script>alert("Failed to upload Prescription. Error code: ' . $_FILES["image"]["error"] . '")</script>';        
    }
}

        if (isset($_GET['add'])) {

        ?>
          <h2>Add new Banner</h2>
<form action="Banner.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>Product image</label>
        <input type="file" accept="image/*" class="form-control" name="image">
        <div class="form-text">Please select an image for the product.</div>
        <button type="submit" class="btn btn-outline-primary" name="add">Submit</button>
        <button type="submit" class="btn btn-outline-danger" name="cancel">Cancel</button>
        <br><br>            
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
                        <th scope="col">Images</th>
                        <th scope="col">
                            <button type="button" class="btn btn-outline-primary "><a style="text-decoration: none; color:black;" href="Banner.php?add=1"> &nbsp;&nbsp;Add&nbsp;&nbsp;</a></button>
                        </th>
                        
                </thead>

                <tbody>
                    <?php
                    $data = Banner();
                    delete_Banner();
                    
                    $num = sizeof($data);
                    for ($i = 0; $i < $num; $i++) {

                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $data[$i]['Id'] ?></td>
                            <?php echo '<td><img Style="width:300px; height:100px" src="/' . $data[$i]['Images'] . '" > </td>' ?>                            
                            
                            <?php  
                            ?>
                            <td>
                                <button type="button" class="btn pull-left btn-outline-danger"><a style="text-decoration: none; color:black;" href="Banner.php?delete=<?php echo $data[$i]['Id'] ?>">Delete</a></button>
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