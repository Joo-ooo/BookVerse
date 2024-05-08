<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <?php
    if (@$_SESSION['role'] == "customer") {
        echo '<a class="navbar-brand" href="books.php"><img src="images/logo/book.png" alt="book" title="book_logo" style="width:40px;"/></a>';
    } else {
        echo '<a class="navbar-brand" href="index.php"><img src="images/logo/book.png" alt="book" title="book_logo" style="width:40px;"/></a>';
    }
    ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <?php
        if (@$_SESSION['role'] == "customer") {
            ?>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="books.php">Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mycollection.php">My Collection</a>
                </li>
            </ul>
            <ul class = "navbar-nav ml-auto">
                 <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a> <!-- redirect to login.php after logging out-->
                </li>
            </ul>    
        <?php }
        ?>
    </div>
</nav>