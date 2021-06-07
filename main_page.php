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
          <button type='submit' , name='show_watched_movies'>Watched Movies</button>
        </form>
      </li>
      <li class='watched'>
        <form action='main_page_actions.php' method='post'>
          <button type='submit' , name='movie_recommendation'>Recommend Movies</button>
        </form>
      </li>
      </li>
      <li class='watched'>
        <form action='main_page_actions.php' method='post'>
          <button type='submit' , name='tv_series_recommendation'>Recommend TV Series</button>
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
printPopularMovieTable($conn, $mostPopularMovies);
echo "</div>";
echo "<div class='right-side'>";
echo "<div class='right-title'>";
echo "Most Popular TV Series";
echo "</div>";
// Get most popular tv series
$mostPopularTvSeries = getPopularTvSeries($conn);
printPopularTvSeriesTable($conn, $mostPopularTvSeries);
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
      <label class="movie-select" , for="movie">Movies</label>
      <input type="radio" id="tv_show" name="category" value="tv_show">
      <label class="tv-select" , for="tv_show">TV Shows</label><br>

      <input type="radio" id="rating" name="sort" value="rating" checked="checked">
      <label class="movie-select" , for="rating">Sort by rating</label>
      <input type="radio" id="popularity" name="sort" value="popularity">
      <label class="tv-select" , for="popularity">Sort by popularity</label><br>
      <button class="search-button" , type="submit" , name='search'>Search</button>
    </form>
  </div>

  <div class="search-bar">
    <div class="search-text">Search content by genre</div>
    <form action="main_page_actions.php" method="post">
      <input type="radio" id="movie-genre" name="category-genre" value="movie" checked="checked">
      <label class="movie-select" , for="movie-genre">Movies</label>
      <input type="radio" id="tv_show-genre" name="category-genre" value="tv_show">
      <label class="tv-select" , for="tv_show-genre">TV Shows</label><br>

      <input type="radio" id="rating-genre" name="sort-genre" value="rating" checked="checked">
      <label class="movie-select" , for="rating-genre">Sort by rating</label>
      <input type="radio" id="popularity-genre" name="sort-genre" value="popularity">
      <label class="tv-select" , for="popularity-genre">Sort by popularity</label><br>

      <div class="selection-box">

        <select name='genre'>
          <option value="Action">Action</option>
          <option value="Adventure">Adventure</option>
          <option value="Animation">Animation</option>
          <option value="Comedy">Comedy</option>
          <option value="Crime">Crime</option>
          <option value="Documentary">Documentary</option>
          <option value="Drama">Drama</option>
          <option value="Fantasy">Fantasy</option>
          <option value="Family">Family</option>
          <option value="Romance">Romance</option>
          <option value="Thriller">Thriller</option>
          <option value="Western">Western</option>
        </select>

      </div>

      <button class="search-button" , type="submit" , name='search-by-genre'>Search</button>
    </form>
  </div>

</body>

</html>