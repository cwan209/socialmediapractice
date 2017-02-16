<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 16/02/2017
 * Time: 4:15 PM
 */

require_once("initialize.php");

$page;
$userid;
$per_page = 10;
$total_count = 1000;


if (!empty($_GET['page'] && !empty($_GET['userid']))){
    $page = ($_GET['page']);
    $userid = ($_GET['userid']);
}

$pagination = new Pagination($page, $per_page, $total_count);

// Find all followers
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
$sql = $sql . $sql2 . ' order by ts desc limit ' . $per_page . ' offset ' . $pagination->offset();

// Find all the posts
$posts = Post::find_by_sql($sql);
foreach ($posts as $key=>$otherPost){

?>

<div class="post-container row" >

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