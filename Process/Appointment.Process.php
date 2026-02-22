<?php 

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["appointment_btn"])) {

    // imports
    include_once "../Class/Dbh.Class.php";
    include_once "../Class/AppointmentsCntrl.Class.php";

    // Get form data
    $fullname = trim($_POST["full_name"]);
    $birthday = trim($_POST["birthday"]);
    $age = trim($_POST["age"]);
    $gender = trim($_POST["gender"]);
    $contactnumber = trim($_POST["contactnumber"]);
    $email = trim($_POST["email"] . "@gmail.com");
    $reason = trim($_POST["reason"]);
    $preferredtime = trim($_POST["preferred_time"]);

    // Initialize Appointment Controller
    $userCntrl = new AppointmentsCntrl($fullname, $birthday, $age, $gender, $contactnumber, $email, $reason, $preferredtime);

    // Call scheduleAppointment method
    if(!$userCntrl->scheduleAppointment()) {
       header("Location: ../appointment.php?error=schedule_failed");
       exit();
    } else {
        header("Location: ../index.php?appointment=scheduled");
        exit();
    }

} else {
    header("Location: ../appointment.php?error=invalid_request");
    exit();
}

?>