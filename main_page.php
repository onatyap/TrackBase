<html>

<head>
  <link rel="stylesheet" href="main_page.css">
</head>

<body>

  <form action="main_page_actions.php" method="post">

    <div class="container">

      <div class="page-title">
        Welcome back!
      </div>
    

      <div class="grid-container">

        <div class="left-side">

          <!-- Continue Watching Title -->
          <div class="continue-watching">
            Continue watching
            <span class="line2"></span>
          </div>

          <div class="content-container">

            <!-- TV Show 1 -->
            <div class="content-1">
              <img src="assets/peaky_blinders.jpg" , name="content-1-image">
              <div class="content-title" , name="content-1-title">
                Peaky Blinders
              </div>
              <div class="episode-tracker" , name="content-1-tracker">
                S4 | E3
              </div>
              <div class="buttons">
                <button type="submit" , name="add_to_watchlist">Mark as Watched</button>
              </div>


            </div>

            <!-- TV Show 2 -->
            <div class="content-2">
              <img src="assets/breakingbad.jpg" , name="content-2-image">
              <div class="content-title" , name="content-2-title">
                Breaking Bad
              </div>
              <div class="episode-tracker" , name="content-2-tracker">
                S3 | E12
              </div>
              <div class="buttons">
                <button type="submit" , name="add_to_watchlist">Mark as Watched</button>
              </div>
            </div>

            <!-- TV Show 3 -->
            <div class="content-3">
              <img src="assets/got.jpg" , name="content-3-image">
              <div class="content-title" , name="content-3-title">
                Game of Thrones
              </div>
              <div class="episode-tracker" , name="content-3-tracker">
                S5 | E8
              </div>
              <div class="buttons">
                <button type="submit" , name="add_to_watchlist">Mark as Watched</button>
              </div>
            </div>

          </div>
        </div>


        <!-- Right Side -->
        <div class="right-side">

          <div class="search-title">
            Search
            <span class="line"></span>
          </div>

          <!-- Search Selection Box:
        Allows user to pick content type and search accordingly -->
          <div class="selection-box">

            <select name='content_type'>
              <option value="0"> Movie </option>
              <option value="1"> TV Show </option>
              <option value="3"> Genre </option>
            </select>

            <!-- Search Text Box -->
            <input class='search-bar' , type="text" placeholder="Enter name" name="content_name" required>

          </div>



          <!-- Search Submit Button -->
          <div class="search-button">
            <button type="submit" , name='search'>Search</button>
          </div>

        </div>

      </div>

    </div>

  </form>

</body>

</html>