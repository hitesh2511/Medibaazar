<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   location.php :-  set the location of user                 
                   MAPMyinda API Src is removed due to security reason --------->


<?php
session_start();
include "/var/www/Medibazaaradmin/functions.php"; 
updatelocation();
?>

<head>
    <title>
      Medibazaar
    </title>

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
<!--===============================================================================================-->
  
  <script src=""></script><!-- Here need to add MapmyIndia JavaScript API -->

  <style>
    #map {
        height: 400px;
    }
</style>

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
        
            <form method="post">
            <span class="login100-form-title p-b-20" style="font-size: 20px; font-weight: bold;">
						Select Your Current Location
			</span>
            </from>                         
    <div id="map">
    </div>
    <br>
    <div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" name="updatelocation">
								Select
							</button>
						</div>
                        <script>
        navigator.geolocation.getCurrentPosition(showPosition);

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;    
            var map = new MapmyIndia.Map("map", { center: [latitude, longitude], zoomControl: true, hybrid: true, search: true, location: true }); 

            // Initial AJAX request to set session variables
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "location.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText); // Log the response from the PHP script
                }
            };
            xhr.send("latitude=" + latitude + "&longitude=" + longitude);

            // Latitude, Longitude set
            var LatLng = [
                ["Current Location", latitude, longitude],        
            ];

            // Iterate on size of latitude longitude set and add marker
            for (var i = 0; i < LatLng.length; i++) {
                var marker = new L.marker([LatLng[i][1], LatLng[i][2]], { draggable: true })
                    .bindPopup(LatLng[i][0])
                    .addTo(map);

                // Event listener for marker drag end
                marker.on('dragend', function(e) {
                    var newLatLng = e.target.getLatLng();
                    console.log('Marker moved to: ' + newLatLng.lat + ', ' + newLatLng.lng);
                    
                    // AJAX request to update session variables
                    var xhrUpdate = new XMLHttpRequest();
                    xhrUpdate.open("POST", "location.php", true);
                    xhrUpdate.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhrUpdate.onreadystatechange = function() {
                        if (xhrUpdate.readyState === 4 && xhrUpdate.status === 200) {
                            console.log(xhrUpdate.responseText); // Log the response from the PHP script
                        }
                    };
                    xhrUpdate.send("latitude=" + newLatLng.lat + "&longitude=" + newLatLng.lng);
                });
            }
        }
</script>
 <?php
 
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["latitude"]) && isset($_POST["longitude"])) {
        $_SESSION["lat"] = $_POST["latitude"];
        $_SESSION["lng"] = $_POST["longitude"];
        echo "Session variables updated successfully.";
    } else {
        echo "Latitude and longitude parameters are missing.";
    }
}
 ?>

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