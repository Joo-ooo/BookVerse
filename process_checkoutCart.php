<?php

include "sessiontimeout.php";
CheckOutCart();

function CheckOutCart() {
    $t = time();
    $date = date("YmdhisA", $t);

    if (isset($_SESSION['customer_id']) && isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        $customer_id = $_SESSION['customer_id'];

        foreach ($_SESSION['cart'] as $book_id => $quantity) {

            $servername = "127.0.0.1"; // Use "localhost" for the local server
            $username = "root"; // Replace with your database username
            $password = "admin"; // Replace with your database password
            $dbname = "BookVerse"; // Replace with your database name
            $conn = new mysqli($servername, $username, $password, $dbname, 3306); // 3306 is the default MySQL port
            // Check connection
            if ($conn->connect_error) {
                echo "Connection failed: " . $conn->connect_error;
                die('Connection failed: ' . $conn->connect_error);
            } else {
                // Prepare the statement:
                $stmt = $conn->prepare("INSERT INTO bookverse.purchases (customer_id, book_id, purchase_date) VALUES (?, ?, CURRENT_DATE())");
                // Bind & execute the query statement:
                $stmt->bind_param("is", $_SESSION['customer_id'], $book_id);
                if (!$stmt->execute()) {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $stmt->close();
            }
            $conn->close();

            // Add the purchased book ID to $_SESSION['book_owned']
            if (!in_array($book_id, $_SESSION['book_owned'])) {
                $_SESSION['book_owned'][] = $book_id;
            }
        }
        $_SESSION['cart'] = [];
        header("Location: /response.php");
    } else {
        header("Location: /response.php");
    }
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
