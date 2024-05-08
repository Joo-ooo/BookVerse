
<?php
session_start();
include "sessiontimeout.php";
?>
<html>
    <head>
        <title> Shopping Cart </title>
        <?php
        include "essential.inc.php";
        include "nav.inc.php";
        ?>
        <link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="css/profile.css">
        <script defer src="js/fetch.js"></script>
    </head>
    <body>
        <div class="container emp-profile justify-content-center ">
            
            <?php
            if(@$_SESSION['customer_id']){
            echo "<h1> Thanks you for shopping at BookVerse!</h1>".

           "<p> Book added to Your Collection! </p> ";
            }
            else
            {
                 echo "<h1>Please Login!</h1>".
                        "<p>Only registered customer able to purchase the products!</p><a class='purchase-button addtocart' href='index.php'>Please Login</a> ";
                 
            }
                ?>

        </div>
    </body>
    <?php
    include "footer.inc.php";
    ?>
</html>