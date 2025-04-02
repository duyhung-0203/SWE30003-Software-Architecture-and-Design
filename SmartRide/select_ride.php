<?php
require_once 'models/User.php';
require_once 'models/Passenger.php';
require_once 'models/Driver.php';
require_once 'models/Ride.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
} else {
    $user = $_SESSION['user'];
}

$rides = Ride::getPendingRides();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a ride</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/driver.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script defer src="assets/js/selectRide.js"></script>


</head>


<body>
    <div class="container">
        <div class="selection-box">
            <h1>Hello <?php echo $user->getName() ?></h1>
            <p><a href="driver_dashboard.php">Back</a></p>
            <h2>Select Ride</h2>

            <?php if (!empty($rides)): ?>
                <div class="ride-list">
                    <table>
                        <thead>
                            <tr>
                                <th>Passenger Name</th>
                                <th>Pickup Address</th>
                                <th>Dropoff Address</th>
                                <th>Fare</th>
                                <th>Distance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rides as $ride): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ride['passenger_name']); ?></td>
                                    <td><?php echo htmlspecialchars($ride['pickup_address']); ?></td>
                                    <td><?php echo htmlspecialchars($ride['dropoff_address']); ?></td>
                                    <td>$<?php echo htmlspecialchars($ride['fare']); ?></td>
                                    <td><?php echo htmlspecialchars($ride['distance']); ?> km</td>

                                    <td>
                                        <button class="action-btn"
                                            data-rideid="<?php echo htmlspecialchars($ride['ride_id']); ?>"
                                            data-driverid="<?php echo htmlspecialchars($user->getDriverID()); ?>"
                                            data-pickup="<?php echo htmlspecialchars($ride['pickup_address']); ?>"
                                            data-dropoff="<?php echo htmlspecialchars($ride['dropoff_address']); ?>">
                                            Accept
                                        </button>
                                    </td>


                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No ride available.</p>
            <?php endif; ?>


        </div>
    </div>


</body>

</html>