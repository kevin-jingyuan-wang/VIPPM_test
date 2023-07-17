<?php
session_start(); // Start the session

require_once('database.php');

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to the test page
    exit;
}

// Create an instance of the Database class
$database = new Database();

// Handle logout
if (isset($_POST['logout'])) {
    // Clear the session data
    session_unset();
    session_destroy();
    // Redirect to test.php after logout
    header("Location: index.php");
    exit;
}

$error_username_password = "";
$error_captcha = "";
if (isset($_SESSION['error_flag'])) {
    if ($_SESSION['error_flag'] === 'err_username_password') {
        $error_username_password = "Invalid username or password. Please try again.";
    } elseif ($_SESSION['error_flag'] === 'err_captcha') {
        $error_captcha = "Invalid captcha. Please try again.";
    }
    unset($_SESSION['error_flag']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        .error {
            color: red;
        }
    </style>
    <script>
        <?php if (!empty($error_username_password)): ?>
        window.onload = function() {
            alert("<?php echo $error_username_password; ?>");
        };
        <?php elseif (!empty($error_captcha)): ?>
        window.onload = function() {
            alert("<?php echo $error_captcha; ?>");
        };
        <?php endif; ?>
    </script>
</head>
<body>
    <?php include 'header.php'; ?>    

    <h2>Login</h2>

    <?php if (!empty($error_username_password)): ?>
        <p class="error"><?php echo $error_username_password; ?></p>
    <?php endif; ?>

    <?php if (!empty($error_captcha)): ?>
        <p class="error"><?php echo $error_captcha; ?></p>
    <?php endif; ?>

    <form method="POST" action="login_db.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="captcha">CAPTCHA:</label>
        <input type="text" name="captcha" id="captcha" required><br>
        <img src="captcha.php?action=image" alt="Captcha Image"><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>