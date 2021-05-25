<?php
require_once 'include/dbConnect.php';
require_once 'include/functions.php';

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true){
    header("location:index.php");
    exit();
}

// Get most popular movies
echo "<h3>Most Popular Movies</h3>";
$mostPopularMovies = getPopularMovies($conn);
printPopularTable($conn,$mostPopularMovies);

echo "<h3>Most Popular TV Series</h3>";
$mostPopularTvSeries = getPopularTvSeries($conn);
printPopularTable($conn,$mostPopularTvSeries);

echo "<h3>Most Popular Action Movies</h3>";
$mostPopularActionMovies = getPopularMoviesByGenre($conn,'Action');
printPopularTable($conn,$mostPopularActionMovies);
?>


<html>
<head>
  <link rel="stylesheet" href="index.css">
</head>
<body>

   <form action="main_page_actions.php" method="post">
  <div class="container">
    <h3>Search content by name</h3>
    <label><b>Name</b></label>
    <input type="text" placeholder="Enter name" name="content_name" required>
    <input type="radio" id="movie" name="category" value="movie" checked="checked">
    <label for="movie">Movies</label>
    <input type="radio" id="tv_show" name="category" value="tv_show">
    <label for="tv_show">TV Shows</label><br>
    <button type="submit", name='search'>Search</button>
   </div>
   </form>


   <form action="main_page_actions.php" method="post">
  <div class="container">
    <h3>Watchlist</h3>
    <button type="submit", name='show_watchlist'>Show my watchlist</button>
    </div>
   </form>

      <form action="main_page_actions.php" method="post">
  <div class="container">
    <h3>Watched</h3>
    <button type="submit", name='show_watched_movies'>Show the movies I watched</button>
    </div>
   </form>

    <button onclick="window.location.href = 'index.php';">Log out</button>


</body>
</html>