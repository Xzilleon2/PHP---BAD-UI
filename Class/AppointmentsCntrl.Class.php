<?php 

include_once "Appointments.Class.php";

// Controller class for user-related operations (database interactions)
class AppointmentsCntrl extends Appointments {

    // Fields for user data
    private $fullname;
    private $birthday;
    private $age;
    private $gender;
    private $contactnumber;
    private $email;
    private $reason;
    private $preferredtime;


    // Constructor to initialize user data
    public function __construct($fullname, $birthday, $age, $gender, $contactnumber, $email, $reason, $preferredtime) {

        $this->fullname = $fullname;
        $this->birthday = $birthday;
        $this->age = $age;
        $this->gender = $gender;
        $this->contactnumber = $contactnumber;
        $this->email = $email;
        $this->reason = $reason;
        $this->preferredtime = $preferredtime;

    }

    /* Method for controller */
    // Signup method to handle user registration
    public function scheduleAppointment() {

        // Check for empty input
        if($this->emptyInput($this->fullname, $this->birthday, $this->age, $this->gender, $this->contactnumber, $this->email, $this->reason, $this->preferredtime)) {
            header("Location: ../appointment.php?error=empty_input");
            exit();
        }

        // Query the database
        $this->insertAppointments($this->fullname, $this->birthday, $this->age, $this->gender,  $this->contactnumber, $this->email, $this->reason, $this->preferredtime);

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