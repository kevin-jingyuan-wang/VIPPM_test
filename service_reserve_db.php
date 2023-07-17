<?php
session_start();
require_once('database.php');
require_once('captcha.php');
require_once('logger.php');

// Create an instance of the Database class
$database = new Database();

$logger = new Logger();

// Function to validate email format
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate Canadian postal code format
function validatePostalCode($postalCode) {
    $regex = '/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/';
    return preg_match($regex, $postalCode);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Get the logged-in user's username
$username = $_SESSION['username'];

// Retrieve form data
$contactName = $_POST["contact_name"];
$contactEmail = $_POST["contact_email"];
$contactPhone = $_POST["contact_phone"];
$houseAddress = $_POST["house_address"];
$city = $_POST["city"];
$province = $_POST["province"];
$postalCode = $_POST["postal_code"];
$houseType = $_POST["house_type"];
$serviceType = $_POST["service_type"];
$serviceArea = $_POST["service_area"];
$serviceItem = $_POST["service_item"];
$serviceContent = $_POST["service_content"];
$serviceDetails = $_POST["service_details"];
$customer_prefer_service_date = $_POST["customer_prefer_service_date"];
$captcha = $_POST["captcha"];

// Validate the captcha
if (!Captcha::validateCaptcha($captcha)) {
    $_SESSION['error_message'] = "Invalid captcha. Please try again.";
    header("Location: service_reserve.php");
    exit;
}

// Validate email format
if (!validateEmail($contactEmail)) {
    // Invalid email format
    $_SESSION['error'] = "Invalid email format";
    header("Location: service_reserve.php");
    exit;
}

// Validate Canadian postal code format
if (!validatePostalCode($postalCode)) {
    // Invalid postal code format
    $_SESSION['error'] = "Invalid postal code format";
    header("Location: service_reserve.php");
    exit;
}

// Handle file uploads
$targetDir = "uploads/";
$uploadedFiles = array();

// Check if any files were uploaded
if (!empty($_FILES["photos"]["name"][0])) {
    // Create target directory if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Loop through uploaded files
    foreach ($_FILES["photos"]["name"] as $key => $name) {
        $targetFile = $targetDir . basename($name);
        $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        // Check if file already exists
        if (file_exists($targetFile)) {
            // Generate a unique file name
            $newName = pathinfo($name, PATHINFO_FILENAME) . "_" . time() . "." . $fileType;
            $targetFile = $targetDir . $newName;
        }

        // Check file size and allowed file types
        if ($_FILES["photos"]["size"][$key] > 5242880) { // 5MB
            // File size limit exceeded
            $_SESSION['error'] = "File size limit exceeded. Max file size is 5MB.";
            header("Location: service_reserve.php");
            exit;
        } elseif ($fileType !== "jpg" && $fileType !== "jpeg" && $fileType !== "png") {
            // Invalid file type
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
            header("Location: service_reserve.php");
            exit;
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["photos"]["tmp_name"][$key], $targetFile)) {
            $uploadedFiles[] = $targetFile;
        } else {
            // Failed to move file
            $_SESSION['error'] = "Failed to upload files. Please try again.";
            header("Location: service_reserve.php");
            exit;
        }
    }
}

// Insert data into task_table
$database->insertTask($username, $contactName, $contactEmail, $contactPhone, $houseAddress, $city, $province, $postalCode, $houseType, $serviceType, $serviceArea, $serviceItem, $serviceContent, $serviceDetails, $uploadedFiles, $customer_prefer_service_date);

// Registration successful, redirect to the index page
$_SESSION['success_message'] = "reservation successful.";
$logger->logEvent('reserve', 'Successful reserve','Success','');
echo "<script>alert('reservation successful.'); window.location.href='index.php';</script>";
exit;
?>