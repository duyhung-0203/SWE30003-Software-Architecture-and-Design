<?php
// controllers/login_controller.php
require_once '../models/User.php';
require_once '../models/Driver.php';
require_once '../models/Passenger.php';

$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// $email = 'test@gmail.com';
// $password = '123';
// $role = 'driver';

$response = ["success" => false];

if ($role == 'driver') {
    $driver = new Driver("", $email, $password);
    $user = $driver->authenticateDriver();
} else if ($role == 'passenger') {
    $passenger = new Passenger("", $email, $password);
    $user = $passenger->authenticatePassenger();
}

if (!empty($user)) {
    session_start();

    $response = ["success" => true];
    $_SESSION['user'] = $user;
}

header('Content-Type: application/json');
echo json_encode($response);


