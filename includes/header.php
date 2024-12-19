<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Header.php :-  Headers                --------->


<head>
<link href="/css/main.css" rel="stylesheet">
<style>


/* Popup CSS */
    .popup {
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        display: none;
    }
    .popup-content {
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888888;
        width: 60%; /* Default width */
        max-width: 400px; /* Maximum width */
        font-weight: bolder;
    }
    .popup-content button {
        display: block;
        margin: 0 auto;
    }
    .show {
        display: block;
    }

    .navbar {
  background-color: #00a6a7; /* Set the background color for the navbar */
    }
    /* Responsive Styles */
    @media only screen and (max-width: 768px) {
    .d-flex{
        width: 45%;

    }
    #d-flex1{
        width: 100% !important;

    }
        .navbar-toggler{
        width: 10%;
        display: flex;
       
      }  /* Adjust styles for smaller screens */
        .popup-content {
            width: 80%; /* Adjusted width for smaller screens */
        }
    }
    .or-line {
        position: relative;
        text-align: center;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .or-line span {
        background-color: #fff;
        padding: 0 10px;
    }
    .or-line::before,
    .or-line::after {
        content: "";
        position: absolute;
        top: 50%;
        width: 45%;
        border-top: 1px solid #888888;
    }
    .or-line::before {
        right: 50%;
        margin-right: 10px;
    }
    .or-line::after {
        left: 50%;
        margin-left: 10px;
    }


</style>
</head>
<?php


                $connection =mysqli_connect("localhost", "Nandwani","Hitesh@12345", "Medibaazar");
                // SQL query to retrieve data from a table
                if (!$connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }
// SQL query to retrieve data from a table
$sql = "SELECT * FROM pin_code";

// Execute the query
$result = mysqli_query($connection, $sql);

// Check if the query was successful
if ($result) {
    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
        // Loop through each row of the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Output the data from each row
            $pincode= $row['Pin_code'] ;
            $Location=  $row['Location'] ;
            // Output other columns as needed
        }
    } else {
        echo "No results found";
    }
} else {
    // If the query failed, display an error message
    echo "Error: " . mysqli_error($connection);
}

// Close the connection

?>

            

     
     

<?php


error_reporting(0);
$msg = "";
$_SESSION["filename"] = "";

if (isset($_POST['upload1'])) {
    date_default_timezone_set("Asia/Kolkata");

    // Check if 'user_id' session variable exists and is not empty
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        $msg = "User session not found. Please log in again."; // Set error message
    } else {
        $filename = $_SESSION['user_id'] . "_" . date("d-m-y_H-i-s");
        $extension = pathinfo($_FILES["uploadfile1"]["name"], PATHINFO_EXTENSION);
        $file = $filename . "." . $extension;
        $_SESSION["filename"] = $file;
        $folder = "/home/Prescription/";

        // Check if the destination folder exists and has write permissions
        if (!file_exists($folder)) {
            $msg = "Destination folder does not exist: " . $folder;
        } elseif (!is_writable($folder)) {
            $msg = "Destination folder is not writable: " . $folder;
        } elseif (move_uploaded_file($_FILES["uploadfile1"]["tmp_name"], $folder . $file)) {
            echo '<script>alert("Successfully order placed by precription, We will create your order shortly!!")</script>';
            add_order_prescription();
        } else {
            // Get the specific error message from move_uploaded_file() function
            $msg = "Failed to upload Prescription: " . $_FILES["uploadfile1"]["error"];
        }
    }
}


// Display the message in your HTML
if (!empty($msg)) {
    echo '<script>alert("' . $msg . '")</script>';
}


?>

<body>
<script>
        document.addEventListener("DOMContentLoaded", function() {
            var myButton = document.getElementById("myButton");
            var closePopup = document.getElementById("closePopup");
            var myPopup = document.getElementById("myPopup");

            myButton.addEventListener("click", function () {
                myPopup.classList.add("show");
            });

            closePopup.addEventListener("click", function () {
                myPopup.classList.remove("show");
            });

            window.addEventListener("click", function (event) {
                if (event.target == myPopup) {
                    myPopup.classList.remove("show");
                }
            });
        });
        function getLocation() {
    console.log("getLocation() called");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("Geolocation is not supported by this browser.");
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    console.log("showPosition() called");
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var url = "get_zip?lat=" + latitude + "&lon=" + longitude;
    console.log("Redirecting to: " + url);
    window.location.href = url;
}

function validateSearchForm() {
        var searchInput = document.forms[0]["search_text"].value;
        if (searchInput.trim() === "") {
            document.querySelector('.invalid-feedback').style.display = "block";
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }

 </script>

</body>
<header>


<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #00a6a7;">
        <div class="container-fluid">
            <a href="index" style="font-family: Azonix; font-size:1.3em; color: white; font-weight: bold; text-decoration: none;"> <img src="../images/logoimg.png" id="image">Medibazaar</a>
            <form class="d-flex d-md-none" action="search" method="GET" onsubmit="return validateSearchForm()">
        <input class="form-control me-2" type="search" placeholder="Search" name="search_text" required>    
        <button class="btn btn-outline-light" type="submit" value="go" name="search"><i class="fas fa-search"></i></button>
        </form>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" style="background-color: white; justify-content: center; align-items: center;" aria-expanded="false" aria-label="Toggle navigation">      
            <span class="navbar-toggler-icon"></span>
          </button>
         
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="index" style="color: white; font-weight:bold;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart" style="color: white; font-weight:bold;">Cart</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link  dropdown-toggle " style="color: white; font-weight:bold;" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="color: white; font-weight:bold;">
                        <?php
                        // Define an array of categories 
                         $categories = get_list();

                       // Loop through the categories to generate HTML
                         foreach ($categories as $name ) {
                            echo '<li ><a class="dropdown-item border" style="font-weight:bold;" href="search?cat=' . $name . '">' . $name . '</a></li>';

                         }
                         ?>  
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Myorder" style="color: white; font-weight:bold;">My Orders</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" style="color: white; font-weight:bold;" href="#order" role="button" onclick="document.getElementById('uploadFile1').click()">Order By Prescription
                    </a>
                        <form action="" method="post" enctype="multipart/form-data" style="display: none;">
                        <input type="file" name="uploadfile1"  id="uploadFile1" onchange="document.getElementById('submitBtn').click();" />
                        <button type="submit" name="upload1" id="submitBtn" style="display: none;">Upload File</button>
                        </form>
                        </li>  
                <li class="nav-item">           
                <img src="../images/Locationimg.png" id="image">       
                </li>                    
                <li class="nav-item">                                
                <a href="#" class="nav-link" id="myButton" style="color: white; font-weight: bold; text-decoration: underline;">
                
                
                <?php                            
                      
                        echo "Mansarovar,302020";
                    
                        ?>
                
                </a>                        
       
                </ul>
                
                <?php
                
                if (!isset($_SESSION['user_id'])) {
                    echo "<a class='nav-link' href='login' style='color: white; font-weight:bold;'> Log in</a>";
                } else {
                    $check_user_id = check_user($_SESSION['user_id']);
                    if ($check_user_id == 1) {
                        echo "<a class='nav-link' href='logout' style='color: white; font-weight:bold;'> Log out</a>  ";
                    } else {
                        post_redirect("logout");
                    }
                }
                ?>
                
                <form class="d-flex" action="search" method="GET" onsubmit="return validateSearchForm()">
                <input class="form-control me-2 d-none d-lg-block" type="search" placeholder="Search" name="search_text" required>                
                <button class="btn btn-outline-light d-none d-lg-block" type="submit" value="go" name="search"><i class="fas fa-search"></i></button>
                </form>

            </div>
        </div>
    </nav><br><br>
</header>