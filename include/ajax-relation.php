<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 16/02/2017
 * Time: 9:15 PM
 */

require_once("initialize.php");

$followerid;
$followedid;
$is_followed;

if (!empty($_GET['followerid'] && !empty($_GET['followedid']))){
    $followerid = ($_GET['followerid']);
    $followedid = ($_GET['followedid']);
}

if (Relation::is_followed($followerid, $followedid)) {
    if(Relation::unfollow($followerid, $followedid)){
        $is_followed = 'false';
    }

} else {
    if (Relation::follow($followerid, $followedid)){
        $is_followed = 'true';
    }
}

echo $is_followed;
