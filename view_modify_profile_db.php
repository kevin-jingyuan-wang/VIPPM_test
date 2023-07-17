<?php
if (!isset($_SESSION)) {
    session_start(); // Start the session
}
require_once('database.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Create an instance of the Database class
$database = new Database();

// Get the logged-in user's username
$username = $_SESSION['username'];

// Retrieve user information from the database
$userInfo = $database->getPersonDataByUsername($username);

// If no user information is found, initialize an empty array
if (!$userInfo) {
    $userInfo = array(
        'first_name' => '',
        'last_name' => '',
        'gender' => '',
        'email' => '',
        'phone' => '',
        'emergency_phone' => '',
        'address' => '',
        'city' => '',
        'province' => '',
        'postal_code' => ''
    );
}

// Handle form submission for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Update user information in the database
    $database->updatePerson($username, $first_name, $last_name, $gender, $email, $phone, $emergency_phone, $address, $city, $province, $postal_code);

    // Redirect to the same page to display updated information
    header("Location: view_modify_profile.php");
    exit;
}
?>