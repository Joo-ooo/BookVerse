<?php

$user_email = $user_pwd = $errorMsg = "";
$success = true;

if (empty($_POST['user_email']) || empty($_POST['user_pwd'])) {
    $errorMsg .= "Email or Password is missing! Please ensure that you have both inputs.";
    $success = false;
} else {
    if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email format.<br>";
        $success = false;
    }
    $user_email = sanitize_input($_POST['user_email']);
    authenticateUser();
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function authenticateUser() {
    global $user_id, $user_email, $errorMsg, $success, $user_pwd, $db_pwd_hashed;

    $servername = "127.0.0.1"; // Use "localhost" for the local server
    $username = "root"; // Replace with your database username
    $password = "admin"; // Replace with your database password
    $dbname = "BookVerse"; // Replace with your database name
    $conn = new mysqli($servername, $username, $password, $dbname, 3306); // 3306 is the default MySQL port
    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT customer_id, customer_fname, customer_lname, customer_email, password_hash FROM bookverse.customers WHERE customer_email=?");

        // Bind & execute the query statement:
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Note that email field is unique, so should only have one row in the result set.
            $row = $result->fetch_assoc();
            session_start();
            session_regenerate_id();
            $token = hash("sha256", uniqid(rand(), TRUE));
            $_SESSION['token'] = $token;
            $_SESSION['token_time'] = time();
            $_SESSION['user_email'] = $user_email;
            $_SESSION['cart'] = [];
            $_SESSION['role'] = "customer"; //setting role of user session to customer. to verify is logged in and is user to make some website unaccessible
            $_SESSION['customer_id'] = $row['customer_id'];
            $_SESSION['customer_lname'] = $row['customer_lname'];
            $user_pwd = $row['password_hash'];
            // Check if the password matches
            if (!password_verify($_POST['user_pwd'], $user_pwd)) {
                $errorMsg .= "Email not found or password doesn't match...";
                $success = false;
            }
        } else {
            $errorMsg = "Email not found or password doesn't match.";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

if ($success) {
    // Retrieve all book IDs owned by the customer
    $customer_id = $_SESSION['customer_id'];

    $servername = "127.0.0.1";
    $username = "root";
    $password = "admin";
    $dbname = "BookVerse";
    $conn = new mysqli($servername, $username, $password, $dbname, 3306);
    $book_prefer = [];
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    } else {
        // Prepare the statement to fetch book IDs owned by the customer
        $stmt = $conn->prepare("SELECT book_id FROM bookverse.purchases WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $book_owned = [];

        while ($row = $result->fetch_assoc()) {
            $book_owned[] = $row['book_id'];
        }

        $stmt->close();

        // Store the book IDs in the session
        $_SESSION['book_owned'] = $book_owned;

        $stmt2 = $conn->prepare("SELECT book_id FROM bookverse.bookmark WHERE customer_id = ?");
        $stmt2->bind_param("i", $customer_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $book_bookmark = [];

        while ($row = $result2->fetch_assoc()) {
            $book_bookmark[] = $row['book_id'];
        }

        // Store the book IDs in the session
        $_SESSION['book_owned'] = $book_owned;
        $_SESSION['book_bookmark'] = $book_bookmark;

        $stmt2->close();
    }
    $conn->close();

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
