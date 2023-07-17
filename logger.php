<?php
require_once('database.php');

class Logger {
    private $database;
    
    public function __construct() {
        $this->database = new Database();
    }
    
    public function logEvent($actionType, $actionDetails, $actionResult, $errorMessage) {
        // Get the current user ID and username
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

        // Get the IP address and device info
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $deviceInfo = $_SERVER['HTTP_USER_AGENT'];

        // Insert the log entry into the database
        $this->database->insertLogEntry($userId, $username, $actionType, $actionDetails, $ipAddress, $deviceInfo, $actionResult, $errorMessage);
    }
}
?>