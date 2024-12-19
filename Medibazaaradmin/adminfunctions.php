<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   adminfunctions.php :-  All functions that used in admin pages 
                   connection informaion is removed due to Security reasons                --------->

    
<?php
//connection
$connection =  mysqli_connect("localhost", "","", "");

function query($query)
{
    global $connection;
    $run = mysqli_query($connection, $query);
    if ($run) {
        while ($row = $run->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        return 0;
    }
}

function get_list(){
    $query = "SELECT * FROM category";
    $data = query($query); 
    
    
    $categories = array();
    foreach ($data as $row) {
        $categories[] = $row['Category'];
    }
    
    return $categories; 
}

$encryptionKey = hex2bin('3B77A7ADACEABB8A5F761B83E65CFB7C6F634FEBF292DC02B9C717B1A1A4B725');

function encryptData($data, $key) {
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encryptedData);
}

function decryptData($encryptedDataWithIv, $key) {
    $encodedData = base64_decode($encryptedDataWithIv);
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($encodedData, 0, $ivLength);
    $encryptedData = substr($encodedData, $ivLength);
    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

    if ($decryptedData === false) {
        while ($msg = openssl_error_string()) {
            echo "OpenSSL Error: $msg\n";
        }
    }

    return $decryptedData;
}



function single_query($query)
{
    global $connection;
    $run = mysqli_query($connection, $query);
    if ($run) {
        return 1;
    } else {
        return 0;
    }
}


function post_redirect($url)
{
    ob_start();
    header('Location: ' . $url);
    ob_end_flush();
    die();
}
function get_redirect($url)
{
    echo " <script> 
    window.location.href = '$url'; 
    </script>";
 
}
function message()
{
    if (@$_SESSION['message'] == "loginErr") {
        echo "   <div class='alert alert-danger' role='alert'>
        There is no account with this email !!!
      </div>";
        unset($_SESSION['message']);
    } elseif (@$_SESSION['message'] == "emailErr") {
        echo "   <div class='alert alert-danger' role='alert'>
        The email address is already taken.  Please choose another
      </div>";
        unset($_SESSION['message']);
    } elseif (@$_SESSION['message'] == "loginErr1") {
        echo "   <div class='alert alert-danger' role='alert'>
        The email or password is wrong!
      </div>";
        unset($_SESSION['message']);
    } elseif (@$_SESSION['message'] == "noResult") {
        echo "   <div class='alert alert-danger' role='alert'>
        There is no user with this phone no .
      </div>";
        unset($_SESSION['message']);
    } elseif (@$_SESSION['message'] == "itemErr") {
        echo "   <div class='alert alert-danger' role='alert'>
        There is a product with the same name .
      </div>";
        unset($_SESSION['message']);
    } elseif (@$_SESSION['message'] == "noResultOrder") {
        echo "   <div class='alert alert-danger' role='alert'>
        There is no order with this ID !!!
      </div>";
        unset($_SESSION['message']);
    } elseif (@$_SESSION['message'] == "noResultItem") {
        echo "   <div class='alert alert-danger' role='alert'>
        There is no product with this name !!!
      </div>";
        unset($_SESSION['message']);
    } elseif (@$_SESSION['message'] == "noResultAdmin") {
        echo "   <div class='alert alert-danger' role='alert'>
        There is no admin with this email !!!
      </div>";
        unset($_SESSION['message']);
    } elseif (@$_SESSION['message'] == "empty_err") {
        echo "   <div class='alert alert-danger' role='alert'>
    please don't leave anything empty !!!
  </div>";
        unset($_SESSION['message']);
    }
}
// messages function (end)
// login function (start)

function Banner(){
    $query = "SELECT * FROM banner";
    $data = query($query);
    return $data;

}

function Category(){
    $query = "SELECT * FROM category";
    $data = query($query);
    return $data;

}

function login() {
    if (isset($_POST['login'])) {
        global $encryptionKey, $connection;

        $inputEmail = strtolower(trim($_POST['adminEmail']));
        $inputPassword = trim($_POST['adminPassword']);

        // Retrieve all user data from the database
        $query = "SELECT admin_email , admin_id , admin_password FROM admin";
        $result = $connection->query($query);
            
        // Check each user in the database
        while ($userData = $result->fetch_assoc()) {
            
            // Decrypt the email address
            $decryptedEmail = decryptData($userData['admin_email'], $encryptionKey);
            $password = decryptData($userData['admin_password'], $encryptionKey);
                
        
            // Compare decrypted email with user input
            if ($inputEmail === $decryptedEmail) {
                
                // Verify password
                if ($inputPassword == $password) {
                    // Set session and redirect on successful login
                    $_SESSION['admin_id'] = $userData['admin_id'];
                    header("Location: index.php");
                    exit;
                } else {
                    // Password does not match
                    $_SESSION['message'] = "loginErr1";
                    
                    header("Location: login.php");
                    exit;
                }
            }else{
                //username not found
                $_SESSION['message'] = "loginErr1";
            }
        }
    }
}


function delete_Banner()
{
    if (isset($_GET['delete'])) {

        $userId = $_GET['delete'];
        $query1 = "select Images FROM banner WHERE ID ='$userId'";
        $data=query($query1); 
        $imgname= $data[0]['Images'];   

        $query = "DELETE FROM banner WHERE ID ='$userId'";
        single_query($query); 
         // Assuming you're passing filename through form or some other means
        $filepath ="/Var/www/html/". $imgname;
        echo '<script>alert("' . $filepath. '")</script>';
        // Check if file exists before attempting to remove it
        if (file_exists($filepath)) {
            // Attempt to remove the file
            if (unlink($filepath)) {
                echo '<script>alert("Image removed successfully")</script>';
            } else {
                echo '<script>alert("Failed to remove image")</script>';
            }
        } else {
            echo '<script>alert("File not found")</script>';
        }        
        get_redirect("Banner.php");
    
    }
}
function delete_category()
{
    if (isset($_GET['delete'])) {
        $userId = $_GET['delete'];

        $query1 = "select Images FROM category WHERE ID ='$userId'";
        $data=query($query1); 
        $imgname= $data[0]['Images'];   

        $query = "DELETE FROM category WHERE ID ='$userId'";
         single_query($query);
        
         $filepath ="/Var/www/html/". $imgname;
         echo '<script>alert("' . $filepath. '")</script>';
         // Check if file exists before attempting to remove it
         if (file_exists($filepath)) {
             // Attempt to remove the file
             if (unlink($filepath)) {
                 echo '<script>alert("Image removed successfully")</script>';
             } else {
                 echo '<script>alert("Failed to remove image")</script>';
             }
         } else {
             echo '<script>alert("File not found")</script>';
         }
         get_redirect("Cate.php");
    }
}

function delete_item()
{
    if (isset($_GET['delete'])) {
        $itemID = $_GET['delete'];
        
        $query1 = "select item_image FROM item WHERE item_id ='$itemID'";
        $data=query($query1); 
        $imgname= $data[0]['item_image'];

        $query = "DELETE FROM item WHERE item_id ='$itemID'";
         single_query($query);
         $filepath ="/Var/www/html/". $imgname;
         echo '<script>alert("' . $filepath. '")</script>';
         // Check if file exists before attempting to remove it
         if (file_exists($filepath)) {
             // Attempt to remove the file
             if (unlink($filepath)) {
                 echo '<script>alert("Image removed successfully")</script>';
             } else {
                 echo '<script>alert("Failed to remove image")</script>';
             }
         } else {
             echo '<script>alert("File not found")</script>';
         }
         
        get_redirect("products.php");
    }
}

// login function (end)


// user functions (start)
function all_users()
{
    $query = "SELECT user_id ,user_fname ,user_lname ,Phone_No,user_address FROM user ";
    $data = query($query);
    return $data;
}
function delete_user()
{
    if (isset($_GET['delete'])) {
        $userId = $_GET['delete'];
        $query = "DELETE FROM user WHERE user_id ='$userId'";
         single_query($query);
        get_redirect("customers.php");
    }
}
function edit_user($id)
{
    if (isset($_POST['update'])) {
        global $encryptionKey;
        $fname = encryptData(trim($_POST['fname']),$encryptionKey);
        $lname = encryptData(trim($_POST['lname']),$encryptionKey);
        $email = encryptData(trim($_POST['email']),$encryptionKey);
        $address = encryptData(trim($_POST['address']),$encryptionKey);
        if (empty($email) or empty($address) or empty($fname) or empty($lname)) {
            $_SESSION['message'] = "empty_err";
            get_redirect("customers.php");
            return;
        }
        $check = check_email_user($email);
        if ($check == 0) {
            $query = "UPDATE user SET Phone_No='$email' ,user_fname='$fname' ,user_lname='$lname' ,user_address='$address' WHERE user_id= '$id'";
            single_query($query);
            get_redirect("customers.php");
        } else {
            $_SESSION['message'] = "emailErr";
            get_redirect("customers.php");
        }
    } elseif (isset($_POST['cancel'])) {
        get_redirect("customers.php");
    }
}
function get_user($id)
{
    $query = "SELECT user_id ,user_fname ,user_lname ,Phone_No,user_address FROM user WHERE user_id=$id";
    $data = query($query);
    return $data;
}
function check_email_user($email)
{
    $query = "SELECT email FROM user WHERE Phone_No='$email'";
    $data = query($query);
    if ($data) {
        return 1;
    } else {
        return 0;
    }
}
function search_user()
{
    global $encryptionKey;

    if (isset($_GET['search_user'])) {
        $phone = $_GET['search_user_Phone'];
        if (empty($phone)) {
            return;
        }
    
        // Query to get all encrypted phone numbers and associated user info
        $query = "SELECT user_id, user_fname, user_lname, Phone_No, user_address FROM user";
        $result = query($query);
    
        $matchingUsers = [];
    
        if ($result) {
            foreach ($result as $row) {
                // Decrypt phone number for each user
                $encryptedPhone = $row['Phone_No'];
                $decryptedPhone = decryptData($encryptedPhone, $encryptionKey);
    
                // Compare with input phone number
                if ($decryptedPhone === $phone) {
                    $matchingUsers[] = $row;
                }
            }
        }
    
        // Return matching user(s) or handle no matches
        if (!empty($matchingUsers)) {
            return $matchingUsers;
        } else {
            $_SESSION['message'] = "noResult";
        }
    }
}
function get_user_details()
{
    if ($_GET['id']) {
        $id = $_GET['id'];
        $query = "SELECT * FROM user WHERE user_id=$id";
        $data = query($query);
        return $data;

    }   
}

function all_items()
{
    $query = "SELECT * FROM item";
    $data = query($query);
    return $data;
}

function edit_item($id)
{
    if (isset($_POST['update'])) {
        $name = trim($_POST['name']);
        $brand = trim($_POST['brand']);
        $cat = trim($_POST['cat']);
        $tags = trim($_POST['tags']);
        $image = trim($_POST['image']);
        $quantity = trim($_POST['quantity']);
        $price = trim($_POST['price']);
        $details = trim($_POST['details']);
        $Composition= trim($_POST['Composition']);
        $MRP= trim($_POST['MRP']);
        $check = check_name($name);
        if (!$check == 0) {
            $query = "UPDATE item SET item_title='$name' ,item_brand='$brand' ,item_cat='$cat' ,
            item_details='$details',item_tags='$tags',Composition='$Composition'
            ,item_image='$image' ,item_quantity='$quantity' ,item_price='$price', MRP='$MRP'  WHERE item_id= '$id'";
            single_query($query);
            get_redirect("products.php");
        } else {
            $_SESSION['message'] = "itemErr";
            get_redirect("products.php");
        }
    } elseif (isset($_POST['cancel'])) {
        get_redirect("products.php");
    }
}
function get_item($id)
{
    $query = "SELECT * FROM item WHERE item_id=$id";
    $data = query($query);
    return $data;
}
function check_name($name)
{
    $query = "SELECT item_title FROM item WHERE item_title='$name'";
    $data = query($query);
    if ($data) {
        return 1;
    } else {
        return 0;
    }
}
function search_item()
{
    if (isset($_GET['search_item'])) {
        $name = trim($_GET['search_item_name']);
        $query = "SELECT * FROM item WHERE item_title LIKE '%$name%'";
        $data = query($query);
        if ($data) {
            return $data;
        } else {
            $_SESSION['message'] = "noResultItem";
            return;
        }
    }
}

function addimage(){
    if (isset($_POST['add'])) {
        $image = $_SESSION["filebannername"];
        
        if (
            empty($image)
        ) {
            $_SESSION['message'] = "empty_err";
            get_redirect("Banner.php");
            return;
        }else{
        
            $query = "INSERT INTO banner (Images) VALUES
            ('images/$image')";
             single_query($query);
            get_redirect("Banner.php");    
    
        }
}

}

function addCategory(){
    if (isset($_POST['add'])) {
        $image =$_SESSION["filecat"];
        $Category = trim($_POST['Category']);
        $Tagline= trim($_POST['Tagline']);
        if (
            empty($image) or empty($Category) or empty($Tagline)    
        ) {
            $_SESSION['message'] = "empty_err";
            get_redirect("Cate.php");
            return;
        }else{
        
            $query = "INSERT INTO category (Images, Tagline, Category) VALUES
            ('images/$image','$Tagline','$Category')";
             single_query($query);
            get_redirect("Cate.php");    
    
        }
}

}





function add_item()
{
    if (isset($_POST['add_item'])) {
        $name = trim($_POST['name']);
        $brand = trim($_POST['brand']);
        $cat = trim($_POST['cat']);
        $tags = trim($_POST['tags']);
        $image = $_SESSION["productimage"] ;
        $Composition=trim($_POST['Composition']);

        $quantity = trim($_POST['quantity']);
        $price = trim($_POST['price']);
        $details = trim($_POST['details']);
        $check = check_name($name);
        if (
            empty($name) or empty($brand) or empty($cat)  or
            empty($tags) or empty($image) or empty($quantity) or empty($price) or empty($details) or empty($Composition)
        ) {
            $_SESSION['message'] = "empty_err";
            get_redirect("products.php");
            return;
        }
        if ($check == 0) {
            $query = "INSERT INTO item (item_title, item_brand, item_cat, item_details, 
            item_tags ,item_image ,item_quantity ,item_price, Composition) VALUES
            ('$name' ,'$brand' ,'$cat' ,'$details' ,'$tags' ,'$image' ,'$quantity' ,'$price','$Composition')";
             single_query($query);
            get_redirect("products.php");
        } else {
            $_SESSION['message'] = "itemErr";
            get_redirect("products.php");
        }
    } elseif (isset($_POST['cancel'])) {
        get_redirect("products.php");
    }
}
function get_item_details()
{
    if ($_GET['id']) {
        $id = $_GET['id'];
        $query = "SELECT * FROM item WHERE item_id=$id";
        $data = query($query);
        return $data;
    }
}
// item functions (end)
// admin functions (start)
function all_admins()
{
    $query = "SELECT admin_id ,admin_fname ,admin_lname ,admin_email  FROM admin";
    $data = query($query);
    return $data;
}
function get_admin($id)
{
    $query = "SELECT admin_id ,admin_fname ,admin_lname ,admin_email  FROM admin WHERE admin_id=$id";
    $data = query($query);
    return $data;
}
function edit_admin($id)
{
    if (isset($_POST['admin_update'])) {
        $fname = trim($_POST['admin_fname']);
        $lname = trim($_POST['admin_lname']);
        $email = trim(strtolower($_POST['admin_email']));
        $password = trim($_POST['admin_password']);
        $check = check_email_admin($email);
        if ($check == 0) {
            $query = "UPDATE admin SET admin_email='$email' ,admin_fname='$fname' ,admin_lname='$lname' ,admin_password='$password'  WHERE admin_id= '$id'";
            single_query($query);
            get_redirect("admin.php");
        } else {
            $_SESSION['message'] = "emailErr";
            get_redirect("admin.php");
        }
    } elseif (isset($_POST['admin_cancel'])) {
        get_redirect("admin.php");
    }
}
function check_email_admin($email)
{
    $query = "SELECT admin_email FROM admin WHERE admin_email='$email'";
    $data = query($query);
    if ($data) {
        return $data;
    } else {
        return 0;
    }
}
function add_admin()
{
    if (isset($_POST['add_admin'])) {
        global $encryptionKey;
        $fname = encryptData(trim($_POST['admin_fname']),$encryptionKey);
        $lname = encryptData(trim($_POST['admin_lname']),$encryptionKey);
        $email = encryptData(trim(strtolower($_POST['admin_email'])),$encryptionKey);
        $password = encryptData(trim($_POST['admin_password']),$encryptionKey);
        $check = check_email_admin($email);
        if ($check == 0) {
            $query = "INSERT INTO admin (admin_fname, admin_lname, admin_email, admin_password) 
            VALUES ('$fname','$lname','$email','$password')";
            single_query($query);
            get_redirect("admin.php");
        } else {
            $_SESSION['message'] = "emailErr";
            get_redirect("admin.php");
        }
    } elseif (isset($_POST['admin_cancel'])) {
        get_redirect("admin.php");
    }
}
function delete_admin()
{
    if (isset($_GET['delete'])) {
        $adminId = $_GET['delete'];
        $query = "DELETE FROM admin WHERE admin_id ='$adminId'";
        single_query($query);
        get_redirect("admin.php");
    }
}
function search_admin()
{
    if (isset($_GET['search_admin'])) {
        $email = trim(strtolower($_GET['search_admin_email']));
        if (empty($email)) {
            return;
        }
        $query = "SELECT admin_id ,admin_fname ,admin_lname ,admin_email FROM admin WHERE admin_email='$email'";
        $data = query($query);
        if ($data) {
            return $data;
        } else {
            $_SESSION['message'] = "noResultAdmin";
            return;
        }
    }
}
function check_admin($id)
{
    $query = "SELECT admin_id FROM admin where admin_id='$id'";
    $row = query($query);
    if (empty($row)) {
        return 0;
    } else {
        return 1;
    }
}


function all_orders()
{
    $query = "SELECT * FROM orders ORDER BY order_date DESC";
    $data = query($query);
    return $data;
}

function all_orders_Pre()
{
    $query = "SELECT * FROM order_by_prescription ORDER BY order_date DESC";
    $data = query($query);
    return $data;
}


function search_order_prescrption()
{
    if (isset($_GET['search_order_prescrption'])) {
        $id = trim($_GET['search_order_id']);
        if (empty($id)) {
            return;
        }
        $query = "SELECT * FROM order_by_prescription WHERE order_id='$id'";
        $data = query($query);
        if ($data) {
            return $data;
        } else {
            $_SESSION['message'] = "noResultOrder";
            return;
        }
    }
}

function search_order()
{
    if (isset($_GET['search_order'])) {
        $id = trim($_GET['search_order_id']);
        if (empty($id)) {
            return;
        }
        $query = "SELECT * FROM orders WHERE order_id='$id'";
        $data = query($query);
        if ($data) {
            return $data;
        } else {
            $_SESSION['message'] = "noResultOrder";
            return;
        }
    }
}
function delete_order()
{
    if (isset($_GET['delete'])) {
        $order_id = $_GET['delete'];
        $query = "DELETE FROM orders WHERE order_id ='$order_id'";
         single_query($query);
        get_redirect("orders.php");
    } elseif (isset($_GET['done'])) {
        $order_id = $_GET['done'];
        $query = "UPDATE orders SET order_status = 1 WHERE order_id='$order_id'";
        single_query($query);
        get_redirect("orders.php");
    } elseif (isset($_GET['undo'])) {
        $order_id = $_GET['undo'];
        $query = "UPDATE orders SET order_status = 0 WHERE order_id='$order_id'";
        single_query($query);
        get_redirect("orders.php");
    } elseif (isset($_GET['Delivered'])) {
    $order_id = $_GET['Delivered'];
    $query = "UPDATE orders SET order_status = 2 WHERE order_id='$order_id'";
    single_query($query);
    get_redirect("orders.php");

    }
}

