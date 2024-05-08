<?php
session_start();
include "sessiontimeout.php";
?>

<html lang='en'>
    <head>
        <?php
        include "essential.inc.php";
        ?>
        <link rel="stylesheet" href="css/register.css">
        <title> User Registration </title>
        <script type="text/javascript">
            var onloadCallback = function() {
              grecaptcha.render('html_element', {
                'sitekey' : '6LfuqUMlAAAAAPZUlLtnk_NujyARbKAmpfqMZzPW'
              });
            };
        </script>
    </head>
    <body>
        <?php include "nav.inc.php"; ?>
        <main class="container">
            <div class="login">
                <div class="logincontainer row-cols-3 g-3">
                    <div class="left col-lg-6 col-md-6 col-sm-6 col-12 " style="background: tomato;">
                        <div class="login-text">
                            <h2>Existing User?</h2>
                            <p>Click the button below <br> to go to Sign in page.</p>
                            <br>
                            <a href="login.php" class="btn">Sign In Here</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 ">
                        <div class="login-form">
                            <h2>Register for Account: </h2>
                            <form action="process_register.php" method="post">
                                <p>
                                    <label for="customer_lname">Last Name: <span>*</span></label>
                                    <input type="text" id="customer_lname" maxlength="45" name="customer_lname" placeholder="Enter last name" required>
                                </p>
                                <p>
                                    <label for="customer_email">Email: <span>*</span></label>
                                    <input type="text" id="customer_email" name="customer_email" placeholder="Enter Email" required>
                                </p>
                                <p>
                                    <label for="customer_number">Number: <span>*</span></label>
                                    <input type="number" id="customer_number" name="customer_number" placeholder="Enter Your Number for Contact" required>
                                </p>
                                <p>
                                    <label for="customer_pwd">Password: <span>*</span></label>
                                    <input type="password" id="customer_pwd" name="customer_pwd" placeholder="Enter Password" required>
                                </p>
                                <p>
                                    <label for="customer_pwd_confirm">Re-Confirm Password: <span>*</span></label>
                                    <input type="password" id="customer_pwd_confirm" name="customer_pwd_confirm" placeholder="Retype password" required>
                                </p>
                                <p>
                                    <input type="checkbox" style="width:15px; height:15px; display:inline-block" name="agree" required> *Agree to terms and conditions 
                                </p>
                                <p>
                                    <input class="register-button" type="submit" value="Sign Up">
                                </p>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "footer.inc.php"; ?>
    </body>
</html>