<?php 
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signin_btn"])) {

    // imports
    include_once "../Class/Dbh.Class.php";
    include_once "../Class/UsersCntrl.Class.php";

    // Get form data
    $email = filter_var(trim($_POST["signin_email"]), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST["signin_password"]);

    // Initialize User Controller
    $userCntrl = new UserCntrl();

    // Call signin method
    if(!$userCntrl->signin($email, $password)) {
       header("Location: ../login.php?error=signin_failed");
       exit();
    } else {
        header("Location: ../index.php?signin=success");
        exit();
    }

} else {
    header("Location: ../login.php?error=invalid_request");
    exit();
}

?>