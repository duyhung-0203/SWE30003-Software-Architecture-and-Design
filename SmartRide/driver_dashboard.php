<?php
require_once 'models/User.php';
require_once 'models/Driver.php';
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
    <title>Driver</title>

    <link rel="stylesheet" href="assets/css/driver.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <div class="container">
        <div class="selection-box">
            <h1>Hello <?php echo $user->getName() ?></h1>
            <div class="navigation">
                <a href="select_ride.php">Rides</a>
                <a href="">History</a>
            </div>
            <a class="logout" href="controllers/logout.php">logout</a>
        </div>
    </div>
</body>

</html>