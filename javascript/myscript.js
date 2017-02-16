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
    var current_y = window.innerHeight + window.pageYOffset + 0.2;
    console.log(content_height + '/' + current_y);
    if (current_y >= content_height){
        loadMore();
    }

}