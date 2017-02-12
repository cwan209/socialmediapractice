<?php include_once("include/header.php"); ?>

<?php

    if (isset($_POST['submit'])) {

        $user = new User();

        $user->firstname = $_POST['firstname'];
        $user->lastname = $_POST['lastname'];
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];

        if (User::checkrepeat($user->username, $user->password)) {
            // create new user
            if ($user->create()) {
                $result = 'User successfully created.';
            } else {
                $result = 'Signup Failed';
            }
        } else {
            $result = 'Username already taken';
        }
    }

?>

<body id="signup">

<?php include_once("include/navigation.php"); ?>

<div class="container">

    <div id="main-content" class="content">

        <div id="signup-form">
            <form action="signup.php" method="post">

                <div class="form-group">
                    <label for="inputUserName">Username</label>
                    <input type="text" class="form-control" id="inputUserName" name="username" placeholder="Username">
                </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" class="form-control" id="inputFirstName" name="firstname" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" class="form-control" id="inputLastName" name="lastname" placeholder="Last Name">
                </div>
                <button type="submit" name="submit" class="btn btn-default">Sign Up</button>
            </form>
        </div>

        <div id="test">
            <?php if (isset($_POST['submit']))
            {
                echo $result;
            }
            ?>
        </div>

    </div>

</div><!-- container -->
</body>

<?php include_once("include/footer.php"); ?>
