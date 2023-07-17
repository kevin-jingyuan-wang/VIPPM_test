<?php
class Database {
    private $conn;

    public function __construct() {
        require_once('mysql.php');
        $this->conn = new MySQLConnection('50.62.141.179', 'kj3wang', 'Sp6VQVp9gJ5L9se', 'VIPPM', '3306');
    }

    /**
     * Get the maximum ID from the given parameter table
     *
     * @return int The maximum $table ID + 1
     */
    public function getMaxId($table) {
        $id = $table."_Id";
        $query = "SELECT MAX($id) AS max_id FROM $table";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['max_id'] + 1;
    }

    public function getMaxPersonId() {
        $query = "SELECT MAX(person_id) AS max_id FROM person";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['max_id'] + 1;
    }
    

    /**
     * Insert login credentials into the login table
     *
     * @param string $username The username
     * @param string $password The password
     * @return void
     */
    public function insertLogin($username, $password, $usertype) {
        // Use bcrypt algorithm for password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        date_default_timezone_set('America/Toronto');
        $currentDateTime = date('Y-m-d H:i:s');
        $loginAttempts = 0;
    
        $insert_login_query = "INSERT INTO `Login` (Username, Hashed_Password, login_attempts, Last_Update_Time, usertype) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insert_login_query);
        $stmt->bind_param("ssiss", $username, $hashedPassword, $loginAttempts, $currentDateTime, $usertype);
        $stmt->execute();
    }

    /*public function insertLogin($username, $password, $usertype) {
        // Use bcrypt algorithm for password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        date_default_timezone_set('America/Toronto');
        $currentDateTime = date('Y-m-d H:i:s');
        $loginAttempts = 0;
    
        $insert_login_query = "INSERT INTO login_table (username, password, login_attempts, Last_Update_Time, user_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insert_login_query);
        $stmt->bind_param("ssiss", $username, $hashedPassword, $loginAttempts, $currentDateTime, $usertype);
        $stmt->execute();
    }
    */

    //改到这
    
    /**
     * Insert person details into the person table
     *
     * @param int $person_id The person ID
     * @param string $username The username
     * @param string $first_name The first name
     * @param string $last_name The last name
     * @param string $gender The gender
     * @param string $email The email
     * @param string $phone The phone number
     * @param string $emergency_phone The emergency phone number
     * @param string $address The address
     * @param string $city The city
     * @param string $province The province
     * @param string $postal_code The postal code
     * @return void
     */
    public function insertPerson($person_id, $username, $first_name, $last_name, $gender, $email, $phone, $emergency_phone, $address, $city, $province, $postal_code) {
        $insert_person_query = "INSERT INTO Person (person_id, username, first_name, last_name, gender, email, phone, emergency_phone, address_line_1, city, province, postal_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insert_person_query);
        $stmt->bind_param("isssssssssss", $person_id, $username, $first_name, $last_name, $gender, $email, $phone, $emergency_phone, $address, $city, $province, $postal_code);
        $stmt->execute();
    }

    public function insertLogEntry($userId, $username, $actionType, $actionDetails, $ipAddress, $deviceInfo, $actionResult, $errorMessage) {
        $insert_log_query = "INSERT INTO log_table (user_id, username, action_type, action_details, ip_address, device_info, action_result, error_message)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($insert_log_query);
        $stmt->bind_param("isssssss", $userId, $username, $actionType, $actionDetails, $ipAddress, $deviceInfo, $actionResult, $errorMessage);
        $stmt->execute();
    }

    public function insertCompany($company_id, $username, $company_name, $contact_name, $contact_phone, $email, $phone, $emergency_phone, $address, $city, $province, $postal_code) {
        $insert_company_query = "INSERT INTO Company (Company_Id, Username, `Name`, Contact_Name, Contact_Phone, Email, Phone, Emergency_Phone, Address_Line_1, City, Province, Postal_Code) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insert_company_query);
        $stmt->bind_param("isssssssssss", $company_id, $username, $company_name, $contact_name, $contact_phone, $email, $phone, $emergency_phone, $address, $city, $province, $postal_code);
        $stmt->execute();
    }

    public function insertContractor($contractor_id, $username, $Business_Number, $HST_Number, $Insurance_Company, $Insurance_Policy_Number, $Insurance_Description, $Working_Day) {
        $insert_contractor_query = "INSERT INTO Contractor (Contractor_Id, Username, Business_Number, HST_Number, Insurance_Company, Insurance_Policy_Number, Insurance_Description, Working_Day) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($insert_contractor_query);
        $stmt->bind_param("isssssssssss", $contractor_id, $username, $Business_Number, $HST_Number, $Insurance_Company, $Insurance_Policy_Number, $Insurance_Description, $Working_Day);
        $stmt->execute();
    }


    /**
     * Validate the username and password for login
     *
     * @param string $username The username
     * @param string $password The password
     * @return void
     */
    public function loginUser($username, $password) {
        $username = $this->conn->escapeString($username);

        $query = "SELECT * FROM `Login` WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['Hashed_Password'];

            // Verify the password using password_verify()
            if (password_verify($password, $hashedPassword)) {
                // Reset login attempts and update last update time
                $this->resetLoginAttempts($username);
                $this->updateLastUpdateTime($username);
                
                return true;
            }else{
                // Increment login attempts
                $this->incrementLoginAttempts($username);

                return false;
            }
        }            
    }

    /**
     * Logout the user and destroy the session
     *
     * @return void
     */
    public function logoutUser() {
        session_unset();
        session_destroy();
        header("Location: test.php");
        exit;
    }

    /**
     * Close the database connection
     *
     * @return void
     */
    public function closeConnection() {
        $this->conn->close();
    }

    /**
     * Check if the account is locked based on login attempts and last update time
     *
     * @param string $username The username
     * @return bool True if the account is locked, false otherwise
     */
    public function isAccountLocked($username) {
        $query = "SELECT login_attempts, Last_Update_Time FROM `Login` WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $loginAttempts = $row['login_attempts'];
            $maxLoginAttempts = 5; // Set the maximum allowed login attempts here
            $lastUpdateTime = $row['Last_Update_Time'];

            // Check if login attempts exceed the maximum allowed attempts
            if ($loginAttempts >= $maxLoginAttempts) {
                // Check if the time difference exceeds 1 hour
                if ($this->isTimeDifferenceExceeded($lastUpdateTime)) {
                    $this->resetLoginAttempts($username);
                    return false;
                } else {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if the time difference between the last update time and the current time exceeds 1 hour
     *
     * @param string $lastUpdateTime The last update time
     * @return bool True if the time difference exceeds 1 hour, false otherwise
     */
    public function isTimeDifferenceExceeded($lastUpdateTime) {
        $currentDateTime = date('Y-m-d H:i:s');
        $lastUpdateTimestamp = strtotime($lastUpdateTime);
        $currentTimestamp = strtotime($currentDateTime);
        $timeDifference = $currentTimestamp - $lastUpdateTimestamp;
        $hourInSeconds = 60 * 60; // 1 hour = 60 minutes * 60 seconds

        return $timeDifference >= $hourInSeconds;
    }

    /**
     * Increment the login attempts for the account
     *
     * @param string $username The username
     * @return void
     */
    public function incrementLoginAttempts($username) {
        $query = "UPDATE `Login` SET login_attempts = login_attempts + 1 WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }

    /**
     * Reset the login attempts for the account
     *
     * @param string $username The username
     * @return void
     */
    public function resetLoginAttempts($username) {
        $query = "UPDATE `Login` SET login_attempts = 0 WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }

    /**
     * Update the last update time for the account
     *
     * @param string $username The username
     * @return void
     */
    public function updateLastUpdateTime($username) {
        $currentDateTime = date('Y-m-d H:i:s');
        $query = "UPDATE `Login` SET Last_Update_Time = ? WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $currentDateTime, $username);
        $stmt->execute();
    }

    public function getPersonDataByUsername($username) {
        global $database;
        $username = $database->conn->escapeString($username);
    
        $query = "SELECT * FROM `Person` WHERE username = ?";
        $stmt = $database->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    
        return null;
    }

    public function updatePerson($username, $first_name, $last_name, $gender, $email, $phone, $emergency_phone, $address, $city, $province, $postal_code) {
        $update_person_query = "UPDATE `Person` SET first_name = ?, last_name = ?, gender = ?, email = ?, phone = ?, emergency_phone = ?, address_line_1 = ?, city = ?, province = ?, postal_code = ? WHERE username = ?";
        $stmt = $this->conn->prepare($update_person_query);
        $stmt->bind_param("sssssssssss", $first_name, $last_name, $gender, $email, $phone, $emergency_phone, $address, $city, $province, $postal_code, $username);
        $stmt->execute();
    }

    // Insert task data into task
    public function insertTask($username, $contactName, $contactEmail, $contactPhone, $houseAddress, $city, $province, $postalCode, $houseType, $serviceType, $serviceArea, $serviceItem, $serviceContent, $serviceDetails, $uploadedFiles, $customer_prefer_service_date) {
        // Generate a unique task ID
        date_default_timezone_set('America/Toronto');
        $timestamp = strtotime(date('Y-m-d H:i:s'));
        $task_num = $timestamp + mt_rand(1000, 9999);

        //Default start task status
        $Task_Status = "Uploaded";

        // Prepare the SQL statement for inserting task data
        $sql = "INSERT INTO Task (task_num, username, first_name, Email, Phone, Address_Line_1, city, province, postal_code, House_Type, service_type, service_area, service_item, service_content, service_details, photos, Task_Status, preferred_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Create a prepared statement
        $stmt = $this->conn->prepare($sql);
        
        // Convert the file path array to a comma-separated string
        $photos = implode(",", $uploadedFiles);
        
        // Bind the parameters
        $stmt->bind_param("isssssssssssssssss", $task_num, $username, $contactName, $contactEmail, $contactPhone, $houseAddress, $city, $province, $postalCode, $houseType, $serviceType, $serviceArea, $serviceItem, $serviceContent, $serviceDetails, $photos, $Task_Status, $customer_prefer_service_date);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            return true; // Data insertion successful
        } else {
            return false; // Data insertion failed
        }
    }
    
    



    public function getUserTypeByUsername($username) {
        global $database;
        $username = $database->conn->escapeString($username);
        $query = "SELECT usertype FROM `Login` WHERE username = ?";
        $stmt = $database->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['usertype'];
        } else {
            return null; // Return null if the user is not found
        }
    }

    public function getReservationDataByTaskNum($task_num) {
        global $database;
        $task_num = $database->conn->escapeString($task_num);
    
        $query = "SELECT * FROM task WHERE task_num = ?";
        $stmt = $database->conn->prepare($query);
        $stmt->bind_param("i", $task_num);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    
        return null;
    }
    
    public function updateReservation($task_num, $contact_name, $contact_email, $contact_phone, $house_address, $city, $province, $postal_code, $house_type, $service_type, $service_area, $service_item, $service_content, $service_details) {
        $update_reservation_query = "UPDATE task SET contact_name = ?, contact_email = ?, contact_phone = ?, house_address = ?, city = ?, province = ?, postal_code = ?, house_type = ?, service_type = ?, service_area = ?, service_item = ?, service_content = ?, service_details = ? WHERE task_num = ?";
        $stmt = $this->conn->prepare($update_reservation_query);
        $stmt->bind_param("sssssssssssss", $contact_name, $contact_email, $contact_phone, $house_address, $city, $province, $postal_code, $house_type, $service_type, $service_area, $service_item, $service_content, $service_details, $task_num);
        $stmt->execute();
    }

    public function getReservationDataByUsername($username) {
        global $database;
        $username = $database->conn->escapeString($username);
    
        $query = "SELECT * FROM task WHERE username = ?";
        $stmt = $database->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    
        return null;
    }

    public function getReservationCountByUsername($username) {
        $username = $this->conn->escapeString($username);
    
        $query = "SELECT COUNT(*) as total FROM Task WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
    
        return 0;
    }

    public function getReservationDataByUsernameWithPagination($username, $perPage, $offset) {
        $username = $this->conn->escapeString($username);
    
        $query = "SELECT * FROM task WHERE username = ? LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sii", $username, $perPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $tasks = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
        }
    
        return $tasks;
    }

    public function getPaymentDataByTaskNum($task_num) {
        $task_num = $this->conn->escapeString($task_num);
    
        $query = "SELECT * FROM payment WHERE task_num = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $task_num);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    
        return null;
    }

    public function updatePaymentDetails($task_num, $username, $paymentAmount, $paymentDate, $payerName) {
        $task_num = $this->conn->escapeString($task_num);
        // Prepare the SQL statement for inserting payment data
        $sql = "UPDATE payment SET username = ?, paymentAmount = ?, paymentDate = ?, payerName = ?, paymentStatus = ? WHERE task_num = ?";
        
        $paymentStatus = "unconfirmed";
        // Create a prepared statement
        $stmt = $this->conn->prepare($sql);
        
        // Bind the parameters
        $stmt->bind_param("sssssi", $username, $paymentAmount, $paymentDate, $payerName, $paymentStatus, $task_num);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            return true; // Data insertion successful
        } else {
            return false; // Data insertion failed
        }
    }


}
?>