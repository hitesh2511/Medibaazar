<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Cate.php :-  logout for admin                 --------->

<?php
session_start();  
session_destroy();
header("Location: login.php");
