<?php
require_once 'models/User.php';
require_once 'models/Driver.php';
require_once 'models/Passenger.php';
require_once 'models/RideRequest.php';
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['pickup']) && !isset($_SESSION['dropoff']) && !isset($_SESSION['rideID'])) {
    header('Location: index.php');
    exit;
} else {
    $user = $_SESSION['user'];
    $pickup = $_SESSION['pickup'];
    $dropoff = $_SESSION['dropoff'];
    $rideID = $_SESSION['rideID'];

    $status = RideRequest::checkRideStatus((int)$rideID);
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
    <link rel="stylesheet" href="assets/css/tracking.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script defer src="assets/js/tracking_passenger.js"></script>

</head>

<body>
    <div class="container">
        <div class="selection-box">
            <h1>Hello <?php echo $user->getName() ?></h1>

            <!-- Use single quotes for the onclick attribute -->
            <button id="route"
                onclick='showMap(<?php echo json_encode($pickup); ?>, <?php echo json_encode($dropoff); ?>)'>
                Track driver
            </button>

            <div id="map"></div>
            <div id="fare"> </div>
            <div id="status">
                <?php if($status == 'in_progress'): ?>
                    <h2>Waiting for driver...</h2>
                <?php elseif($status == 'completed'): ?>
                    <h2>Go to Payment</h2>
                <?php endif ?>
            </div>
            <button type="submit" id="updateButton" rideID="<?php echo (int)$rideID?>">Update</button>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Routing Machine -->
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

</body>

</html>