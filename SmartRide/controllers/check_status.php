<?php
require_once '../models/Location.php';
require_once '../models/RideRequest.php';
require_once '../models/User.php';
require_once '../models/Passenger.php';


$rideID = $_POST['rideID'];

$response = ['success' => false];

$status = RideRequest::checkRideStatus((int)$rideID);

if ($status == 'completed') {
    $response = ['success' => true];
}

header('Content-Type: application/json');
echo json_encode($response);