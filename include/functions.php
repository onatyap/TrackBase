    mysqli_query($conn, $query);
<html>
    <head>
        <link rel="stylesheet" href="functions.css">
    </head>
</html>


<?php
function searchMovieWithNameOrderByRating($conn,$contentName){
    $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating 
    FROM movies
    INNER JOIN content
    ON content.content_id = movies.content_id and content.content_name LIKE '%" . $contentName . "%' 
    LEFT JOIN ratings
    ON content.content_id = ratings.content_id
    GROUP BY content.content_id 
    ORDER BY AVG(ratings.rating_value) DESC";

    $result = mysqli_query($conn, $query);

    return $result;
}

function searchMovieWithGenreOrderByRating($conn,$genre){
    $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating 
    FROM movies
    INNER JOIN content
    ON content.content_id = movies.content_id
    INNER JOIN categories
    ON movies.content_id = categories.content_id and categories.genre ='" . $genre . "'
    LEFT JOIN ratings
    ON content.content_id = ratings.content_id
    GROUP BY content.content_id 
    ORDER BY AVG(ratings.rating_value) DESC";

    $result = mysqli_query($conn, $query);

    return $result;
}

function searchMovieWithNameOrderByPopularity($conn,$contentName) {
    $today = strtotime("+1 day");
    $todayDate = date("Y-m-d",$today);
    $lastMonth = strtotime("-1 year");
    $lastMonthDate = date("Y-m-d", $lastMonth);
    $query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt
              FROM content
              INNER JOIN movies
              LEFT JOIN watched_movies
              ON content.content_id = watched_movies.content_id AND watched_movies.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $todayDate . "' 
              WHERE content.content_name LIKE '%" . $contentName . "%' 
              GROUP BY content.content_id 
              ORDER BY COUNT(*) DESC";

    $result = mysqli_query($conn, $query);

    return $result;
}

function searchMovieWithGenreOrderByPopularity($conn,$genre) {
    $today = strtotime("+1 day");
    $todayDate = date("Y-m-d",$today);
    $lastMonth = strtotime("-1 year");
    $lastMonthDate = date("Y-m-d", $lastMonth);
    $query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt
              FROM movies
              INNER JOIN content
              ON content.content_id = movies.content_id
              INNER JOIN categories
              ON movies.content_id = categories.content_id and categories.genre ='" . $genre . "'
              LEFT JOIN watched_movies
              ON movies.content_id = watched_movies.content_id AND watched_movies.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $todayDate . "' 
              GROUP BY movies.content_id 
              ORDER BY COUNT(*) DESC";

    $result = mysqli_query($conn, $query);

    return mysqli_query($conn, $query);
}

function searchTvShowWithNameOrderByRating($conn,$contentName){
    $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating 
    FROM tv_shows
    INNER JOIN content
    ON content.content_id = tv_shows.content_id and content.content_name LIKE '%" . $contentName . "%' 
    LEFT JOIN ratings
    ON content.content_id = ratings.content_id
    GROUP BY content.content_id 
    ORDER BY AVG(ratings.rating_value) DESC";

    $result = mysqli_query($conn, $query);

    return $result;
}

function searchTvShowWithGenreOrderByRating($conn,$genre){
    $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating 
    FROM tv_shows
    INNER JOIN content
    ON content.content_id = tv_shows.content_id
    INNER JOIN categories
    ON tv_shows.content_id = categories.content_id AND categories.genre ='" . $genre . "'
    LEFT JOIN ratings
    ON content.content_id = ratings.content_id
    GROUP BY content.content_id 
    ORDER BY AVG(ratings.rating_value) DESC";

    $result = mysqli_query($conn, $query);

    return $result;
}

function searchTvShowWithNameOrderByPopularity($conn,$contentName) {
    $today = strtotime("+1 day");
    $todayDate = date("Y-m-d",$today);
    $lastMonth = strtotime("-1 year");
    $lastMonthDate = date("Y-m-d", $lastMonth);
    $query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt 
              FROM tv_shows
              INNER JOIN content
              ON content.content_id = tv_shows.content_id and content.content_name LIKE '%" . $contentName . "%' 
              LEFT JOIN watched_episodes 
              ON content.content_id = watched_episodes.tv_show_id AND watched_episodes.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $todayDate . "' 
              GROUP BY content.content_id ORDER BY COUNT(*) DESC";
    $result = mysqli_query($conn, $query);

    return $result;
}

function searchTvShowWithGenreOrderByPopularity($conn,$genre) {
    $today = strtotime("+1 day");
    $todayDate = date("Y-m-d",$today);
    $lastMonth = strtotime("-1 year");
    $lastMonthDate = date("Y-m-d", $lastMonth);
    $query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt 
              FROM tv_shows
              INNER JOIN content
              ON content.content_id = tv_shows.content_id
              INNER JOIN categories
              ON tv_shows.content_id = categories.content_id AND categories.genre ='" . $genre . "'
              LEFT JOIN watched_episodes 
              ON content.content_id = watched_episodes.tv_show_id AND watched_episodes.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $todayDate . "' 
              GROUP BY content.content_id ORDER BY COUNT(*) DESC";
    $result = mysqli_query($conn, $query);

    return $result;
}

function getWatchlist($conn){
	 $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating 
               FROM lists
               INNER JOIN content 
               ON content.content_id = lists.content_id AND lists.user_id =" . $_SESSION["id"] . "
               LEFT JOIN ratings
               ON content.content_id = ratings.content_id
               GROUP BY content.content_id 
               ORDER BY AVG(ratings.rating_value) DESC";
    return mysqli_query($conn, $query);

}

function getWatchedMovies($conn){
	 $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating 
               FROM watched_movies
               INNER JOIN content
               ON content.content_id = watched_movies.content_id and watched_movies.user_id =" . $_SESSION["id"] . " 
               LEFT JOIN ratings
               ON content.content_id = ratings.content_id
               GROUP BY content.content_id 
               ORDER BY AVG(ratings.rating_value) DESC";

    return mysqli_query($conn, $query);
}

function addToWatchlist($conn,$contentId) {
    $query = " INSERT INTO LISTS(user_id,content_id) VALUES ('" . $_SESSION["id"] . "', '" . $contentId . "')";
    mysqli_query($conn, $query);
}

function getEpisodesTable($conn,$contentId) {
    $query = "SELECT * FROM episodes where tv_show_id =" . $contentId;
    return mysqli_query($conn, $query);
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
    $query = "SELECT * FROM LISTS 
              WHERE content_id = " . $contentId . " and user_id = " . $_SESSION["id"] . "";
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

function isEpisodeWatched($conn,$contentId,$season,$episode_number) {
    $isExists = False;
    $query = "SELECT * FROM watched_episodes WHERE tv_show_id = " . $contentId . " AND user_id = " . $_SESSION["id"] . " AND season = " . $season . " AND episode_number = " . $episode_number;
    if ($result = mysqli_query($conn, $query) and mysqli_num_rows($result) > 0) {
        $isExists = True;
    }
    return $isExists;
}

function addEpisodeToWatched($conn,$contentId,$season,$episode_number) {
    $time = date('Y-m-d H:i:s');
    $query = " INSERT INTO WATCHED_EPISODES(user_id,tv_show_id,season,episode_number,watched_date) VALUES ('" . $_SESSION["id"] . "', '" . $contentId . "', '" . $season . "','" . $episode_number . "', '" . $time . "')";
    mysqli_query($conn, $query);
}


function removeEpisodeFromWatched($conn,$contentId,$season,$episode_number) {
    $query = " DELETE FROM WATCHED_EPISODES WHERE tv_show_id = " . $contentId . " and user_id = " . $_SESSION["id"] . " and season =" . $season . " and episode_number=" . $episode_number;
    mysqli_query($conn, $query);
}


function isMovie($conn,$contentId) {
    $isMovie = False;
    $query = "SELECT * FROM MOVIES WHERE content_id = " . $contentId;
    if ($result = mysqli_query($conn, $query) and mysqli_num_rows($result) > 0) {
        $isMovie = True;
    }
    return $isMovie;
}

function getAverageRating($conn,$contentId) {
    $query = "SELECT AVG(r.rating_value) FROM RATINGS as R WHERE R.content_id = " . $contentId;
    $result = mysqli_query($conn, $query);
    return $result->fetch_row()[0] ?? false;
}

function getPopularMovies($conn) {
	$today = strtotime("+1 day");
	$todayDate = date("Y-m-d",$today);
	$lastMonth = strtotime("-1 year");
	$lastMonthDate = date("Y-m-d", $lastMonth);
    $query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt
              FROM watched_movies, content
              WHERE content.content_id = watched_movies.content_id AND watched_movies.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $todayDate . "' 
              GROUP BY content.content_id 
              ORDER BY COUNT(*) DESC LIMIT 5";

    $result = mysqli_query($conn, $query);
    return mysqli_query($conn, $query);
}


function getPopularTvSeries($conn) {
	$today = strtotime("+1 day");
	$todayDate = date("Y-m-d",$today);
	$lastMonth = strtotime("-1 year");
	$lastMonthDate = date("Y-m-d", $lastMonth);
	$query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt 
              FROM content, watched_episodes 
              WHERE content.content_id = watched_episodes.tv_show_id AND watched_episodes.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $todayDate . "' 
              GROUP BY content.content_id ORDER BY COUNT(*) DESC LIMIT 5";
	$result = mysqli_query($conn, $query);
	return mysqli_query($conn, $query);
}

function getPeopleWatchedThisAfterThis($conn, $contentId) {
    $query = "SELECT C.content_id, MIN(WM.watched_date - P.watched_date), C.content_name AS name
              FROM (SELECT user_id, watched_date
                     FROM WATCHED_MOVIES
                     WHERE content_id =" . $contentId . "
                     GROUP BY user_id, watched_date
                     ORDER BY user_id, watched_date) P,
               WATCHED_MOVIES WM, CONTENT C
            WHERE P.user_id = WM.user_id
             AND WM.watched_date > P.watched_date
             AND c.content_id = WM.content_id
            GROUP BY content_id, WM.watched_date, P.watched_date
            ORDER BY WM.watched_date - P.watched_date";

    $result = mysqli_query($conn, $query);

    return mysqli_query($conn, $query);
}

function recommendMoviesAccordingToSimilarWatchingRecords($conn) {
    $query = "SELECT C.content_name AS name, C.content_id, COUNT(*)
                FROM WATCHED_MOVIES, CONTENT C
                WHERE C.content_id = WATCHED_MOVIES.content_id AND user_id IN (
                   SELECT user_id
                   FROM WATCHED_MOVIES
                   WHERE content_id IN (SELECT content_id
                                        FROM WATCHED_MOVIES WM
                                        WHERE user_id =" . $_SESSION["id"] . ")
                     AND NOT user_id = " . $_SESSION["id"] . "
                   GROUP BY user_id
                   HAVING COUNT(*) > 2
                   ORDER BY COUNT(*) DESC)
                 AND C.content_id NOT IN (SELECT content_id
                                        FROM WATCHED_MOVIES WM
                                        WHERE user_id = " . $_SESSION["id"] . ")
                GROUP BY C.content_id
                ORDER BY COUNT(*) DESC";

    return $result;
}

function recommendTVSeriesAccordingToSimilarWatchingRecords($conn) {
    $query = "SELECT C.content_id, C.content_name AS name, COUNT(*)
                FROM WATCHED_EPISODES, CONTENT C
                WHERE tv_show_id = C.content_id AND user_id IN (
                   SELECT user_id
                   FROM WATCHED_EPISODES
                   WHERE tv_show_id IN (SELECT tv_show_id
                                        FROM WATCHED_EPISODES
                                        WHERE user_id = " . $_SESSION["id"] . "
                                        GROUP BY tv_show_id
                                        HAVING COUNT(*) > 3)
                     AND NOT user_id = " . $_SESSION["id"] . "
                   GROUP BY user_id
                   HAVING COUNT(*) > 2
                   ORDER BY COUNT(*) DESC)
                 AND tv_show_id NOT IN (SELECT tv_show_id
                                        FROM WATCHED_EPISODES
                                        WHERE user_id = " . $_SESSION["id"] . "
                                        GROUP BY tv_show_id
                                        HAVING COUNT(*) > 3)
                GROUP BY tv_show_id
                ORDER BY COUNT(*) DESC";

    return mysqli_query($conn, $query);
}


function printTable($conn, $result) {
        ?>        
        <br>

        <table border='1'>

        <tr>

        <th>Name</th>

        <th>Watchlist</th>

        <th>Watched</th>

        <th>Average rating</th>

        <th>Recommend</th>

        </tr>

        <?php

        foreach($result as $row){

            echo "<tr>";

            echo "<td>" . $row['name'] . "</td>";

            //Watchlist

            if(isInWatchlist($conn,$row['content_id'])){
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <div class='remove-watchlist-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Remove from watchlist' name='remove_from_watchlist'/> </form> </div> </td>";
            }
            else {
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <div class='add-watchlist-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Add to watchlist' name='add_to_watchlist'/> </form> </div> </td>";
            }

            //Watched
            if(isMovie($conn,$row['content_id'])) {
            	if(isWatched($conn,$row['content_id'])){
	                $formId = "isWatchedForm_" . $row['content_id'];
	                $buttonId = "isWatchedButton_" . $row['content_id'];
	                echo "<td> <div class='remove-watched-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as not watched' name='remove_from_watched'/> </form> </div> </td>";
            	}
	            else {
	                $formId = "isWatchedForm_" . $row['content_id'];
	                $buttonId = "isWatchedButton_" . $row['content_id'];
	                echo "<td> <div class='add-watched-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as watched' name='add_to_watched'/> </form> </div> </td>";
	            }
            } else {
            	 echo "<td> <div class='select-episodes-button'> <form action='main_page_actions.php' method='post'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input type='submit' value='Select episodes to mark as watched' name='select_episodes'/> </form> </div> </td>";
            }

            //Average Rating
            $rating = $row['rating'];
            if ($rating < 1) {
                echo "<td class='rating'>NaN</td>";
            } else {
                echo "<td class='rating'>" . round($row['rating'],2) . "</td>";
            }

            //Recommendation
             if(isMovie($conn,$row['content_id'])) {
                echo "<td>
                    <div class='recommendation-button2'> 
                    <form action='main_page_actions.php' method='post'>
                        <input type='hidden' name='content_id' value=" . $row['content_id'] . ">
                      <button type='submit' , name='recommend_movies_like_this'>Recommend me movies like this</button>
                    </form>
                    </div>
                      </td>";
             } else {
                echo "<td></td>";
             }

            echo "</tr>";

        }

        echo "</table>";

}

function printPopularMovieTable($conn, $result) {
        ?><br>

        <table border='1'>

        <tr>

        <th>Popularity</th>

        <th>Name</th>

        <th>Watchlist</th>

        <th>Watched</th>

        <th>Average rating</th>

        <th>Recommend</th>

        </tr>

        <?php

        $rank = 1;

        foreach($result as $row){

            echo "<tr>";

            echo "<td>" . $rank++ . "</td>";

            echo "<td>" . $row['name'] . "</td>";

            //Watchlist

            if(isInWatchlist($conn,$row['content_id'])){
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <div class='remove-watchlist-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Remove from watchlist' name='remove_from_watchlist'/> </form> </div> </td>";
            }
            else {
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <div class='add-watchlist-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Add to watchlist' name='add_to_watchlist'/> </form> </div> </td>";
            }

            //Watched
            if(isMovie($conn,$row['content_id'])) {
            	if(isWatched($conn,$row['content_id'])){
	                $formId = "isWatchedForm_" . $row['content_id'];
	                $buttonId = "isWatchedButton_" . $row['content_id'];
	                echo "<td> <div class='remove-watched-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as not watched' name='remove_from_watched'/> </form> </div> </td>";
            	}
	            else {
	                $formId = "isWatchedForm_" . $row['content_id'];
	                $buttonId = "isWatchedButton_" . $row['content_id'];
	                echo " <td>
                        <div class='add-watched-button'> 
		                <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> 
		                <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> 
		                <input type='hidden' name='content_id' value=" . $row['content_id'] . "> 
		                <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as watched' name='add_to_watched'/> 
		                </form>
                        </div> 
		                </td>";
	            }
            } else {
            	 echo "<td> <div class='select-episodes-button'> <form action='main_page_actions.php' method='post'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input type='submit' value='Select episodes to mark as watched' name='select_episodes'/> </form> </div> </td>";
            }

            //Rating
            $rating = getAverageRating($conn,$row['content_id']);
            if ($rating && $rating > 0) {
                echo "<td class='rating'>" . round($rating,2) . "</td>";
            } else {
                echo "<td class='rating'>NaN</td>";
            }


            //Recommendation
            echo "<td> <div class='recommendation-button'>
                <form action='main_page_actions.php' method='post'>
                    <input type='hidden' name='content_id' value=" . $row['content_id'] . ">
                  <button type='submit' , name='recommend_movies_like_this'>Recommend me movies like this</button>
                </form>
                </div>
                  </td>";
            echo "</tr>";

        }

        echo "</table>";

}

function printPopularTVSeriesTable($conn, $result) {
        ?><br>

        <table border='1'>

        <tr>

        <th>Popularity</th>

        <th>Name</th>

        <th>Watchlist</th>

        <th>Watched</th>

        <th>Average rating</th>

        </tr>

        <?php

        $rank = 1;

        foreach($result as $row){

            echo "<tr>";

            echo "<td>" . $rank++ . "</td>";

            echo "<td>" . $row['name'] . "</td>";

            //Watchlist

            if(isInWatchlist($conn,$row['content_id'])){
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <div class='remove-watchlist-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Remove from watchlist' name='remove_from_watchlist'/> </form> </div> </td>";
            }
            else {
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <div class='add-watchlist-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Add to watchlist' name='add_to_watchlist'/> </form> </div> </td>";
            }

            //Watched
            if(isMovie($conn,$row['content_id'])) {
                if(isWatched($conn,$row['content_id'])){
                    $formId = "isWatchedForm_" . $row['content_id'];
                    $buttonId = "isWatchedButton_" . $row['content_id'];
                    echo "<td> <div class='remove-watched-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as not watched' name='remove_from_watched'/> </form> </div> </td>";
                }
                else {
                    $formId = "isWatchedForm_" . $row['content_id'];
                    $buttonId = "isWatchedButton_" . $row['content_id'];
                    echo " <td>
                        <div class='add-watched-button'> 
                        <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> 
                        <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> 
                        <input type='hidden' name='content_id' value=" . $row['content_id'] . "> 
                        <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as watched' name='add_to_watched'/> 
                        </form>
                        </div> 
                        </td>";
                }
            } else {
                 echo "<td> <div class='select-episodes-button'> <form action='main_page_actions.php' method='post'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input type='submit' value='Select episodes to mark as watched' name='select_episodes'/> </form> </div> </td>";
            }

            //Rating
            $rating = getAverageRating($conn,$row['content_id']);
            if ($rating && $rating > 0) {
                echo "<td class='rating'>" . round($rating,2) . "</td>";
            } else {
                echo "<td class='rating'>NaN</td>";
            }


        }

        echo "</table>";

}

function createEpisodesTable($conn, $result) {
        ?><br>

        <table border='1'>

        <tr>

        <th>Season</th>

        <th>Episode number</th>

        <th>Episode name</th>

        <th>Episode length</th>

        <th>Watched</th>

        </tr>

        <?php

        foreach($result as $row){

            echo "<tr>";
            echo "<td>" . $row['season'] . "</td>";
            echo "<td>" . $row['episode_number'] . "</td>";
            echo "<td>" . $row['episode_name'] . "</td>";
            echo "<td>" . $row['episode_length'] . "</td>";

            //Watched
            if(isEpisodeWatched($conn,$row['tv_show_id'],$row['season'],$row['episode_number'])){
                $formId = "isWatchedEpisodeForm_" . $row['tv_show_id'] . "_" . $row['season'] . "_" . $row['episode_number'];
                $buttonId = "isWatchedEpisodeButton_" . $row['tv_show_id'] . "_" . $row['season'] . "_" . $row['episode_number'];
                echo "<td> 
                <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> 
                <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> 
                <input type='hidden' name='content_id' value=" . $row['tv_show_id'] . "> 
                <input type='hidden' name='season' value=" . $row['season'] . "> 
                <input type='hidden' name='episode_number' value=" . $row['episode_number'] . "> 
                <input id=". $buttonId . " onclick=changeEpisode('watched_episode',". $row['tv_show_id'] .",". $row['season'] .",". $row['episode_number'] .") type='submit' value='Mark as not watched' name='remove_episode_from_watched'/> 
                </form> </td>";
            }
            else {
                $formId = "isWatchedEpisodeForm_" . $row['tv_show_id'] . "_" . $row['season'] . "_" . $row['episode_number'];
                $buttonId = "isWatchedEpisodeButton_" . $row['tv_show_id'] . "_" . $row['season'] . "_" . $row['episode_number'];
                echo "<td> 
                <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> 
                <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> 
                <input type='hidden' name='content_id' value=" . $row['tv_show_id'] . "> 
                <input type='hidden' name='season' value=" . $row['season'] . "> 
                <input type='hidden' name='episode_number' value=" . $row['episode_number'] . "> 
                <input id=". $buttonId . " onclick=changeEpisode('watched_episode',". $row['tv_show_id'] .",". $row['season'] .",". $row['episode_number'] .") type='submit' value='Mark as watched' name='add_episode_to_watched'/> 
                </form> </td>";
            }

            echo "</tr>";

        }

        echo "</table>";

}

function printTableWithoutRecommendColumn($conn, $result) {
        ?>        
        <br>

        <table border='1'>

        <tr>

        <th>Name</th>

        <th>Watchlist</th>

        <th>Watched</th>

        <th>Average rating</th>

        </tr>

        <?php

        foreach($result as $row){

            echo "<tr>";

            echo "<td>" . $row['name'] . "</td>";

            //Watchlist

            if(isInWatchlist($conn,$row['content_id'])){
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <div class='remove-watchlist-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Remove from watchlist' name='remove_from_watchlist'/> </form> </div> </td>";
            }
            else {
                $formId = "watchlistForm_" . $row['content_id'];
                $buttonId = "watchlistButton_" . $row['content_id'];
                echo "<td> <div class='add-watchlist-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watchlist',". $row['content_id'] .") type='submit' value='Add to watchlist' name='add_to_watchlist'/> </form> </div> </td>";
            }

            //Watched
            if(isMovie($conn,$row['content_id'])) {
                if(isWatched($conn,$row['content_id'])){
                    $formId = "isWatchedForm_" . $row['content_id'];
                    $buttonId = "isWatchedButton_" . $row['content_id'];
                    echo "<td> <div class='remove-watched-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as not watched' name='remove_from_watched'/> </form> </div> </td>";
                }
                else {
                    $formId = "isWatchedForm_" . $row['content_id'];
                    $buttonId = "isWatchedButton_" . $row['content_id'];
                    echo "<td> <div class='add-watched-button'> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form id='" . $formId . "' action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input id=". $buttonId . " onclick=change('watched',". $row['content_id'] .") type='submit' value='Mark as watched' name='add_to_watched'/> </form> </div> </td>";
                }
            } else {
                 echo "<td> <div class='select-episodes-button'> <form action='main_page_actions.php' method='post'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input type='submit' value='Select episodes to mark as watched' name='select_episodes'/> </form> </div> </td>";
            }

            //Average Rating
            $rating = $row['rating'];
            if ($rating < 1) {
                echo "<td class='rating'>NaN</td>";
            } else {
                echo "<td class='rating'>" . round($row['rating'],2) . "</td>";
            }

            echo "</tr>";

        }

        echo "</table>";

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

    function changeEpisode(type,id,season,episodeNumber) {
    	console.log(type,id,season,episodeNumber);
    	if (type == 'watched_episode') {
	        var formId = "isWatchedEpisodeForm_" + id + "_" + season + "_" + episodeNumber;
	        document.getElementById(formId).submit();
	        setTimeout(function(){
	        var buttonId = "isWatchedEpisodeButton_" + id + "_" + season + "_" + episodeNumber;
	        var btn = document.getElementById(buttonId);
	            if (btn.value == "Mark as not watched") {
	                btn.value = "Mark as watched";
	                btn.innerHTML = "Mark as watched";
	                btn.name = "add_episode_to_watched"
	            }
	            else {
	                btn.value = "Mark as not watched";
	                btn.innerHTML = "Mark as not watched";
	                btn.name = "remove_episode_from_watched"
	            }
      	  }, 100);
    	}
    }

    function goBack() {
    	window.location.href = "main_page.php";
    }
</script>