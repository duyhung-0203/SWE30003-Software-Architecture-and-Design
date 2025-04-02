<?php
require_once '../models/Location.php';
require_once '../models/RideRequest.php';
require_once '../models/User.php';
require_once '../models/Passenger.php';

session_start();
$user = $_SESSION['user'];

$pickup_location = $_POST['pickup'];
$dropoff_location = $_POST['dropoff'];
$startLat = $_POST['startLat'];
$startLon = $_POST['startLon'];
$endLat = $_POST['endLat'];
$endLon = $_POST['endLon'];
$fare = $_POST['fare'];
$distance = $_POST['distance'];

// $pickup_location = 'A';
// $dropoff_location = 'B';
// $startLat = 100;
// $startLon = 100;
// $endLat = 10;
// $endLon = 10 ;
// $fare = 7.24;
// $distance = 10;


$response = ['success' => false];



$location = new Location($pickup_location, $dropoff_location, $distance, $startLat, $startLon, $endLat, $endLon);
$locationID = $location->createLocation();

$createRequest = new RideRequest($user, $locationID, $fare, "pending");
$rideRequestID = $createRequest->createRideRequest();


if (!empty($rideRequestID)) {
    $_SESSION['pickup'] = $pickup_location;
    $_SESSION['dropoff'] = $dropoff_location;
    $_SESSION['rideID'] = $rideRequestID;
    $response = ['success' => true];
}

header('Content-Type: application/json');
echo json_encode($response);