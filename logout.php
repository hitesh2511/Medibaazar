<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   logout.php :-  Logout.php                --------->

<?php
session_start();
unset($_SESSION['user_id']);
header("Location: index");//use for the redirection to some page  
