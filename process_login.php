<?php

$user_email = $errorMsg = "";
$user_pwd = $errorMsg = "";
$success = true;

if (empty($_POST['user_email']) || empty($_POST['user_pwd'])) {
    $errorMsg .= "Email or Password is missing! Please ensure that you have both inputs.";
    $success = false;
} else {
    if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $_POST['user_email'])) {
        $errorMsg .= "Invalid email format 1.<br>";
        $success = false;
    }
    $user_email = sanitize_input($_POST['user_email']);
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email format 2.<br>";
        $success = false;
    }
    authenticateUser();
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function authenticateUser() {
    global $user_id, $user_email, $errorMsg, $success, $db_pwd_hashed;
    session_start();
    session_regenerate_id();
    $token = hash("sha256", uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();
    $_SESSION['role'] = "user"; //setting role of user session to admin. to verify is logged in and is user to make some website unaccessible=
    $_SESSION['user_email'] = $user_email;
    $_SESSION['cart'] = [];
}

if ($success) {

    include "essential.inc.php";
    include "nav.inc.php";
    echo "<main class='container'>";
    echo "<div class='user_notification'>";
    echo "<section id='registerSuccess'>";
    echo "<h1>Login successful!</h1>";
    echo "<h4> Welcome Back!</h4>";
    echo "<h5> $user_email </h5>";
    echo "<br><br><a class='btn btn-success' type='submit' href='books.php'> Procceed to Browse Books </a><br><br>";
    echo "</section>";
    echo "</div>";
    echo "</main>";
    include "footer.inc.php";
} else {
    include "essential.inc.php";
    include "nav.inc.php";
    echo "<main class='container'>";
    echo "<section id='loginFail'>";
    echo "<div class='user_notification'>";
    echo "<h1> Oops! </h1>";
    echo "<h4> The following errors were detected: </h4>";
    echo "<p>" . $errorMsg . "</p>";
    echo "<br><a class='btn btn-warning' type='submit' href='index.php'> Return to Login </a><br><br>";
    echo "</section>";
    echo "</div>";
    echo "</main>";
    include "footer.inc.php";
}
?>