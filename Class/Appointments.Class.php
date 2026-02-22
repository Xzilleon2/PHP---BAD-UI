<?php 

// Controller class for user-related operations (database interactions)
class Appointments extends Dbh {


    // Method to insert appointment
    protected function insertAppointments($fullname, $birthday, $age, $gender, $contactnumber, $email, $reason, $preferredtime) {


        $query = "INSERT INTO appointment (FULL_NAME, BIRTHDAY, AGE, GENDER, CONTACT_NUMBER, EMAIL, REASON, PREFERRED_TIME) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($query);

        if(!$stmt->execute(array($fullname, $birthday, $age, $gender, $contactnumber, $email, $reason, $preferredtime))) {
            return false;
        }

        return true;
    }

}


?>