<?php
class Database {
    private $host = "localhost";

    private $username = "root";
    //replace username with actual username e.g. 'root'
    private $password = "your_password";
    // Replace with your MySQL password, if no password leave it blank (do not delete the commas)
    private $database = "your_database";
    // Replace with your MySQL database name e.g. "books_db"
    private $conn;

    // Using Constructor to establish the database connection
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Checking if connection is successfull or has failed
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "Connected successfully";
    }

    // Method to get the database connection
    public function getConnection() {
        return $this->conn;
    }
}

// Creating an instance of the Database class to establish connection
$database = new Database();
$connection = $database->getConnection();

?>
