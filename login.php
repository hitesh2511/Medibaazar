<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   login.php :-  Login page                 --------->

<?php
session_start();
include "/var/www/Medibazaaradmin/functions.php";
login();
?>

<head>




<title>
        Medibazaar: Login
    </title>
	<meta name="description" content="Medibazaar.shop is trusted online pharmacy. Buy prescription medicines, OTC drugs, and health products online with fast delivery and affordable prices. Shop now!">
    <meta name="keywords" content="buy medicines online, prescription medicines, OTC drugs, health products">
    <link rel="icon" href="../Logo.ico" type="image/x-icon">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--===============================================================================================-->	

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	
<head>
<style>
    .focus-input100 {
        color: black !important; /* Set the color explicitly */
    }
</style>


<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
            <?php

            message();

                ?>
            <form class="login100-form validate-form"  id="loginform" role="form" method="post" action="login">
					<span class="login100-form-title p-b-49">
						Login
					</span>            

					<div class="wrap-input100 validate-input m-b-23" data-validate = "Phone No or Email Id is reauired">
						<span class="label-input100">User Name</span>
						<input class="input100" type="text" name="userEmail" placeholder="Type your Phone No or Email Id" >
						<span class="focus-input100" data-symbol="&#x1F464;" style="color: black !important;"></span>

					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Type your password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="text-right p-t-8 p-b-31">
						<a href="Reset">
							Forgot password?
						</a>
					</div>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" name="login">
								Login
							</button>
						</div>
					

					<div class="txt1 text-center p-t-54 p-b-20">
                    
						<a href="signUp">
                        Don't have an account? Sign up here.
						</a>
					                    
                </div>

				<div class="txt1 text-center p-t-54 p-b-20">
                    
					
					By continuing, you agree with our <a href="Policy" style="color: black; text-decoration:underline;">Privacy Policy</a> and <a href="Conditions" style="color: black; text-decoration:underline;">Terms and Conditions</a>
					

				</div>
				
				<div class="txt1 text-center" style="color:darkgreen;">
                    
					
					<b>Note:- User Name is your phone number or email id. </b> 
					

				</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>