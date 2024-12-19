<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Cate.php :-  View prescription by button            --------->
<?php
include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php"
    ?>


    <?php
    include "includes/sidebar.php";
    
    // Retrieve the image file name from the URL parameter
    if (isset($_GET['image'])) {
        $imageFileName = $_GET['image'];
    ?>
    
        <img style="display: block; margin: 0 auto;" src="<?php echo '/'.$imageFileName; ?>" alt="Image" />
    <?php
    } else {
        echo "Image not found.";
    
    }
    include "includes/footer.php"
    ?>
</body>