<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   Reset.php :-  Passowrd reset page                --------->


<?php
session_start();
include "/var/www/Medibazaaradmin/functions.php";

if( isset($_POST['Resetbtn'])) {
 send_otp();
 $usererrormsg= $_SESSION['usererrormsg'];

} 

if (!isset($_SESSION['verificationcode'])) {
    $_SESSION['verificationcode'] = false;
}



$verifiction= $_SESSION['verificationcode'];	
$userEmail= $_SESSION['UserEmail'];


if (isset($_POST['verifyotp'])){
	$otp = $_POST['OTP'];

	 if ($otp == $_SESSION['otp']) {
		$verifiedOTP=true;

		unset($_SESSION['otp']);
	}	
} 

if( isset($_POST['update'])) {
	 
	updatepassword($userEmail);

}

if( isset($_POST['resendOtpBtn'])) {
    
    resend_otp_function($userEmail);
}
?>



<head>




<title>
        Medibazaar: Reset Password
    </title>
	<meta name="description" content="Medibazaar.shop trusted online pharmacy/Medical. Buy prescription medicines, OTC drugs, and health products online with fast delivery and affordable prices. Shop now!">
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
            
			<?php if ($verifiction == false && $verifiedOTP==false) { ?>
			<form class="login100-form validate-form"  id="loginform" role="form" method="post" action="Reset">
					<span class="login100-form-title p-b-49">
						Reset Password
					</span>            
					<div class="txt1 text-center p-t-10 p-b-20" style="color: Red; font-size: 15px; font-weight:bold">
                    <?php echo $usererrormsg; ?>
														
					</div>
					
					<div class="wrap-input100 validate-input m-b-23" data-validate = "Email address is required">
						<span class="label-input100">Email Address</span>
						<input class="input100" type="text" name="userEmail" placeholder="Type your email address" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/;.test(this.value)) this.value = ''; " maxlength="50">
						<span class="focus-input100" data-symbol="&#128231;" style="color: black !important;"></span>

					</div>							
					<br>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" name="Resetbtn">
								Send Verification Code
							</button>
						</div>				
				</form>
				<?php } ?>

				<?php if ($verifiction == true && $verifiedOTP==false) { ?>
										
					<!-- Form for verifying OTP -->
					<form class="login100-form validate-form" id="verifyForm" role="form" method="post" action="Reset">
							<span class="login100-form-title p-b-49">Verify OTP</span>            

							<div class="wrap-input100 validate-input m-b-23" data-validate="Email address is required">
								<span class="label-input100">Email Address</span>
								<input class="input100" type="text" name="userEmail" value="<?php echo $userEmail ?>" disabled>
								<span class="focus-input100" data-symbol="&#128231;" style="color: black !important;"></span>
							</div>        

							<div class="wrap-input100 validate-input" data-validate="Verification code is required">
								<span class="label-input100">Verification Code</span>
								<input class="input100" type="OTP" name="OTP" placeholder="Verification Code">
								<span class="focus-input100" data-symbol="&#xf190;"></span>
							</div>

							<br>
							<div class="container-login100-form-btn">
								<div class="wrap-login100-form-btn">
									<div class="login100-form-bgbtn"></div>
									<button class="login100-form-btn" type="submit" name="verifyotp">Verify </button>
								</div>
							</div>
						</form>

						<br>
						
						<form class="login100-form " id="verifyForm" role="form" method="post" action="Reset">

								<input class="input100" type="hidden" name="userEmail" value="<?php echo $userEmail ?>" disabled>
								
							        

							<div class="container-login100-form-btn">
								<div class="wrap-login100-form-btn">
									<div class="login100-form-bgbtn"></div>
									<button class="login100-form-btn" type="submit" name="resendOtpBtn">Resend Verification Code</button>
								</div>
							</div>
						</form>
						  		
					
					<?php } ?>
					
					<?php if ($verifiction == true && $verifiedOTP==true) { ?>
					
					<form class="login100-form validate-form"  id="loginform" role="form" method="post" action="Reset">
					<span class="login100-form-title p-b-49">
						Update Password
					</span>            

					<div class="wrap-input100 validate-input m-b-23" data-validate = "Email address is required">
						<span class="label-input100">Email Address</span>
						<input class="input100" type="text" name="userEmail" value="<?php echo $userEmail?>" disabled>
						<span class="focus-input100" data-symbol="&#128231;" style="color: black !important;"></span>

					</div>		
					
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="Password" name="password" placeholder="Create New Passwrod">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<br>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" name="update">
								Update
							</button>
					</div>
					</div>
					</form>
					<?php } ?>

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