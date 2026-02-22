<?php 

include_once "Users.Class.php";

// Controller class for user-related operations (database interactions)
class UserCntrl extends Users {

    // Fields for user data
    private $name;
    private $password;
    private $email;

    // Constructor to initialize user data
    public function __construct($email = null, $name = null, $password = null) {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    /* Method for controller */
    // Signup method to handle user registration
    public function signup() {

        // Check for empty input
        if($this->emptyInput($this->email, $this->name, $this->password)) {
            header("Location: ../login.php?error=empty_input");
            exit();
        }

        // Query the database
        $this->insertUsers($this->email, $this->name, $this->password);

        return true;
    }

    // Signin method to handle user login
    public function signin($email, $password) {

        // Check for empty input
        if($this->emptyInput($email, $password)) {
            header("Location: ../login.php?error=empty_input");
            exit();
        }

        $user = $this->getUsers($email);

        // Check if password is correct
        if(!password_verify($password, $user["PASSWORD"])) {
            header("Location: ../login.php?error=password_incorrect");
            exit();
        }

        // Generate ID
        session_regenerate_id();

        // Store user data in session
        $_SESSION["USER_ID"] = $user["USER_ID"];
        $_SESSION["USER_NAME"] = $user["NAME"];
        $_SESSION["USER_EMAIL"] = $user["EMAIL"];

        return true;
    }

    /* Method for error handling */
    // Check if any input is empty
    private function emptyInput(...$vars) {
        foreach ($vars as $input) {
            if (empty($input)) {
                return true;
            }
        }
        return false;
    }

}


?>