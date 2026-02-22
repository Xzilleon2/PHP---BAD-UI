<?php 

// Controller class for user-related operations (database interactions)
class Users extends Dbh {

    // Method to get all users
    protected function getUsers($email) {
        
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute(array($email))) {
            return false;
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to insert users
    protected function insertUsers($email, $name, $password) {

        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (email, name, password) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute(array($email, $name, $hashed_password))) {
            return false;
        }

        return true;
    }

}


?>