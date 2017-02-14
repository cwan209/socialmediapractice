<?php include_once("include/header.php"); ?>

<?php
if(!$session->is_logged_in()) {redirect_to("login.php");}

$userid = $session->user_id;
$user = User::find_by_id($userid);
$photoid = $user->portraitid;

if ($photoid!=0) {
    $portrait = Photo::find_by_id($photoid);
}

$full_name = $user->full_name();
$motto = $user->motto;

if (isset($_POST['submit'])) {

//  post instantiation
    $post = new Post();
    $post->userid = $userid;
    $post->post_content = $_POST['posttext'];

//  create post
    if ($post->create()) {
    }
}

if (isset($_GET['followid'])){
    $followid = $_GET['followid'];
    $followedid = $_GET['followedid'];

    if ($_GET['follow'] == 1) {
        if(Relation::follow($followid,$followedid)){
            $followSuccess = true;
        } else {

        }
    } else if ($_GET['follow'] == 0){
        if(Relation::unfollow($followid,$followedid)){
            $unfollowSuccess = true;
        } else {

        }
    }
}

?>

<body id="home">

    <?php include_once("include/navigation.php"); ?>

    <div class="container">

        <div id="main-content" class="content row">

            <!-- Bar on the Left -->
            <div id="left-sidebar" class="sidebar col col-lg-3">

                <!-- Profile section-->
                <div id="profile" class="content-block">
                    <div id="profile-image">
                        <img id="index-portrait" class="img-circle portrait-image" src="<?php
                        if (isset($portrait)) {
                            $src = $portrait->image_path();
                            echo $src;
                        } else {
                            $src = 'image/blank-user.jpg';
                            echo $src;
                        }
                        ?>">
                    </div>
                    <div id="profile-name">
                        <?php echo $full_name; ?>
                    </div>
                    <div id="profile-sentence">
                        <?php echo $motto; ?>
                    </div>
                    <div id="profile-network">
                        <div id="profile-followed">Followed: <?php echo Relation::get_number_of_followed($userid); ?></div>
                        <div id="profile-following">Following: <?php echo Relation::get_number_of_follow($userid); ?></div>
                    </div>
                </div>

            </div>

            <!-- Main Post Area -->
            <div id="mainposts" class="col col-lg-6">

                <!-- Post Input Area -->
                <div id="post-input-container" class="content-block form-group">
                    <form action="index.php" method="post">
                        <input type="text" name="posttext" class="form-control" id="post-input" placeholder="Write Anythng">
                        <button type="submit" name="submit" class="btn btn-default">Post it</button>
                    </form>
                </div>

                <!-- Post Display Area -->


                <div class="posts-container">

                    <?php
                    $sql = 'select * from follow where followid = ' . $userid;
                    $follows = Relation::find_by_sql($sql);
                    $postArray = [];

                    // Write Query for posts by timestamp
                    $sql = 'select * from post where ';
                    $sqlarray = array();
                    foreach ($follows as $relation) {
                        $sqlsnippet = 'userid = ' . $relation->followedid;
                        $sqlarray[] = $sqlsnippet;
                    }

                    $sqlarray[] = 'userid = ' . $userid;

                    $sql2 = implode($sqlarray, ' or ');
                    $sql = $sql . $sql2 . ' order by ts desc';

                    $posts = Post::find_by_sql($sql);

                    foreach ($posts as $key=>$otherPost){

                    ?>

                    <div class="post-container row">

                        <!--  post portrait-->
                        <div id="post-portrait" class="media-left">
                            <img class="img-circle portrait-image" src="
                            <?php
                            $postUser = User::find_by_id($otherPost->userid);
                            if ($postUser->portraitid!=0) {
                                $portrait = Photo::find_by_id($postUser->portraitid);
                                $src = $portrait->image_path();
                                echo $src;
                            } else {
                                $src = 'image/blank-user.jpg';
                                echo $src;
                            }
                            ?>">
                        </div>

                        <!--  post content-->
                        <div id="post-body" class="media-body">
                            <div id="post-body-name">
                                <?php
                                $postUser = User::find_by_id($otherPost->userid);
                                echo $postUser->full_name(); ?>
                            </div>
                                <div id="post-body-text"><?php echo $otherPost->post_content; ?>
                            </div>
                            <div id="post-body-time" class="text-right">
                                <?php echo $otherPost->ts; ?>
                            </div>
                            <div id="post-body-gallery photogrid">
                            </div>
                        </div>
                    </div>

                    <?php } ?>
                </div>
            </div>

            <!-- Bar on the Right -->
            <div id="right-sidebar" class="sidebar col col-lg-3">

                <!-- Follow Area Container -->
                <div id="people-to-follow-container">

                    <!-- Title of the Follow Area -->
                    <div class="row">
                        <div class="col col-lg-2">Likes</div>
                        <div class="col col-lg-10">
                            <a href="followlist.php">
                                view all
                            </a>
                        </div>
                    </div>

                    <!-- People to Follow -->
                    <?php
                    $sql = 'select * from user where userid <> ' . $userid . ' order by userid';
                    $users = User::find_by_sql($sql);
                    foreach ($users as $otherUser) {
                    ?>
                    <div class="follow-block media">
                        <div id="follow-portrait" class="media-left">
                            <img class="img-circle portrait-image" src="<?php
                            if ($otherUser->portraitid!=0) {
                                $otherPortrait = Photo::find_by_id($otherUser->portraitid);
                                $src = $otherPortrait->image_path();
                                echo $src;
                            }  else {
                                $src = 'image/blank-user.jpg';
                                echo $src;
                            }
                            ?>">
                        </div>
                        <div id="follow-body" class="media-body">
                            <div id="follow-name"><?php echo $otherUser->full_name(); ?></div>
                            <div id="follow-button">
                                <?php if (!Relation::is_followed($user->userid, $otherUser->userid)) {?>
                                <a class="btn btn-default"
                                   href="index.php?followid=<?php echo $user->userid; ?>&followedid=<?php echo $otherUser->userid; ?>&follow=1"
                                   role="button">Follow</a>
                                <?php } else {?>
                                <a class="btn btn-default"
                                   href="index.php?followid=<?php echo $user->userid; ?>&followedid=<?php echo $otherUser->userid; ?>&follow=0"
                                   role="button">Unfollow</a>
                                <?php }?>
                            </div>
                        </div>
                    </div>

                    <?php } ?>

                </div>

            </div>

        </div>

    </div><!-- container -->
</body>

<?php include_once("include/footer.php"); ?>
