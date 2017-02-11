<?php include_once("include/header.php"); ?>

<body id="signup">

<?php include_once("include/navigation.php"); ?>

<div class="container">

    <div id="main-content" class="content">

        <div id="signup-form">
            <form>
                <div class="form-group">
                    <label for="inputUserName">Username</label>
                    <input type="text" class="form-control" id="inputUserName" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" class="form-control" id="inputFirstName" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" class="form-control" id="inputLastName" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Sign Up</button>
            </form>
        </div>

    </div>

</div><!-- container -->
</body>

<?php include_once("include/footer.php"); ?>
