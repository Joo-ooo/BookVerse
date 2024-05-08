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
            <h1 class="display-4">BookVerse</h1>
            <h2>Book Archive</h2>
            <h4>Click On Individual Book To Discover More!</h4>
        </header>
        <main class="container">
            <div class="filter_panel">
                <div class="search">
                    <input type="text" class="searchTerm" placeholder="What are you looking for?">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div id= "category-list" class="category-selector row d-flex justify-content-center row-cols-3 g-3">
                    <?php
                    $json_data = file_get_contents('data/categories.json');
                    $categories = json_decode($json_data);

                    echo "<span class='category col-lg-2 col-md-6 col-sm-6 col-12 active' onclick='filterSelection(\"all\", this)'>All</span>";

                    foreach ($categories as $category) {
                        echo "<span class='category col-lg-2 col-md-6 col-sm-6 col-12' onclick='filterSelection(\"" . strtolower(str_replace(' ', '_', $category)) . "\", this)'>" . $category . "</span>";
                    }
                    ?>
                </div>
            </div>
            <div id="card-deck" class="row row-cols-3 g-3">
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

                    // Find and limit the query to 12 documents
                    $cursor = $collection->find([], ['limit' => 12]);

                    // Iterate through the cursor and print selected fields
                    foreach ($cursor as $document) {
                        $isOwned = in_array($document->_id, $_SESSION['book_owned']);
                        $isBookmark = in_array($document->_id, $_SESSION['book_bookmark']);

                        $ownedClass = $isOwned ? 'owned' : ''; // Define a CSS class for owned books
                        $bookmarkClass = $isBookmark ? 'bookmark' : ''; // Define a CSS class for owned books

                        echo "<div class='card_container content col-lg-3 col-md-6 col-sm-6 col-12 active $ownedClass $bookmarkClass' data-category='" . strtolower(str_replace('|', ' ', $document->genres)) . "'>" .
                        "<a href='bookdetails.php?bookid=" . strtolower(str_replace(' ', '_', $document->_id)) . "'>" .
                        "<div class='card h-100'>" .
                        "<img class='card-img-top' src=" . $document->image_url . " alt='Card image cap' loading='lazy'>" .
                        "<div class='card-body $ownedClass $bookmarkClass'>" . // Add owned class to card-body
                        "<h5 class='card-title'>" . $document->book_title . "</h5>" .
                        "<p class='card-book-isbn'>ISBN: " . number_format($document->book_isbn, 0, '', '') . "</p>" .
                        "<p class='card-author'>Authors: " . str_replace('|', ', ', $document->book_authors) . "</p>" .
                        "<p class='card-rating'>Rating: " . $document->book_rating . "</p>" .
                        "<p class='card-genres'>Genres: " . str_replace('|', ', ', $document->genres) . "</p>" .
                        ($isOwned ? "<p class='card-owned'><strong>Owned</strong></p>" : "") . // Display additional information for owned books
                        ($isBookmark ? "<p class='card-owned'><strong>Bookmark</strong></p>" : "") . // Display additional information for Bookmark books
                        "</div>" .
                        "</div>" .
                        "</a>" .
                        "</div>";
                    }
                } catch (Exception $e) {
                    printf($e->getMessage());
                }
                ?>
            </div>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
    <link rel="stylesheet" href="css/book_page.css">
    <link rel="stylesheet" href="css/card_style.css">
    <script defer src="js/sort.js"></script>
</html>
