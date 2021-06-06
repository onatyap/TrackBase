<html>
    <head>
        <link rel="stylesheet" href="functions.css">
    </head>
</html>


<?php
function searchMovieWithName($conn,$contentName){
    $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating FROM content, movies,ratings WHERE content.content_id = ratings.content_id AND content.content_id = movies.content_id and content.content_name LIKE '%" . $contentName . "%' GROUP BY content.content_id ORDER BY AVG(ratings.rating_value) DESC";

    return mysqli_query($conn, $query);
}

function searchTvShowWithName($conn,$contentName){
    $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating FROM content, tv_shows,ratings WHERE content.content_id = ratings.content_id AND content.content_id = tv_shows.content_id and content.content_name LIKE '%" . $contentName . "%' GROUP BY content.content_id ORDER BY AVG(ratings.rating_value) DESC";
    return mysqli_query($conn, $query);
}

function getWatchlist($conn){
	 $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating FROM content, lists, ratings WHERE content.content_id = ratings.content_id AND content.content_id = lists.content_id and lists.user_id =" . $_SESSION["id"] . " GROUP BY content.content_id ORDER BY AVG(ratings.rating_value) DESC";

    return mysqli_query($conn, $query);

}

function getWatchedMovies($conn){
	 $query = "SELECT content.content_id AS content_id, content.description AS description, content.content_name AS name, AVG(ratings.rating_value) AS rating FROM content, watched_movies, ratings WHERE content.content_id = ratings.content_id AND content.content_id = watched_movies.content_id and watched_movies.user_id =" . $_SESSION["id"] . " GROUP BY content.content_id ORDER BY AVG(ratings.rating_value) DESC";

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
    $query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt FROM content, watched_movies WHERE content.content_id = watched_movies.content_id AND watched_movies.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $todayDate . "' GROUP BY content.content_id ORDER BY COUNT(*) DESC LIMIT 5";
    $result = mysqli_query($conn, $query);
    return mysqli_query($conn, $query);
}

function getPopularTvSeries($conn) {
	$today = strtotime("+1 day");
	$todayDate = date("Y-m-d",$today);
	$lastMonth = strtotime("-1 year");
	$lastMonthDate = date("Y-m-d", $lastMonth);
	$query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt FROM content, watched_episodes WHERE content.content_id = watched_episodes.tv_show_id AND watched_episodes.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $todayDate . "' GROUP BY content.content_id ORDER BY COUNT(*) DESC LIMIT 5";
	$result = mysqli_query($conn, $query);
	return mysqli_query($conn, $query);
}

function getPopularMoviesByGenre($conn, $genre) {
	$today = date("Y-m-d");
	$lastMonth = strtotime("-1 year");
	$lastMonthDate = date("Y-m-d", $lastMonth);
    $query = "SELECT content.content_id as content_id, content.description AS description, content.content_name AS name, COUNT(*) as cnt FROM content, watched_movies, categories WHERE content.content_id = watched_movies.content_id AND content.content_id = categories.content_id AND categories.genre = '" . $genre . "' AND watched_movies.watched_date BETWEEN '" . $lastMonthDate . "' AND '" . $today . "' GROUP BY content.content_id ORDER BY COUNT(*) DESC LIMIT 10";
    $result = mysqli_query($conn, $query);
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
            echo "<td class='rating'>" . round($row['rating'],2) . "</td>";

            echo "</tr>";

        }

        echo "</table>";

}

function printPopularTable($conn, $result) {
        ?><br>

        <table border='1'>

        <tr>

        <th>Name</th>

        <th>Watchlist</th>

        <th>Watched</th>

        <th>Watch Count</th>

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

            echo "<td class='watch-count'>" . $row['cnt'] . "</td>";

            echo "</tr>";

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