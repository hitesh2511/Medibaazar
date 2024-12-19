<!---------------- Developer Name:- Hitesh Kumar Nandwani 
                   get_zip.php :-  Retrive the zipcode by longitude and latitude then send to home page --------->


<?php
// Define latitude and longitude
$latitude = $_GET['lat'];
$longitude = $_GET['lon'];

// Construct the URL for reverse geocoding
$url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=$latitude&lon=$longitude";

// Create stream context with user-agent header
$options = [
    'http' => [
        'header' => 'User-Agent: MyGeocodingApp/1.0'
    ]
];
$context = stream_context_create($options);

// Make a GET request to the Nominatim API with the stream context
$response = file_get_contents($url, false, $context);

// Check if the response is successful
if ($response !== false) {
    // Parse the JSON response
    $data = json_decode($response);

    // Check if the response contains address details
    if (isset($data->address)) {
        // Retrieve the postal code from the address components
        $postal_code = isset($data->address->postcode) ? $data->address->postcode : 'Postal code not found';
        session_start();
        $_SESSION['postal_code'] = $postal_code;
        header("Location: index");
         exit();
        // Output the postal code
    } else {
        echo "Address details not found";
    }
} else {
    echo "Failed to fetch data from the Nominatim API";
}
?>
