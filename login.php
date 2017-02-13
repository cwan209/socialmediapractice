<?php include_once("include/header.php"); ?>

<?php

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($result_array = User::authenticate($username, $password)) {

        // login
        $session->login($result_array);
        $session->message('logged in');
        redirect_to('index.php');

    } else {
        $session->message('Wrong Combination, Please Retry');
    }
}

?>

    <body id="signup">

    <?php include_once("include/navigation.php"); ?>

    <div class="container">

        <div id="main-content" class="content">

            <div id="signup-form">
                <form action="login.php" method="post">

                    <div class="form-group">
                        <label for="inputUserName">Username</label>
                        <input type="text" class="form-control" id="inputUserName" name="username" placeholder="Username">
                    </div>

                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                    </div>

                    <button type="submit" name="submit" class="btn btn-default">Log In</button>
                </form>
            </div>

            <div id="test">
                <?php if (isset($_POST['submit']))
                {
                    echo $session->message();
                }
                ?>
            </div>

        </div>

    </div><!-- container -->
    </body>

<?php include_once("include/footer.php"); ?>
<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 13/02/2017
 * Time: 12:22 AM
 */