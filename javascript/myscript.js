/**
 * Created by asus on 11/02/2017.
 */



var successResponse = true;
var mainPost = document.getElementById('mainposts');

// Get User id
var home = document.getElementById('home');
var userid = parseInt(home.getAttribute('data-user'));

function loadMore() {

    successResponse = false;

    // Get the last post container
    var postContainers = document.getElementsByClassName("posts-container");
    var postContainer = postContainers[postContainers.length-1];

    // Get Page Number
    var page = postContainer.getAttribute('data-page');
    var pageNumber = parseInt(page);

    var xhr = new XMLHttpRequest();
    var url = 'include/ajax-post.php?page=' + page + '&userid=' + userid;
    xhr.open('GET', url, true);

    xhr.onreadystatechange = function () {
        console.log('readyState: ' + xhr.readyState);
        if(xhr.readyState == 2) {
            // postContainer.innerHTML = 'Loading...';
        }
        if(xhr.readyState == 4 && xhr.status == 200) {

            var div = document.createElement("div");
            div.className = "posts-container";
            div.setAttribute('data-page', pageNumber+1);
            div.innerHTML = xhr.responseText;

            mainPost.appendChild(div);
            successResponse = true;
        }
    }
    xhr.send();
}

window.onscroll = function(){
    if (successResponse){
        scrollReaction();
    }
}

function scrollReaction() {

    var content_height = home.offsetHeight;
    // 0.2 is to make up for the minor differece between the screens
    var current_y = window.innerHeight + window.pageYOffset + 0.2;
    if (current_y >= content_height){
        loadMore();
    }
}

var buttons = document.getElementsByClassName('followButton');

for(i=0; i < buttons.length; i++) {
    buttons.item(i).addEventListener("click", changeFollowRelation);
}

function changeFollowRelation() {

    var followerid = this.getAttribute('data-follower');
    var followedid = this.getAttribute('data-followed');

    var url = 'include/ajax-relation.php?followerid=' + followerid + '&followedid=' + followedid;

    $.ajax({
        context: this,
        method: "GET",
        url: url,
    })
        .done(function( msg ) {
            if (msg == 'true') {
                $(this).text("unfollow");
            } else if (msg == 'false'){
                $(this).text("follow");
            }
        });

}

// post input validation
var form = document.getElementById('post-input-form');

form.addEventListener('submit', function(event){

    var inputarea = document.getElementById('post-input');
    var inputValue = document.forms["post-input-form"]["posttext"].value;

    if (inputValue.trim().length == 0){
        alert('The post cannot be empty.');
        event.preventDefault();
    } else if(inputValue.length > 200) {
        alert('The post is too long.');
        event.preventDefault();
    }
});



