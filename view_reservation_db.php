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

// Retrieve payment information from the database based on task ID
$paymentInfo = $database->getPaymentDataByTaskNum($task_num);

// If no reservation information is found, initialize an empty array
if (!$reservationInfo) {
    $reservationInfo = array(
        'task_num' => '',
        'contact_name' => '',
        'house_address' => '',
        'house_type' => '',
        'service_type' => '',
        'service_area' => '',
        'service_item' => '',
        'service_content' => '',
        'service_details' => '',
        'Prefer Service Date' => '',
        'Task_Status' => '',
        'Start_Date' => '',
        'Total_Amount' => '',
        'Admin_Comments' => ''
    );
}

// Handle the form submission for payment details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract the payment details from the form
    $task_num = $_POST['task_num'];
    $paymentAmount = $_POST['paymentAmount'];
    $paymentDate = $_POST['paymentDate'];
    $payerName = $_POST['payerName'];
    echo $task_num;
    // Store the payment details in the database
    $database->updatePaymentDetails($task_num, $username, $paymentAmount, $paymentDate, $payerName);

    // Redirect to a success page or perform any additional actions
    header("Location: order_show.php");
    exit;
}
?>