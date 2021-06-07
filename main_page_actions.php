


<?php

require_once 'include/dbConnect.php';
require_once 'include/functions.php';

session_start();

echo "<html>

<head>
    <link rel='stylesheet' href='functions.css'>
</head>

<body>
    <div class='navbar'>
        <ul class='navbar-list'>
            <li class='back'>
                <button onclick=goBack()>Back</button>
            </li>
        </ul>
    </div>
</body>

</html>";

//Todo: Move back button to a navbar.
// echo "<div class='back-button'> <button onclick=goBack()>Back</button> </div>";

if (isset($_POST['search'])) {
    $contentName = $_POST["content_name"];
    $category = $_POST["category"];
    $sort = $_POST["sort"];

    if ($category == "movie") {
        if ($sort == 'rating') {
            $result = searchMovieWithNameOrderByRating($conn, $contentName);
            printTable($conn, $result);
        } else {
            $result = searchMovieWithNameOrderByPopularity($conn, $contentName);
            printPopularMovieTable($conn, $result);
        }
    } else {
        if ($sort == 'rating') {
            $result = searchTvShowWithNameOrderByRating($conn, $contentName);
            printTableWithoutRecommendColumn($conn, $result);
        } else {
            $result = searchTvShowWithNameOrderByPopularity($conn, $contentName);
            printPopularTVSeriesTable($conn, $result);
        }
    }
}

if (isset($_POST['search-by-genre'])) {
    $category = $_POST["category-genre"];
    $sort = $_POST["sort-genre"];
    $genre = $_POST["genre"];

    if ($category == "movie") {
        if ($sort == 'rating') {
            $result = searchMovieWithGenreOrderByRating($conn, $genre);
            printTable($conn, $result);
        } else {
            $result = searchMovieWithGenreOrderByPopularity($conn, $genre);
            printPopularMovieTable($conn, $result);
        }
    } else {
        if ($sort == 'rating') {
            $result = searchTvShowWithGenreOrderByRating($conn, $genre);
            printTableWithoutRecommendColumn($conn, $result);
        } else {
            $result = searchTvShowWithGenreOrderByPopularity($conn, $genre);
            printPopularTVSeriesTable($conn, $result);
        }
    }
}

if (isset($_POST['show_watchlist'])) {
    $result = getWatchlist($conn);
    printTable($conn, $result);
}

if (isset($_POST['show_watched_movies'])) {
    $result = getWatchedMovies($conn);
    printTable($conn, $result);
}

if (isset($_POST['show_watched_episodes'])) {
    $result = getWatchedEpisodes($conn);
    createEpisodesTable($conn, $result);
}

if (isset($_POST['add_to_watchlist'])) {
    $contentId = $_POST["content_id"];
    addToWatchlist($conn, $contentId);
}

if (isset($_POST['remove_from_watchlist'])) {
    $contentId = $_POST["content_id"];
    removeFromWatchlist($conn, $contentId);
}

if (isset($_POST['add_to_watched'])) {
    $contentId = $_POST["content_id"];
    addToWatched($conn, $contentId);
}

if (isset($_POST['remove_from_watched'])) {
    $contentId = $_POST["content_id"];
    removeFromWatched($conn, $contentId);
}

if (isset($_POST['select_episodes'])) {
    $contentId = $_POST["content_id"];
    $result = getEpisodesTable($conn, $contentId);
    createEpisodesTable($conn, $result);
}

if (isset($_POST['add_episode_to_watched'])) {
    $contentId = $_POST["content_id"];
    $season = $_POST["season"];
    $episode_number = $_POST["episode_number"];
    addEpisodeToWatched($conn, $contentId, $season, $episode_number);
}

if (isset($_POST['remove_episode_from_watched'])) {
    $contentId = $_POST["content_id"];
    $season = $_POST["season"];
    $episode_number = $_POST["episode_number"];
    removeEpisodeFromWatched($conn, $contentId, $season, $episode_number);
}

if (isset($_POST['recommend_movies_like_this'])) {
    $contentId = $_POST["content_id"];
    $result = getPeopleWatchedThisAfterThis($conn, $contentId);
    printPopularMovieTable($conn, $result);
}

if (isset($_POST['movie_recommendation'])) {
    $result = recommendMoviesAccordingToSimilarWatchingRecords($conn);
    printPopularMovieTable($conn, $result);
}

if (isset($_POST['tv_series_recommendation'])) {
    $result = recommendTVSeriesAccordingToSimilarWatchingRecords($conn);
    printPopularTVSeriesTable($conn, $result);
}
?>