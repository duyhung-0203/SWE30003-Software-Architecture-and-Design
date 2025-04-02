<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SmartRide Login</title>
    <!-- css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/register.css">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script src="assets/JS/login.js" defer></script>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h1 class="brand">SmartRide</h1>
            <h2>Log In</h2>
            <p class="form-error" id="login-error">Wrong email or password</p>
            <form id="login-form">
                <select id="role" name="role" required>
                    <option value="" disabled selected>Select role</option>
                    <option value="passenger">Passenger</option>
                    <option value="driver">Driver</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <div class="link-right">
                    <a href="select_role.php">I don't have account</a>
                </div>
                <button type="submit">Log In</button>
            </form>
        </div>
    </div>
</body>

</html>