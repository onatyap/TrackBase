<html>
    <head>
        <link rel="stylesheet" href="functions.css">
    </head>
</html>


<?php
require_once 'include/dbConnect.php';
require_once 'include/functions.php';

session_start();

if (isset($_POST['search'])){
    $contentName = $_POST["content_name"];
    $category = $_POST["category"];

    if($category == "movie"){
        $result = searchMovieWithName($conn,$contentName);
    } else {
        $result = searchTvShowWithName($conn,$contentName);
    }

    printTable($conn,$result);
}

if (isset($_POST['show_watchlist'])){
    $result = getWatchlist($conn);
    printTable($conn,$result);
}

if (isset($_POST['show_watched_movies'])){
    $result = getWatchedMovies($conn);
    printTable($conn,$result);
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

if (isset($_POST['select_episodes'])){
    $contentId = $_POST["content_id"];
    $result = getEpisodesTable($conn,$contentId);
    createEpisodesTable($conn,$result);
}

if (isset($_POST['add_episode_to_watched'])){
    $contentId = $_POST["content_id"];
    $season = $_POST["season"];
    $episode_number = $_POST["episode_number"];
    addEpisodeToWatched($conn,$contentId,$season,$episode_number);
}

if (isset($_POST['remove_episode_from_watched'])){
    $contentId = $_POST["content_id"];
    $season = $_POST["season"];
    $episode_number = $_POST["episode_number"];
    removeEpisodeFromWatched($conn,$contentId,$season,$episode_number);
}



echo "<div class='back-button'> <button onclick=goBack()>Back</button> </div>";
 ?>



