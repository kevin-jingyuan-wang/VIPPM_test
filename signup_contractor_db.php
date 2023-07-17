<?php
session_start(); // Start the session

require_once('database.php');
require_once('captcha.php');
require_once('logger.php');

// Create an instance of the Database class
$database = new Database();

$logger = new Logger();

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $emergency_phone = !empty($_POST["emergency_phone"]) ? $_POST["emergency_phone"] : null;
    $address = $_POST["address"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $postal_code = $_POST["postal_code"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $captcha = $_POST["captcha"];

    // Validate the captcha
    if (!Captcha::validateCaptcha($captcha)) {
        $_SESSION['error_message'] = "Invalid captcha. Please try again.";
        header("Location: signup_contractor.php");
        exit;
    }

    // Check if the password and confirm password match
    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Password and confirm password do not match.";
        header("Location: signup_contractor.php");
        exit;
    }

    // Validate phone and emergency phone format
    $phone_pattern = "/^[0-9]{10}$/";
    if (!preg_match($phone_pattern, $phone)) {
        $_SESSION['error_message'] = "Invalid phone number format. Please enter a 10-digit phone number.";
        header("Location: signup_contractor.php");
        exit;
    }
    if (!empty($emergency_phone) && !preg_match($phone_pattern, $emergency_phone)) {
        $_SESSION['error_message'] = "Invalid emergency phone number format. Please enter a 10-digit phone number.";
        header("Location: signup_contractor.php");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format. Please enter a valid email address.";
        header("Location: signup_contractor.php");
        exit;
    }

    // Validate postal code format
    $postal_code_pattern = "/^[A-Za-z]\d[A-Za-z] \d[A-Za-z]\d$/";
    if (!preg_match($postal_code_pattern, $postal_code)) {
        $_SESSION['error_message'] = "Invalid postal code format. Please enter a valid Canadian postal code.";
        header("Location: signup_contractor.php");
        exit;
    }

    // Get the maximum person_id value
    $person_id = $database->getMaxPersonId();

    // Insert into login_table
    $database->insertLogin($username, $password, "contractor");

    // Insert into person_table
    $database->insertPerson($person_id, $username, $first_name, $last_name, $gender, $email, $phone, $emergency_phone, $address, $city, $province, $postal_code);

    // Close the database connection
    $database->closeConnection();

    // Registration successful, redirect to the login page
    $_SESSION['success_message'] = "Registration successful. Please login with your credentials.";
    $logger->logEvent('signup', 'Contractor Successful signup','Success','');
    echo "<script>alert('Registration successful. Please login with your credentials.'); window.location.href='login.php';</script>";
    exit;
}
?>