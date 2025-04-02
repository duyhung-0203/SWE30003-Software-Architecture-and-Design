<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Select Role</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/select_role.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h1 class="brand">SmartRide</h1>
            <h2>Select your Role</h2>

            <form method="GET" action="register.php">
                <div class="role-options">
                    <button type="submit" name="role" value="passenger" class="role-btn">🧍 Passenger</button>
                    <button type="submit" name="role" value="driver" class="role-btn">🚗 Driver</button>
                </div>
            </form>

            <!-- Back to Login Button -->
            <div class="back-button">
                <a href="index.php">← Back to Login</a>
            </div>
        </div>
    </div>
</body>

</html>