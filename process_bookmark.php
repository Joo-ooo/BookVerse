<?php

include "sessiontimeout.php";
addToBookmark();

function addToBookmark() {
    if (isset($_SESSION['customer_id']) && isset($_POST['_id'])) {
        $customer_id = $_SESSION['customer_id'];
        $book_id = $_POST['_id'];

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
            // Check if the book is already bookmarked
            $stmt_check = $conn->prepare("SELECT * FROM bookverse.bookmark WHERE customer_id = ? AND book_id = ?");
            $stmt_check->bind_param("ii", $customer_id, $book_id);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result->num_rows === 0) {
                // Book is not bookmarked, insert into the bookmark table
                $stmt_insert = $conn->prepare("INSERT INTO bookverse.bookmark (customer_id, book_id) VALUES (?, ?)");
                $stmt_insert->bind_param("ii", $customer_id, $book_id);
                $stmt_insert->execute();
                $stmt_insert->close();
                
                // Add the bookmarked book ID to $_SESSION['book_bookmark']
                $_SESSION['book_bookmark'][] = $book_id;
            }

            $stmt_check->close();
        }

        $conn->close();
    }

    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/response.php";
    header("Location: $referrer"); // Redirect back to the original page or /response.php if no referrer
}
?>
