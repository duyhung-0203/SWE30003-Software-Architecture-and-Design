<?php
require_once 'models/User.php';
require_once 'models/Passenger.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
} else {
    $user = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a ride</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/passenger.css">
    <link rel="stylesheet" href="assets/css/bookRide.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script defer src="assets/js/bookRide.js"></script>

</head>

<body>
    <div class="container">
        <div class="selection-box">
            <h1>Hello <?php echo $user->getName() ?></h1>
            <p><a href="passenger_dashboard.php">Back</a></p>

            <div class="inputs">
                <input type="text" id="start" placeholder="Enter start location" />
                <input type="text" id="end" placeholder="Enter end location" />
                <button onclick="showRoute()">Show Route</button>
            </div>
            <div id="map"></div>
            <div id="fare"> </div>
            <button type="submit" id="bookButton">Book</button>
            <a id="update" href="tracking_passenger.php">update</a>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Routing Machine -->
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

</body>

</html>