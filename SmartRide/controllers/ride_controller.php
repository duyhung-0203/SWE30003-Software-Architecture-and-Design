<?php
require_once '../models/User.php';
require_once '../models/Driver.php';
require_once '../models/Ride.php';

$rideID = $_POST['rideID'];
$driverID = $_POST['driverID'];
$pickup = $_POST['pickup'];
$dropoff = $_POST['dropoff'];

$response = ['success' => false];


$ride = new Ride($driverID, $rideID, 'in_progress');

$startRide = $ride->startRide();

if ($startRide) {
    session_start();
    $_SESSION['pickup'] = $pickup;
    $_SESSION['dropoff'] = $dropoff;
    $_SESSION['rideID'] = $rideID;
    $response = ['success' => true];
}

header('Content-Type: application/json');
echo json_encode($response);