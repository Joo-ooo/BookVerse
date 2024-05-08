<?php
session_start();
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
            <h3 class="display-4">Book Details</h3>
        </header>
        <main class="container">
            <a class="back-button" href="books.php">Back To Browsing Books</a>
            <div id="product-details" class="details-container">
                <?php
                require 'vendor/autoload.php';

                use Exception;
                use MongoDB\Client;
                use MongoDB\Driver\ServerApi;

$uri = 'mongodb+srv://ruifeng:2Z9UTRNdTdDTCOdD@cluster0.1un9blx.mongodb.net/?retryWrites=true&w=majority';
                // Specify Stable API version 1
                $apiVersion = new ServerApi(ServerApi::V1);
                // Create a new client and connect to the server
                $client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);
                try {
                    // Select the database you want to list collections from
                    $database = $client->selectDatabase('BookVerse');
                    $collection = $database->selectCollection('collection_bookverse');

                    // Fetch book details based on bookid
                    $bookId = isset($_GET['bookid']) ? $_GET['bookid'] : null;

                    if ($bookId) {
                        // Assuming 'id' is a string field
                        $filter = ['_id' => new MongoDB\BSON\ObjectId($bookId)];
                        $document = $collection->findOne($filter);
                        if ($document) {

                            $button = '';

                            // Check if the book is already in the cart
                            if (in_array($bookId, array_keys($_SESSION['cart']))) {
                                $button = "<button class='inactiveAdd' type='submit' disabled>Book Already In Cart</button>";
                            } else {
                                // Check if the book is already owned
                                $isOwned = in_array($bookId, $_SESSION['book_owned']);

                                if ($isOwned) {
                                    $button = "<button class='inactiveAdd' type='button' disabled>Book Already Owned</button>";
                                } else {
                                    // Display the add to cart button
                                    $button = "<form action='process_addCart.php' method='post'>" .
                                            "<input type='hidden' id='_id' name='_id' value='{$document->_id}'>" .
                                            "<button class='addtocart' type='submit'>Add to Cart</button>" .
                                            "</form>";
                                }
                            }
                              // Check if the book is already in the bookmark
                            if (in_array($bookId, array_keys($_SESSION['book_bookmark']))) {
                                $button_bk = "<form action='process_unbookmark.php' method='post'>" .
                                        "<input type='hidden' id='_id' name='_id' value='{$document->_id}'>" .
                                        "<button class='unbookmark' type='submit'>Un-Bookmark</button>" .
                                        "</form>";
                            } else {
                                // Check if the book is already owned
                                $isBookmark = in_array($bookId, $_SESSION['book_bookmark']);

                                if ($isBookmark) {
                                    $button_bk = "<form action='process_unbookmark.php' method='post'>" .
                                            "<input type='hidden' id='_id' name='_id' value='{$document->_id}'>" .
                                            "<button class='unbookmark' type='submit'>Un-Bookmark</button>" .
                                            "</form>";
                                } else {
                                    // Display the bookmark button
                                    $button_bk = "<form action='process_bookmark.php' method='post'>" .
                                            "<input type='hidden' id='_id' name='_id' value='{$document->_id}'>" .
                                            "<button class='bookmark' type='submit'>Bookmark</button>" .
                                            "</form>";
                                }
                            }
                          
                            echo "<div class='card_container content row row-cols-3 g-3' data-category='" . str_replace('_', ' ', $document['category_name']) . "'>" .
                            "<div class='col-lg-6 col-md-6 col-sm-12 col-12'>" .
                            "<div class='product-image'>" .
                            "<img class='card-img-top' src='" . $document->image_url . "' alt='Card image cap' loading='lazy'>" .
                            "</div>" .
                            "</div>" .
                            "<div class='col-lg-6 col-md-6 col-sm-12 col-12'>" .
                            "<div class='product-information'>" .
                            $button_bk .
                            "<h5 class='card-title'>" . $document->book_title . "</h5>" .
                            "<p class='card-text'>" . str_replace('|', ', ', $document->book_authors) . "</p>" .
                            "<strong>Item Description:</strong><br>" .
                            "<p class='card-description'>" . $document->book_desc . "</p>" .
                            "<p class='card-price'><strong>SGD$" . $document->price . "</strong></p>" .
                            "<p class='card-text'>" .
                            $button .
                            "<p class='card-category'>Category: " . str_replace('|', ', ', $document->genres) . "</p>" .
                            "</div>" .
                            "<div>" .
                            "</div>";
                        } else {
                            echo "Book not found.";
                        }
                    } else {
                        echo "Invalid bookid parameter.";
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
    <link rel="stylesheet" href="css/bookdetails_style.css">
</html>