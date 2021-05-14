<?php
require_once 'include/dbConnect.php';

session_start();

if (isset($_POST['search'])){
    $contentName = $_POST["content_name"];
    $category = $_POST["category"];

    if($category == "movie"){
        $result = searchMovieWithName($conn,$contentName);
    } else {
        $result = searchTvShowWithName($conn,$contentName);
    }

        ?><br>

        <table border='1'>

        <tr>

        <th>Name</th>

        <th>Add to watchlist</th>

        <th>Mark as watched</th>

        <th>Average rating</th>

        </tr>

        <?php

        foreach($result as $row){

            echo "<tr>";

            echo "<td>" . $row['content_name'] . "</td>";

            //Watchlist

            if(isInWatchlist($conn,$row['content_id'])){
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Remove from watchlist' name='remove_from_watchlist'/> </form> </td>";
            }
            else {
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Add to watchlist' name='add_to_watchlist'/> </form> </td>";
            }

            //Watched

            if(isWatched($conn,$row['content_id'])){
                $formId = "isWatchedForm_" . $row['content_id'];
                $buttonId = "isWatchedButton_" . $row['content_id'];
                echo "<td> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as not watched' name='remove_from_watched'/> </form> </td>";
            }
            else {
                $formId = "isWatchedForm_" . $row['content_id'];
                $buttonId = "isWatchedButton_" . $row['content_id'];
                echo "<td> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as watched' name='add_to_watched'/> </form> </td>";
            }

            //Average Rating
            $avgRating = getAverageRating($conn,$row['content_id']);
            if ($avgRating) {
                $avgRating = round($avgRating,2);
                echo "<td>" . $avgRating . "</td>";
            } else {
                echo "<td> NaN </td>";
            }

            echo "</tr>";

        }

        echo "</table>";
}

if (isset($_POST['add_to_watchlist'])){
    $contentId = $_POST["content_id"];
    addToWatchlist($conn,$contentId);
}

if (isset($_POST['remove_from_watchlist'])){
    $contentId = $_POST["content_id"];
    removeFromWatchlist($conn,$contentId);
}

if (isset($_POST['add_to_watched'])){
    $contentId = $_POST["content_id"];
    addToWatched($conn,$contentId);
}

if (isset($_POST['remove_from_watched'])){
    $contentId = $_POST["content_id"];
    removeFromWatched($conn,$contentId);
}

function searchMovieWithName($conn,$contentName){
    $query = "SELECT * FROM content, movies WHERE content.content_id = movies.content_id and content.content_name LIKE '%" . $contentName . "%'";
    return mysqli_query($conn, $query);
}

function searchTvShowWithName($conn,$contentName){
    $query = "SELECT * FROM content, tv_shows WHERE content.content_id = tv_shows.content_id and content.content_name LIKE '%" . $contentName . "%'";
    return mysqli_query($conn, $query);
}


function addToWatchlist($conn,$contentId) {
    $query = " INSERT INTO LISTS(user_id,content_id) VALUES ('" . $_SESSION["id"] . "', '" . $contentId . "')";
    mysqli_query($conn, $query);
}

function removeFromWatchlist($conn,$contentId) {
    $query = " DELETE FROM LISTS WHERE content_id = " . $contentId . " and user_id = " . $_SESSION["id"] . "";
    mysqli_query($conn, $query);
}

function addToWatched($conn,$contentId) {
    $time = date('Y-m-d H:i:s');
    $query = " INSERT INTO WATCHED_MOVIES(user_id,content_id,watched_date) VALUES ('" . $_SESSION["id"] . "', '" . $contentId . "', '" . $time . "')";
    mysqli_query($conn, $query);
}

function removeFromWatched($conn,$contentId) {
    $query = " DELETE FROM WATCHED_MOVIES WHERE content_id = " . $contentId . " and user_id = " . $_SESSION["id"] . "";
    mysqli_query($conn, $query);
}

function isInWatchlist($conn,$contentId) {
    $isExists = False;
    $query = "SELECT * FROM LISTS WHERE content_id = " . $contentId . " and user_id = " . $_SESSION["id"] . "";
    if ($result = mysqli_query($conn, $query) and mysqli_num_rows($result) > 0) {
        $isExists = True;
    }
    return $isExists;
}

function isWatched($conn,$contentId) {
    $isExists = False;
    $query = "SELECT * FROM WATCHED_MOVIES WHERE content_id = " . $contentId . " and user_id = " . $_SESSION["id"] . "";
    if ($result = mysqli_query($conn, $query) and mysqli_num_rows($result) > 0) {
        $isExists = True;
    }
    return $isExists;
}

function getAverageRating($conn,$contentId) {
    $query = "SELECT AVG(r.rating_value) FROM RATINGS as R WHERE R.content_id = " . $contentId;
    $result = mysqli_query($conn, $query);
    return $result->fetch_row()[0] ?? false;
}

 ?>

<script language="javascript">
    function change(type,id){
    if (type == 'watchlist') {
        var formId = "watchlistForm_" + id;
        document.getElementById(formId).submit();
        setTimeout(function(){
        var buttonId = "watchlistButton_" + id;
        var btn = document.getElementById(buttonId);
            if (btn.value == "Remove from watchlist") {
                btn.value = "Add to watchlist";
                btn.innerHTML = "Add to watchlist";
                btn.name = "add_to_watchlist"
            }
            else {
                btn.value = "Remove from watchlist";
                btn.innerHTML = "Remove from watchlist";
                btn.name = "remove_from_watchlist"
            }
        }, 100);
    }
    else if (type == 'watched') {
        var formId = "isWatchedForm_" + id;
        document.getElementById(formId).submit();
        setTimeout(function(){
        var buttonId = "isWatchedButton_" + id;
        var btn = document.getElementById(buttonId);
            if (btn.value == "Mark as not watched") {
                btn.value = "Mark as watched";
                btn.innerHTML = "Mark as watched";
                btn.name = "add_to_watched"
            }
            else {
                btn.value = "Mark as not watched";
                btn.innerHTML = "Mark as not watched";
                btn.name = "remove_from_watched"
            }
        }, 100);
    }
    }
</script>

