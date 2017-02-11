



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SMP by Luke</title>
    <link href="_/css/bootstrap.min.css" rel="stylesheet">

</head>
<body id="home">


<div class="container">

    <div id="main-content" class="content row">

        <!-- Bar on the Left -->
        <div  class="sidebar col col-lg-3">

            <!-- Profile section-->
            <div id="profile" class="content-block">
                <div id="profile-image">
                    <img src="image/profile-image/hardy.jpg" class="img-circle">
                </div>
                <div id="profile-name">
                    Tom Hardy
                </div>
                <div id="profile-sentence">
                    I starred in Batman as Bane.
                </div>
                <div id="profile-network">
                    <div id="profile-followed">Followed:4</div>
                    <div id="profile-following">Following1</div>
                </div>
            </div>

        </div>

        <!-- Main Post Area -->
        <div class="mainposts col col-lg-6 ">

            <!-- Post Input Area -->
            <div id="post-input-container" class="content-block form-group">
                <input type="text" class="form-control" id="post-input" placeholder="Write Anythng">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>

            <!-- Post Display Area -->
            <div id="posts-container">
                <div class="post-container row">
                    <div id="post-portrait" class="media-left">
                        <img src="image/profile-image/hardy.jpg" class="img-circle">
                    </div>
                    <div id="post-body" class="media-body">
                        <div id="post-body-name">Tome Hardy</div>
                        <div id="post-body-text"> Aenean lacinia bibendum nulla sed consectetur. Vestibulum id ligula porta felis euismod semper. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        </div>
                        <div id="post-body-gallery photogrid">
                            <img src="image/landscape/1.jpg" >
                            <img src="image/landscape/2.jpg" >
                            <img src="image/landscape/3.jpg" >
                            <img src="image/landscape/4.jpg" >
                            <img src="image/landscape/5.jpg" >
                            <img src="image/landscape/6.jpg" >
                            <img src="image/landscape/7.jpg" >
                            <img src="image/landscape/8.jpg" >
                            <img src="image/landscape/9.jpg" >
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bar on the Right -->
        <div id="right-sidebar" class="sidebar col col-lg-3">

            <!-- Follow Area Container -->
            <div id="people-to-follow-container container">

                    <!-- Title of the Follow Area -->
                <div class="container row">
                    <div class="col col-lg-2">Likes</div>
                    <div class="col col-lg-10">
                        <a href="">
                            view all
                        </a>
                    </div>
                </div>

                    <!-- People to Follow -->
                <div class="follow-block media">
                    <div id="follow-portrait" class="media-left">
                        <img src="image/profile-image/putin.jpg" class="image-circle">
                    </div>
                    <div id="follow-body" class="media-body">
                        <div id="follow-name">Putin</div>
                        <div id="follow-button">
                            <a class="btn btn-default" href="#" role="button">Follow</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div><!-- container -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="_/js/myscript.js"></script>
</body>
</html>