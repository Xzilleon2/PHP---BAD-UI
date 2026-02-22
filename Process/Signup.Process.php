<?php 

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup_btn"])) {

    // imports
    include_once "../Class/Dbh.Class.php";
    include_once "../Class/UsersCntrl.Class.php";

    // Get form data
    $email = filter_var(trim($_POST["signup_email"]), FILTER_SANITIZE_EMAIL);
    $name = filter_var(trim($_POST["signup_name"]), FILTER_SANITIZE_SPECIAL_CHARS);
    $password = trim($_POST["signup_password"]);

    // Initialize User Controller
    $userCntrl = new UserCntrl($email, $name, $password);

    // Call signup method
    if(!$userCntrl->signup()) {
       header("Location: ../login.php?error=signup_failed");
       exit();
    } else {
        header("Location: ../login.php?signup=success");
        exit();
    }

} else {
    header("Location: ../login.php?error=invalid_request");
    exit();
}




?>