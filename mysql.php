<?php
class MySQLConnection {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $port;
    private $conn;

    public function __construct($servername, $username, $password, $dbname, $port) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
        $this->connect();
    }

    private function connect() {
        // Create a connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);

        // Check if the connection was successful
        if ($this->conn->connect_error) {
            die("Failed to connect to the database: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
    
    public function prepare($query) {
        return $this->conn->prepare($query);
    }
    
    public function escapeString($string) {
        return $this->conn->real_escape_string($string);
    }

    public function query($query) {
        return $this->conn->query($query);
    }

    public function close() {
        $this->conn->close();
    }
}

// Database connection configuration
$servername = "50.62.141.179"; // Database server name
$username = "kj3wang"; // Database username
$password = "Sp6VQVp9gJ5L9se"; // Database password
$dbname = "VIPPM"; // Database name
$port = 3306;  // MySQL server port number

// Create an instance of the database connection
$db = new MySQLConnection($servername, $username, $password, $dbname, $port);
$conn = $db->getConnection();
?>