<?php
// Check if a session is active
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "essential.inc.php"; ?>
        <link rel="stylesheet" href="css/logout.css">
        <title> Logging Out </title>
    </head>
    <body>
        <?php
        // Unset (clear) all variables in the $_SESSION array
        session_unset();

        // Optionally, destroy the session to completely end it
        session_destroy();
        include "nav.inc.php";
        ?>

        <main class='container'>
            <div class='user_notification'>
                <h4>Logout Successful</h4>
                <a type='button' class='btn btn-success' href='index.php'>Back to Homepage</a>
            </div>
        </main>
        <?php include "footer.inc.php"; ?>
    </body>
</html>