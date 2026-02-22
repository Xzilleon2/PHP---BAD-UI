<?php 

class Dbh {

    // Fields for database connection
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $dbName = "badui";
    private $conn;

    // Connection method
    protected function connect() {

        // Check if connection already exists
        if (!$this->conn) {
            try {
                $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
                $this->conn = new PDO($dsn, $this->user, $this->pwd);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                die();
            }
        }
        
        // Return the connection
        return $this->conn;
    }

}

?>