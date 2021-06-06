<?php
require_once 'include/dbConnect.php';
require_once 'include/functions.php';

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
  header("location:index.php");
  exit();
}
?>

<html>

<head>
  <link rel="stylesheet" href="main_page.css">
</head>

<body>

  <div class='navbar'>
    <ul class='navbar-list'>
      <li class='watchlist'>
        <form action='main_page_actions.php' method='post'>
          <button type='submit' , name='show_watchlist'>Watchlist</button>
        </form>
      </li>
      <li class='watched'>
        <form action='main_page_actions.php' method='post'>
          <button type='submit' , name='show_watched_movies'>Watchedlist</button>
        </form>
      </li>
      <li class='logout-button'>
        <button onclick='window.location.href ="index.php";'>Log out</button>
      </li>
    </ul>
  </div>
</body>

</html>

<?php
echo "<div class='grid-container'>";
echo "<div class='left-side'>";
echo "<div class='left-title'>";
echo "Most Popular Movies";
echo "</div>";
// Get most popular movies
$mostPopularMovies = getPopularMovies($conn);
printPopularTable($conn, $mostPopularMovies);
echo "</div>";
echo "<div class='right-side'>";
echo "<div class='right-title'>";
echo "Most Popular TV Series";
echo "</div>";
// Get most popular tv series
$mostPopularTvSeries = getPopularTvSeries($conn);
printPopularTable($conn, $mostPopularTvSeries);
echo "</div>";
echo "</div";
/*
echo "<h3>Most Popular Action Movies</h3>";
$mostPopularActionMovies = getPopularMoviesByGenre($conn, 'Action');
printPopularTable($conn, $mostPopularActionMovies);
*/
?>


<html>

<head>
  <link rel="stylesheet" href="main_page.css">
</head>

<body>

  <div class="search-bar">

    <div class="search-text">Search content by name</div>

    <form action="main_page_actions.php" method="post">
      <label class="search-name">Name</label>
      <input type="text" placeholder="Enter name" name="content_name" required>
      <input type="radio" id="movie" name="category" value="movie" checked="checked">
      <label class="movie-select", for="movie">Movies</label>
      <input type="radio" id="tv_show" name="category" value="tv_show">
      <label class="tv-select", for="tv_show">TV Shows</label><br>
      <button class="search-button", type="submit" , name='search'>Search</button>
    </form>

  </div>

</body>

</html>