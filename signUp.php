<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   signup.php :-  SignUp                 --------->


<?php
session_start();
include "/var/www/Medibazaaradmin/functions.php";
signUp();
?>

<script src="https://apis.mapmyindia.com/advancedmaps/v1/54e130e5877f8ecd4b56399951bf9fca/map_load?v=1.5"></script>

<style>
    #map {
        height: 400px;
    }
</style>


<head>
    <title>
        Medibazaar: Signup
    </title>
    <link rel="icon" href="../Logo.ico" type="image/x-icon">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <head>
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
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
            <?php

            message();

                ?>
            <form class="login100-form validate-form"  id="signupform" role="form" method="post" action="signUp">
					<span class="login100-form-title p-b-20">
						Signup
					</span>            
                    <div class="wrap-input100 validate-input m-b-23" data-validate = "Phone No is reauired">
						<span class="label-input100">Phone No</span>
						<input class="input100" type="text" name="userPhoneNo" placeholder="Phone No" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); if (!/^\d*$/.test(this.value)) this.value = ''; " maxlength="10">
						<span class="focus-input100" data-symbol="&#9742;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-23" data-validate = "Email ID is reauired">
						<span class="label-input100">Email ID</span>
						<input class="input100" type="text" name="useremail" placeholder="Email ID" >
						<span class="focus-input100" data-symbol="&#128231;"></span>
					</div>                    
		
                    <div class="wrap-input100 validate-input m-b-23" data-validate = "First Name is requried">
						<span class="label-input100">First Name</span>
						<input class="input100" type="text" name="Fname" placeholder="First Name">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate = "Last Name is requried">
						<span class="label-input100">Last Name</span>
						<input class="input100" type="text"  name="Lname" placeholder="Last Name">
						<span  class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
                    
                    <div class="wrap-input100 validate-input m-b-23" data-validate = "Address is requried">
						<span class="label-input100">Address</span>
						<input class="input100" type="text" name="address" placeholder="Address">
						<span class="focus-input100" data-symbol="&#127968;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-23" data-validate = "Pin Code is requried">
						<span class="label-input100">Pin Code</span>
						<input class="input100" type="text" name="pincodetext"  placeholder="Pin code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); if (!/^\d*$/.test(this.value)) this.value = ''; " maxlength="6">
						<span class="focus-input100" data-symbol="&#127968;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Must be 8-30 characters">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="passwd" placeholder="Type your password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
                    
					<br>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" value="Sign Up" name="singUp">
								Sign Up
							</button>
						</div>
					

					<div class="txt1 text-center p-t-54 p-b-20">
                    
						<a href="login">
                        Already have an account? Login here.
						</a>
					                    
                </div>

				<div class="txt1 text-center p-t-54 p-b-20">
                    
					
					By continuing, you agree with our <a href="Policy" style="color: black; text-decoration:underline;">Privacy Policy</a> and <a href="Conditions" style="color: black; text-decoration:underline;">Terms and Conditions</a>
					

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