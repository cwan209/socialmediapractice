<!-- Navigation Bar -->
<nav class="navbar navbar-default">
    <div class="container-fluid">

        <!-- Brand display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                Brand
                <!--                    <img src="image/logo.jpg">-->
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <!-- Home, Profile, Message Links -->
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home<span class="sr-only">(current)</span></a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="#">Message</a></li>
            </ul>

            <!-- Search Bar Currently Unavailable -->
            <!--                <form class="navbar-form navbar-right">-->
            <!--                    <div class="form-group">-->
            <!--                        <input type="text" class="form-control" placeholder="Search">-->
            <!--                    </div>-->
            <!--                    <button type="submit" class="btn btn-default">Search</button>-->
            <!--                </form>-->

            <!-- Login and Signup -->
            <ul class="nav navbar-nav navbar-right">
                <?php if ($session->is_logged_in()) {
                    echo '
                    <li><a href="logout.php">Logout</a></li>';
                }
                else {
                    echo '
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                ';
                }
                ?>

            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>