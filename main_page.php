<?php
require_once 'include/dbConnect.php';

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true){
    header("location:index.php");
    exit();
}
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
   </form>

</body>
</html>