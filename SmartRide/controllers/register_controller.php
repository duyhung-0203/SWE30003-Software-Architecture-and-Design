<?php
// controllers/register_controller.php
require_once '../models/User.php';
require_once '../models/Driver.php';
require_once '../models/Passenger.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

$response = ['success' => false];

$user = new User($name, $email, $password);
$verifyEmail = $user->verifyEmail();


if (empty($verifyEmail['email'])) { 
    $userID = $user->create();

    if ($role == 'driver') {
        $driver = new Driver($name, $email, $password);
        $createDriver = $driver->createDriver();
    } else if ($role == 'passenger') {
        $passenger = new Passenger($name, $email, $password);
        $createPassenger = $passenger->createPassenger();
    }

    $response = ['success' => true];
}

header('Content-Type: application/json');
echo json_encode($response);


