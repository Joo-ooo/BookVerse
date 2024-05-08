<?php
include "sessiontimeout.php";
?>
<html>
    <head>
        <title>Student Panel</title>
        <?php
        include "essential.inc.php";
        ?>
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/card_style.css">        
        <style>
            .card {
                text-align: center ;
                padding-top: 20px;
                padding-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <header class="jumbotron text-center">
            <h1 class="display-4">BookVerse</h1>
            <h2>Book Archive Portal</h2>
        </header>

        <main class="container">

            <div class="login">
                <div class="logincontainer row-cols-3 g-3" style="justify-content: center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="login-form">
                            <h2>User Login</h2>
                            <form action="process_login_db.php" method="post">
                                <p>
                                    <label for="user_email">Email: <span>*</span></label>
                                    <input type="text" id="user_email" name="user_email" placeholder="Enter Email" required>
                                </p>
                                <p>
                                    <label for="user_pwd">Password: <span>*</span></label>
                                    <input type="password" id="user_pwd" name="user_pwd" placeholder="Enter Password" required>
                                </p>
                                <p>
                                    <input type="submit" value="Sign In">
                                </p>
                                <p>
                                    <a href="register.php">Register for New User</a>
                                </p>
                                <p>
                                    <a href="#">Forget password?</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>