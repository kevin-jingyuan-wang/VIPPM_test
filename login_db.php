<?php
session_start(); // Start the session

require_once('database.php');
require_once('captcha.php');
require_once('logger.php');

// Create an instance of the Database class
$database = new Database();

$logger = new Logger();

// Define the maximum login attempts
$maxLoginAttempts = 5;

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $captcha = $_POST["captcha"];

    // Validate the captcha
    if (!Captcha::validateCaptcha($captcha)) {
        $_SESSION['error_flag'] = 'err_captcha';
        $logger->logEvent('login', 'Invalid captcha','Error','');
        header("Location: login.php");
        exit;
    }

    // Check if the user has reached the maximum login attempts
    if ($database->isAccountLocked($username, $maxLoginAttempts)) {
        $logger->logEvent('login', 'Account locked due to too many login attempts','Error','');
        die("Your account has been locked due to too many login attempts. Please try again later.");
    }

    // Call the loginUser method from the Database class
    $loggedIn = $database->loginUser($username, $password);

    if ($loggedIn) {
        // Get the user type
        $userType = $database->getUserTypeByUsername($username);

        if ($userType) {
            // Set the user type in the session
            $_SESSION['user_type'] = $userType;
        }

        $_SESSION['username'] = $username;
        $logger->logEvent('login', 'Successful login','Success','');
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error_flag'] = 'err_username_password';
        $logger->logEvent('login', 'Invalid username or password','Error','');
        header("Location: login.php");
        exit;
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    $database->logoutUser();
}

// Close the database connection
$database->closeConnection();
?>