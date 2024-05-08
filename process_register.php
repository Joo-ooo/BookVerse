<?php
$customer_fname = $errorMsg = "";
$customer_lname = $errorMsg = "";
$customer_email = $errorMsg = "";
$customer_number = $errorMsg = "";
$customer_pwd = $errorMsg = "";
$customer_pwd_confirm = $errorMsg = "";
$success = true;

/* For last name */
if (empty($_POST['customer_lname'])) {
    $errorMsg .= "Last Name is required.<br>";
    $success = false;
} else {
    if (!preg_match("/^[A-Za-z ]+$/", $_POST['customer_lname'])) {
        $errorMsg .= "Invalid last name format.<br>";
        $success = false;
    }
    $customer_lname = sanitize_input($_POST['customer_lname']);
}

/* For email */
if (empty($_POST['customer_email'])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else {
    if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/", $_POST['customer_email'])) {
        $errorMsg .= "Invalid email format.<br>";
        $success = false;
    }
    $customer_email = sanitize_input($_POST['customer_email']);
    // Additional check to make sure e-mail address is well-formed.
    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email format.<br>";
        $success = false;
    }
}

/* For number */
if (empty($_POST['customer_number'])) {
    $errorMsg .= "Number is required.<br>";
    $success = false;
} else {
    if (!preg_match("/^\+?[1-9][0-9]{7,14}$/", $_POST['customer_number'])) {
        $errorMsg .= "Invalid phone number.<br>";
        $success = false;
    }
    $customer_number = sanitize_input($_POST['customer_number']);
}

/* For password */
if (empty($_POST['customer_pwd'])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $_POST['customer_pwd'])) {
        $errorMsg .= "Ensure that password is at least 8 characters long with at least 1 uppercase, 1 lowercase and 1 number.<br>";
        $success = false;
    }
    //password hash to save into DB
    $customer_pwd_hashed = password_hash($_POST['customer_pwd'], PASSWORD_DEFAULT);
}
if (empty($_POST['customer_pwd_confirm'])) {
    $errorMsg .= "Password confirmation is required. Please retype the same password upon creation.<br>";
    $success = false;
} else {
    $pwd = $_POST['customer_pwd'];
    $pwd_confirm = $_POST['customer_pwd_confirm'];
    if ($pwd_confirm != $pwd) {
        $errorMsg .= "Password confirmation is not the same as the given password.<br>";
        $success = false;
    }
}

if ($success) {
    include "essential.inc.php";
    include "nav.inc.php";
    echo "<main class='container'>";
    echo "<section id='registerSuccess'>";
    echo "<h1>Registration successful. Welcome aboard, fellow BookVerse Reader!</h1>";
    echo "<h4> Thank you for signing up, " . $customer_lname . "!</h4><br>";
    echo "<p> Short details of your account. <em>Please do double check if your shipping address and phone number are correct before logging in again!</em> </p>";
    echo "<p> Last Name: " . $customer_lname . "</p>";
    echo "<p> Email: " . $customer_email . "</p>";
    echo "<p> Phone Number: " . $customer_number . "</p>";
    echo "<br><a class='btn btn-success' type='submit' href='index.php'> Return to Login </a><br><br>";
    echo "</section>";
    echo "</main>";
    include "footer.inc.php";
    saveMemberToDB();
} else {
    include "essential.inc.php";
    include "nav.inc.php";
    echo "<main class='container'>";
    echo "<section id='registerFail'>";
    echo "<h1> Oops! </h1>";
    echo "<h4> The following errors were detected: </h4>";
    echo "<p>" . $errorMsg . "</p>";
    echo "<br><br><p><em> Please rectify your inputs as required.</em></p>";
    echo "<br><br><a class='btn btn-danger' type='submit' href='register.php'> Return to Sign Up </a><br><br>";
    echo "</section>";
    echo "</main>";
    include "footer.inc.php";
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function saveMemberToDB() {
    global $customer_lname, $customer_email, $customer_number, $customer_pwd_hashed, $errorMsg, $success;
    // Create database connection.
    $servername = "127.0.0.1"; // Use "localhost" for the local server
    $username = "root"; // Replace with your database username
    $password = "admin"; // Replace with your database password
    $dbname = "BookVerse"; // Replace with your database name
    $conn = new mysqli($servername, $username, $password, $dbname, 3306); // 3306 is the default MySQL port
    //
    // Check connection
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        die('Connection failed: ' . $conn->connect_error);
    } else {
  
        // Prepare the statement:
        $stmt = $conn->prepare("INSERT INTO bookverse.customers (customer_lname,customer_email,customer_number, password_hash, registration_date) VALUES (?, ?, ?, ?, CURRENT_DATE())");
        // Bind & execute the query statement:
        $stmt->bind_param("ssss", $customer_lname, $customer_email, $customer_number, $customer_pwd_hashed);
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

?>