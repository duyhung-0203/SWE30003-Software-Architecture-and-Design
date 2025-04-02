<?php
$role = $_GET['role'] ?? null;
if (!$role || !in_array($role, ['passenger', 'driver'])) {
    header("Location: select_role.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($role) ?> Sign Up</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/register.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script src="assets/JS/register.js" defer></script>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h1 class="brand">SmartRide</h1>
            <h2><?= ucfirst($role) ?> sign up</h2>
            <p class="form-error" id="nameError">Re-enter name</p>
            <p class="form-error" id="pwMatchError">Password must match</p>
            <p class="form-error" id="email_password_error">Wrong email or password</p>
            <p class="form-error" id="license">Driver's license required</p>
            <p class="form-error" id="emailExisted">Email has been used</p>
            <form id="register-form">
                <input type="hidden" id="role" name="role" value="<?= $role ?>">
                <input type="text" id="name" name="name" placeholder="Full Name" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter Password"
                    required>

                <?php if ($role === 'driver'): ?>
                    <label style="margin-bottom: 10px;">
                        <input type="checkbox" id="has_license" name="has_license" value="1">
                        I have a valid driver's license
                    </label>
                <?php endif; ?>
                    
                <button type="submit">Sign up</button>
                <div class="back-button">
                    <a href="select_role.php">← Back to Role Selection</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>