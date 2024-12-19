
<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   functions.php :-  All functions that used in Medibaazar except admin
                   SMTP and connection informaion are removed due to Security reasons                --------->


<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//connection username and password 
$connection =mysqli_connect("localhost", "","", "");

 function post_redirect($url)
 {
        ob_start();
        header('Location: ' . $url);
        ob_end_flush();
        die();
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



// Usage example

function get_redirect($url)
{
    echo " <script> 
    window.location.href = '" . $url . "'; 
    </script>";
 
}
function query($query, $params = []) {
    global $connection;
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . mysqli_error($connection));
    }

    if (!empty($params)) {
        // Dynamically bind parameters
        $types = str_repeat('s', count($params)); 
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $data;
    } else {
        throw new Exception("Query execution failed: " . mysqli_stmt_error($stmt));
    }
}

function single_query($query, $params = []) {
    global $connection;
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . mysqli_error($connection));
    }

    if (!empty($params)) {
        // Dynamically bind parameters
        $types = str_repeat('s', count($params)); 
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        return "done";
    } else {
        throw new Exception("Query execution failed: " . mysqli_stmt_error($stmt));
    }
}

function addToCart($product_id, $quantity) {
    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product already exists in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // Update the quantity
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Add the product to the cart
        $_SESSION['cart'][$product_id] = [
            'product_id' => $product_id,
            'quantity' => $quantity
        ];
    }
}

function getAllPhoneNumbers() {
    global $encryptionKey,$connection;
    // The SQL query to select the Phone_No field from the user table
    $query = "SELECT Phone_No FROM user";
    
    // Execute the query and get the result
    $result = $connection->query($query);

    // Check for errors in the query
    if (!$result) {
        die("Error in query: " . $connection->error);
    }

    // An array to store all phone numbers
    $phoneNumbers = [];

    // Fetch each row from the query results
    while ($row = $result->fetch_assoc()) {
        // Add the decrypted Phone_No to the array
        $phoneNumbers[] = $row['Phone_No'];
    }

    // Return the array of phone numbers
    return $phoneNumbers;
}



function login() {
    if (isset($_POST['login'])) {
        global $encryptionKey, $connection;

        $inputEmail = strtolower(trim($_POST['userEmail']));
        $inputPassword = trim($_POST['password']);

        // Prepare the SQL statement to retrieve user data
        $stmt = $connection->prepare("SELECT Phone_No, user_id, Email_id, user_password FROM user");
        $stmt->execute();
        $result = $stmt->get_result();

        // Check each user in the database
        while ($userData = $result->fetch_assoc()) {
            // Decrypt the email address
            $decryptedPhone = decryptData($userData['Phone_No'], $encryptionKey);
            $decryptedEmail = decryptData($userData['Email_id'], $encryptionKey);

            // Compare decrypted email with user input
            if ($inputEmail == $decryptedEmail || $inputEmail == $decryptedPhone) {
                // Verify password
                if (password_verify($inputPassword, $userData['user_password'])) {
                    // Set session and redirect on successful login
                    $_SESSION['user_id'] = $userData['user_id'];
                    unset($_SESSION['cart']);
                    header("Location: index");
                    exit;
                } else {
                    // Password does not match
                    $_SESSION['message'] = "loginErr";
                    header("Location: login");
                    exit;
                }
            }
        }

        // If no user is found with the email
        $_SESSION['message'] = "loginErr";
        header("Location: login");
        exit;
    }
}


function signUp()
{

    error_reporting(E_ALL); 
    ini_set('display_errors', 1);

    if (isset($_POST['singUp'])) {
        global $encryptionKey;
        
        $query = "SELECT Pin_code FROM pin_code";
        $data = query($query);
        $pincdoe= trim($_POST['pincodetext']); 
        $pinFound = false;

        $userdataquery = "SELECT Email_id,Phone_No FROM user";
        $userdata = query($userdataquery);
        $userfound= false;
        $loweremail=strtolower(trim($_POST['useremail']));

        $userphoneno=trim($_POST['userPhoneNo']);
        foreach($userdata as $row){
            $useremailid= decryptData($row['Email_id'],$encryptionKey);
            $phoneno= decryptData($row['Phone_No'],$encryptionKey);
            if ( $phoneno==$userphoneno || $useremailid==$loweremail ) {
            $userfound = true;
            break;
            }
        }
    if($userfound==true){        
        $_SESSION['message'] = "usedEmail";
        post_redirect("signUp.php");  
        session_destroy();
        return;
    }else if($userfound==false){

    foreach($data as $row){
        $pin = $row['Pin_code'];
        if ( $pin==$pincdoe) {
        $pinFound = true;
        break;
        }
    }



    if ($pinFound==true) {            
        global $encryptionKey;
        $email  = encryptData(trim($_POST['userPhoneNo']), $encryptionKey);
        $fname  = encryptData(trim($_POST['Fname']), $encryptionKey);
        $lname = encryptData(trim($_POST['Lname']), $encryptionKey);
        
        $useremail = encryptData($loweremail, $encryptionKey); 
        $address = encryptData(trim($_POST['address']), $encryptionKey);
        $withoutencryptemail= trim($_POST['userPhoneNo']);
        $passwd = trim($_POST['passwd']); 
        if (empty($email) or empty($passwd) or empty($address) or empty($fname) or empty($lname) or empty($useremail) ) {
            $_SESSION['message'] = "empty_err";
            post_redirect("signUp");
            return;
        } elseif (!preg_match('/^\d+$/', $withoutencryptemail)) {
            $_SESSION['message'] = "signup_err_email";
            post_redirect("signUp");
            error_reporting(E_ALL); ini_set('display_errors', 1);
            return;
        } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $passwd)) {
            $_SESSION['message'] = "signup_err_password";
            post_redirect("signUp");
            error_reporting(E_ALL); ini_set('display_errors', 1);
            return;
        }

        // Check if email is already used
        global $connection;
        

        

        // Hash the password
        $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);

        // Insert user into database
        $query = "INSERT INTO user (Phone_No, user_fname, user_lname, user_address, user_password, Location, Pin_code, Email_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $location = null;        
        $stmt->bind_param("ssssssss", $email, $fname, $lname, $address, $hashedPassword, $location, $pincdoe, $useremail);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            post_redirect("location");
        } else {
            $_SESSION['message'] = "wentWrong";
            error_reporting(E_ALL); ini_set('display_errors', 1);
            return;
        }
             
    } else {
        // $pin is empty or contains non-numeric characters
        post_redirect("Pincode");

        }  
    }
 }
 
}



function message()
{
    if (isset($_SESSION['message'])) {
        if ($_SESSION['message'] == "signup_err_password") {
            echo "   <div class='alert alert-danger' role='alert'>
        Please enter the password in correct form !!
      </div>";
            unset($_SESSION['message']);
        } elseif ($_SESSION['message'] == "loginErr") {
            echo "   <div class='alert alert-danger' role='alert'>
        Invalid user name or password. Please try again.
      </div>";
            unset($_SESSION['message']);
        } elseif ($_SESSION['message'] == "usedEmail") {
            echo "   <div class='alert alert-danger' role='alert'>
        This Phone No or Email id is already used !!
      </div>";
            unset($_SESSION['message']);
        } elseif ($_SESSION['message'] == "wentWrong") {
            echo "   <div class='alert alert-danger' role='alert'>
        Something went wrong !!
      </div>";
            unset($_SESSION['message']);
        } elseif ($_SESSION['message'] == "empty_err") {
            echo "   <div class='alert alert-danger' role='alert'>
        Please don't leave anything empty !!
      </div>";
            unset($_SESSION['message']);
        } elseif ($_SESSION['message'] == "signup_err_email") {
            echo "   <div class='alert alert-danger' role='alert'>
        Invalid user name or password. Please try again.
      </div>";
            unset($_SESSION['message']);
        }
    }
}
function search()
{
    if (isset($_GET['search'])) {
        $search_text = trim($_GET['search_text']);
        if (empty($search_text)) {
            return;
        }
        $query = "SELECT * FROM item WHERE item_tags LIKE '%$search_text%' or Trim(Composition) LIKE '%$search_text%'" ;
        $data = query($query);
        $compositon =Trim($data[0]['Composition']);
        $found = true;
        $words = explode(",", $compositon);
        foreach ($words as $word) {
            if (strcasecmp($word, $search_text) == 0) {
                $found = false;
                break;
            }
        }

        if (!empty($compositon) && ($found)){        
        $query = "SELECT * FROM item WHERE item_tags LIKE '%$search_text%' Or Trim(Composition) LIKE '%$compositon%'"  ;
        $data = query($query);        
        }
        return $data;

    } elseif (isset($_GET['cat'])) {
        $cat = $_GET['cat'];
        $query = "SELECT * FROM item WHERE item_cat='$cat' ORDER BY RAND()";
        $data = query($query);
        return $data;
    }
}


function all_products()
{
    $query = "SELECT * FROM item ORDER BY RAND()";
    $data = query($query);
    return $data;
}
function total_price($data)
{
    $sum = 0;
    $num = sizeof($data);
    for ($i = 0; $i < $num; $i++) {
        $sum += $sum += ($data[$i][0]['item_price'] * $_SESSION['cart'][$i]['quantity']);
    }
    return $sum;
}
function get_item()
{
    if (isset($_GET['product_id'])) {
        $_SESSION['item_id'] = $_GET['product_id'];
        $id = $_GET['product_id'];
        $query = "SELECT * FROM item WHERE item_id='$id'";
        $data = query($query);
        return $data;
    }
}
function get_user($id)
{
    $query = "SELECT user_id ,user_fname ,user_lname ,Phone_No ,user_address,Location FROM user WHERE user_id=$id";
    $data = query($query);
    return $data;
    
}
function add_cart($item_id)
{
    $user_id = $_SESSION['user_id'];
    $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

    

    if (isset($_GET['cart']) || isset($_GET['buy'])) {
        $found = false;
        $updated_quantity = $quantity;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $cart_item) {
                if ($cart_item['item_id'] == $item_id) {
                    $_SESSION['cart'][$index]['quantity'] += $quantity;
                    $updated_quantity = $_SESSION['cart'][$index]['quantity'];
                    $found = true;
                    break;
                }
            }
        }

        if (!$found) {
            $new_item = array(
                'user_id' => $user_id,
                'item_id' => $item_id,
                'quantity' => $quantity
            );
            $_SESSION['cart'][] = $new_item;
        }

        // Redirect to the appropriate page after updating cart
        if (isset($_GET['cart'])) {
            get_redirect("product?product_id=" . $item_id);
        } elseif (isset($_GET['buy'])) {
            get_redirect("cart");
        }

        // Return the updated quantity
        return $updated_quantity;
    }

    return 0;
     // Return 0 if nothing is added to the cart
}

function get_cart()
{
    $num = sizeof($_SESSION['cart']);
    if (isset($num)) {
        for ($i = 0; $i < $num; $i++) {
            $item_id = $_SESSION['cart'][$i]['item_id'];
            $query = "SELECT item_id, item_image ,item_title  ,item_quantity ,item_price ,item_brand,RX,MRP,discount_percentage FROM item WHERE item_id='$item_id'";
            $data[$i] = query($query);
        }
        return $data;
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

function get_cat(){
    $query = "SELECT * FROM category";
    $data = query($query); //
    return $data; 
}

function getimages(){
    $query = "SELECT * FROM banner";
    $data = query($query); //
    return $data; 
}

function delete_from_cart()
{
    if (isset($_GET['delete'])) {
        $item_id = $_GET['delete'];
        $num = sizeof($_SESSION['cart']);
        for ($i = 0; $i < $num; $i++) {
            if ($_SESSION['cart'][$i]['item_id'] == $item_id) {
                unset($_SESSION['cart'][$i]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
        get_redirect("cart");
    } elseif (isset($_GET['delete_all'])) {
        unset($_SESSION['cart']);
        get_redirect("cart");
    }
}

function resend_otp_function($email) {
    try {  // Generate OTP
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        
        // Store OTP in session
        $_SESSION['otp'] = $otp;
        
        // Email details
        $to = $email;
        $message = "Dear user,<br><br> your verification code is: <b> $otp </b>. <br><br> Please do not share this code with anyone. <br><br> Thank you for using our service. <br><br> Regards, <br> Medibaazar";
   
        $mail = new PHPMailer(true);
                               
            $mail->isSMTP();
            $mail->Host       =   //smtp server
            $mail->SMTPAuth   = true;                       // Enable SMTP authentication
            $mail->Username   =       //email id  
            $mail->Password   =      //email passowrd
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                    // TCP port to connect to
        
            // Recipients
            $mail->setFrom('hiteshkumarnandwani@gmail', 'Hitesh'); //set from emailid 
            $mail->addAddress($to, 'Recipient'); // Add a recipient
        
            // Content
            $mail->isHTML(true);                        // Set email format to HTML
            $mail->Subject = 'Password reset';
            $mail->Body    = $message;    
            $mail->send();
        
            $_SESSION['verificationcode'] = true;
            $_SESSION['UserEmail']=$to;
    } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

function send_otp(){
// send_otp.php
if (isset($_POST['Resetbtn'])) {
    global $encryptionKey;    
    
    

            // Email details
    $to = strtolower($_POST['userEmail']);

     // Convert input email to lowercase
        
    // Fetching emails from the database
    $query = "SELECT Email_id, user_id FROM user";
    $data = query($query);
    $userfound = false;
    $useremail = '';
    
    foreach ($data as $row) {
        $useremail = decryptData($row['Email_id'],$encryptionKey);
        if ($useremail == $to) {            
            $userfound = true;                               
            break;
            
        }
    }

    if ($userfound==true) {
             session_start();       
            // Generate OTP
            $otp = rand(100000, 999999); // Generate a 6-digit OTP
            
            $_SESSION['otp'] = $otp;
            // Store OTP in session
            $message = "Dear user,<br><br> your verification code is: <b> $otp </b>. <br><br> Please do not share this code with anyone. <br><br> Thank you for using our service. <br><br> Regards, <br> Medibaazar";

            $mail = new PHPMailer(true);
                                
                $mail->isSMTP();
                $mail->Host       =            // SMTP server
                $mail->SMTPAuth   = true;                       // Enable SMTP authentication
                $mail->Username   = 'Hiteshkumarnandwani@gmail.com';  // email address
                $mail->Password   =       // email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                    // TCP port to connect to

                // Recipients
                $mail->setFrom('Hiteshkumarnandwani@gmail.com', 'Hitesh'); //set from email 
                $mail->addAddress($to, 'Recipient'); // Add a recipient

                // Content
                $mail->isHTML(true);                        // Set email format to HTML
                $mail->Subject = 'Password reset';
                $mail->Body    = $message;    
                $mail->send();

                $_SESSION['verificationcode'] = true;
                $_SESSION['UserEmail']=$to;
            }

             else if($userfound==false) {
            session_start();
            $_SESSION['usererrormsg'] = "User not found. Please verify your information and try again."; //user not found
        }
    }

}


function add_order()
{    $user_id = $_SESSION['user_id'];
        if (empty($user_id)) {        
                get_redirect("login");
            }else{           
    if (isset($_GET['order'])) {
        global $encryptionKey;
        $num = sizeof($_SESSION['cart']);
        $carddata=get_cart();
        $item_count = count($_SESSION['cart']);
        $filename = $_SESSION["filenameonpri"];        
        date_default_timezone_set("Asia/Kolkata");
        $date = new DateTime();
        $date_str = $date->format("Y-m-d H:i:s");
        for ($i = 0; $i < $num; $i++) {        
            $item_id = $_SESSION['cart'][$i]['item_id'];
            $user_id = $_SESSION['cart'][$i]['user_id'];
            $quantity = $_SESSION['cart'][$i]['quantity'];           
            $itemprice = $carddata[$i][0]['item_price'] * $_SESSION['cart'][$i]['quantity'];
            $Shppingcharges=0;
            {if($itemprice<500){
            $Shppingcharges = 50/$item_count; 
            }elseif($itemprice>500){
            $Shppingcharges = 0;
            }}
            $query = "INSERT INTO orders (user_id,item_id,order_quantity,order_date,order_price,Shipping_charges,Prescription) 
                VALUES('$user_id','$item_id','$quantity','$date_str',$itemprice,$Shppingcharges,'$filename')";
                single_query($query);
                $item = get_item_id($item_id); // get item details by id like price
                $new_quantity = $item[0]['item_quantity'] - $quantity;                
                $query1 = "UPDATE item SET item_quantity = ? WHERE item_id = ?";
                try {
                    $result = single_query($query1, [$new_quantity, $item_id]);
                    echo "Query executed successfully: " . $result;
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            
            if ($quantity == 0) {
                return;
            } else {
                
            }
        }
        unset($_SESSION['cart']);
        get_redirect("final");
        
        


    }
}
}

function updatepassword($email) {
    if (isset($_POST['update'])) {
        $inputPassword = trim($_POST['password']);
        global $connection;
        global $encryptionKey;
        
        $email = strtolower($email); // Convert input email to lowercase
        
        // Fetching emails from the database
        $query = "SELECT Email_id, user_id FROM user";
        $data = query($query);
        $userfound = false;
        $useremail = '';
        
        foreach ($data as $row) {
            $useremail = decryptData($row['Email_id'],$encryptionKey);
            if ($useremail == $email) {
                $user_id=$row['user_id'];
                $userfound = true;                               
                break;
                
            }
        }

        if ($userfound==true) {
            // Hash the new password
            $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);
            
            // Prepare the update statement
            $stmt = mysqli_prepare($connection, "UPDATE user SET user_password = ? WHERE user_id = ?");
            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $user_id);
                
                // Execute the update statement
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION = [];

                    // Destroy the session
                    session_destroy();
                    get_redirect("Update");                                        
                    
                } else {
                    // Handle query execution error
                    echo "Error executing query: " . mysqli_stmt_error($stmt);
                }
                
                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                // Handle query preparation error
                echo "Error preparing query: " . mysqli_error($connection);
            }
        } else {
            // Handle user not found case
            echo "User not found";
        }
    }
}


function updatelocation() {
    if (isset($_POST['updatelocation'])) {
        global $connection;
        $lng = $_SESSION["lng"];
        $lat = $_SESSION["lat"]; 
        $userid = $_SESSION["user_id"];

        // Prepare the update statement
        $stmt = mysqli_prepare($connection, "UPDATE user SET Location = CONCAT('$lat', ',', '$lng') WHERE user_id = ?");

        // Bind parameter
        mysqli_stmt_bind_param($stmt, "i", $userid);

        // Execute the update statement
        if (mysqli_stmt_execute($stmt)) {
            get_redirect("index");
        } else {
            echo "Please enable your location";
        }
    }
}
function add_order_prescription()
{   
    
    $user_id = $_SESSION['user_id'];     
    
    if (empty($userid)){
        get_redirect("login");
    }else{
        $filename = $_SESSION["filename"];
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d H:i");
                      
        
                $query = "INSERT INTO order_by_prescription (user_id,order_date,Prescription) 
                VALUES('$user_id','$date','$filename')";
                single_query($query);
                
        

        get_redirect("final");
    }
}

function check_user($id)
{
    $query = "SELECT user_id FROM user where user_id='$id'";
    $row = query($query);
    if (empty($row)) {
        return 0;
    } else {
        return 1;
    }
}
function get_item_id($id)
{
    $query = "SELECT * FROM item WHERE item_id= '$id'";
    $data = query($query);
    return $data;
}

function Myorder($id)
{
    if ($id==null){
    return 0;
    }else{
        $query = "SELECT * FROM orders WHERE user_id='$id' ORDER BY order_date DESC";            
        $data = query($query);
        return $data;        
    }
}
