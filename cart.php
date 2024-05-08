<?php
session_start();
include "sessiontimeout.php";
?>
<html lang="en">
    <head>
        <title>Shopping Cart</title>
        <?php
        include "essential.inc.php";
        include "nav.inc.php";
        ?>
        <link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="css/bookdetails_style.css">
    </head>
    <body>
        <main class="container emp-profile">
            <h1>Shopping Cart</h1><br>
            <form action="process_checkoutCart.php" method="post">
                <div class="cart-list" id="cart-list">
                    <?php
                    // Assuming you have already established a connection to MongoDB
                    require 'vendor/autoload.php';

                    use Exception;
                    use MongoDB\Client;

// Replace the following connection details with your MongoDB connection information
                    $uri = 'mongodb+srv://ruifeng:2Z9UTRNdTdDTCOdD@cluster0.1un9blx.mongodb.net/?retryWrites=true&w=majority';

                    try {
                        $client = new MongoDB\Client($uri);
                        $database = $client->selectDatabase('BookVerse');
                        $collection = $database->selectCollection('collection_bookverse');

                        // Check if the cart is not empty
                        if (!empty($_SESSION['cart'])) {
                            // Get the book IDs from the cart
       
                            $bookIds = array_keys($_SESSION['cart']);
                            // Convert the book IDs to ObjectId instances
                            $bookIds = array_map(function ($id) {
                                return new MongoDB\BSON\ObjectId($id);
                            }, $bookIds);
                            $filter = ['_id' => ['$in' => $bookIds]];
                            // Perform the query
                            $cursor = $collection->find($filter);
                            foreach ($cursor as $document) {
                                echo "<div class='card'>" .
                                "<div class='row product-information'>" .
                                "<div class='col-md-12'>" .
                                "<div class='row'>" .
                                "<div class='col-md-6'>" .
                                "<img class='card-img-top' src='" . $document->image_url . "' alt='Card image cap' loading='lazy'>" .
                                "</div>" .
                                "<div class='col-md-6'>" .
                                "<h5 class='card-title'>" . $document->book_title . "</h5>" .
                                "<p class='card-text'>" . str_replace('|', ', ', $document->book_authors) . "</p><br>" .
                                "<strong>Item Description:</strong><br>" .
                                "<p class='card-description'>" . $document->book_desc . "</p>" .
                                "<p class='card-price'><strong>SGD$" . $document->price . "</strong></p>" .
                                "</div>" .
                                "</div>" .
                                "</div>" .
                                "<div class='justify-content-center align-self-center'>" .
                                "<input type='hidden' id='" . strtolower(str_replace(' ', '_', $document->_id)) . "' name='" . strtolower(str_replace(' ', '_', $document->_id)) . "'>" .
                                "</div>" .
                                "</div>" .
                                "</div>";
                            }
                        } else {
                            echo "<h2>Cart is empty!</h2>";
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </div>
                <?php
                // Check if the cart is not empty
                if (!empty($_SESSION['cart'])) {
                    echo "<p class='mt-3'>" .
                    "<input class='purchase-button addtocart' type='submit' value='Purchase'>" .
                    "</p>";
                }
                ?>
            </form>
        </main>
        <button id="returnToTopBtn" class="btn btn-primary btn-lg bounce" title="Return to Top"><i class="fa fa-arrow-up"></i></button>
    </body>
     <script>
        // Get the button element
        var returnToTopBtn = document.getElementById('returnToTopBtn');

        // Add a click event listener to scroll to the top with smooth animation
        returnToTopBtn.addEventListener('click', function () {
            // Scroll to the top with smooth behavior
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Add a scroll event listener to show/hide the button
        window.addEventListener('scroll', function () {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                returnToTopBtn.style.display = 'block';
            } else {
                returnToTopBtn.style.display = 'none';
            }
        });
    </script>
    <?php
    include "footer.inc.php";
    ?>
</html>
