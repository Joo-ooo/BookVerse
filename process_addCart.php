<?php
session_start();
addItemsCart();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function addItemsCart() {
    if (!empty($_POST['_id'])) {
        $book = sanitize_input($_POST['_id']);

        // Add the product to the cart
        $_SESSION['cart'][$book] = true;
    }
}
?>
<?php
include "sessiontimeout.php";
?>
<html>
    <head>
        <?php
        include "essential.inc.php";
        ?>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?> 
        <header class="jumbotron text-center">
            <h3 class="display-4">Product Details</h3>
        </header>
        <main class="container">
            <div id="product-details">
                <h2 style="margin-bottom: 30px;">Books have been added to the cart!</h2>
            </div>
            <a class="back-button" href="books.php">Back To Browsing Books</a>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
    <link rel="stylesheet" href="css/bookdetails_style.css">
</html>
