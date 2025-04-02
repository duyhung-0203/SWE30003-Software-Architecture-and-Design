<?php
require_once '../models/Location.php';
require_once '../models/RideRequest.php';
require_once '../models/User.php';
require_once '../models/Passenger.php';
require_once '../models/Driver.php';
require_once '../models/Ride.php';


session_start();
$user = $_SESSION['user'];
$rideID = $_SESSION['rideID'];
$status = $_POST['status'];

$response = ['success' => false];

$ride = new Ride($user->getDriverID(), $rideID, $status);

$completeRide = $ride->completeRide();

if ($completeRide) {
    $response = ['success' => true];
}


header('Content-Type: application/json');
echo json_encode($response);