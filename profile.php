<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 13/02/2017
 * Time: 1:58 PM
 */

?>

<?php include_once("include/header.php"); ?>

<?php
if(!$session->is_logged_in()) {redirect_to("login.php");}
?>
<?php
$max_file_size = 1048576;

if (isset($_POST['submit'])) {

//    save photo
    $photo = new photo();
    $photo->attach_file($_FILES['file_upload']);
    if ($photo->save()) {
        $session->message("Photograph uploaded sucessfully.");
//        updata photoid
       User::updatePhotoid($photo->photoid, $session->user_id);

    } else {
        $message = join("<br />", $photo->errors);
    }

//    save motto
    $motto = $_POST['motto'];
    User::updateMotto($motto, $session->user_id);
}

$userid = $session->user_id;
$user = User::find_by_id($userid);
$photoid = $user->portraitid;

if ($photoid!=0) {
    $photo = Photo::find_by_id($photoid);
}

$motto = $user->motto;

?>

<body id="profile">

<?php include_once("include/navigation.php"); ?>

<div class="container">

    <div id="edit-form">

        <div>
            <img id="profile-portrait" class="img-circle" src="<?php
                if (isset($photo)) {
                    $src = $photo->image_path();
                    echo $src;
                } else {
                    $src = 'image/blank-user.jpg';
                    echo $src;
                }
            ?>">
        </div>


        <form action="profile.php" method="post" enctype="multipart/form-data" value="Upload">

            <!-- Picture Upload-->
            <div class="form-group">
                <label for="pictureFile">File input</label>
                <input type="file" id="pictureFile" name="file_upload"  value="<?php echo $max_file_size; ?>">
                <p class="help-block">Please upload your picture</p>
            </div>

            <div class="form-group">
                <label for="inputMotto">Motto</label>
                <input type="text" class="form-control" id="inputMotto" name="motto" placeholder="<?php echo $motto?>">
            </div>

            <button type="submit" name="submit" class="btn btn-default">Edit</button>
        </form>
    </div>

    <?php echo $message; ?>

</div>


</body>

<?php include_once("include/footer.php"); ?>
