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

// Retrieve reservation information from the database based on task ID
$task_num = $_GET['task_num'];
$reservationInfo = $database->getReservationDataByTaskNum($task_num);

// If no reservation information is found, initialize an empty array
if (!$reservationInfo) {
    $reservationInfo = array(
        'task_num' => '',
        'contact_name' => '',
        'contact_email' => '',
        'contact_phone' => '',
        'house_address' => '',
        'city' => '',
        'province' => '',
        'postal_code' => '',
        'house_type' => '',
        'service_type' => '',
        'service_area' => '',
        'service_item' => '',
        'service_content' => '',
        'service_details' => '',
        'photo' => '', 
        'Prefer Service Date' => ''
    );
}

// Handle form submission for updating reservation information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact_name = $_POST["contact_name"];
    $contact_email = $_POST["contact_email"];
    $contact_phone = $_POST["contact_phone"];
    $house_address = $_POST["house_address"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $postal_code = $_POST["postal_code"];
    $house_type = $_POST["house_type"];
    $service_type = $_POST["service_type"];
    $service_area = $_POST["service_area"];
    $service_item = $_POST["service_item"];
    $service_content = $_POST["service_content"];
    $service_details = $_POST["service_details"];
    $customer_prefer_service_date = $_POST["customer_prefer_service_date"];


    // Update reservation information in the database
    $database->updateReservation($task_num, $contact_name, $contact_email, $contact_phone, $house_address, $city, $province, $postal_code, $house_type, $service_type, $service_area, $service_item, $service_content, $service_details, $customer_prefer_service_date);

    // Redirect to the same page to display updated information
    header("Location: modify_reservation.php?task_num=" . $task_num . "&edit=false");
    exit;
}
?>