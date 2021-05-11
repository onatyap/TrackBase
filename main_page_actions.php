<?php
require_once 'include/dbConnect.php';

session_start();

if (isset($_POST['search'])){
    $contentName = $_POST["content_name"];

    $result = searchContentWithName($conn,$contentName);

        ?><br>

        <table border='1'>

        <tr>

        <th>Name</th>

        <th>Description</th>

        <th>Add to watchlist</th>

        </tr>

        <?php

        foreach($result as $row){

            echo "<tr>";

            echo "<td>" . $row['content_name'] . "</td>";

            echo "<td>" . $row['description'] . "</td>";

            echo "<td> <iframe name='dummyframe' id='dummyframe' style='display: none;'></iframe> <form action='main_page_actions.php' method='post' target='dummyframe'> <input type='hidden' name='content_id' value=" . $row['content_id'] . "> <input type='submit' name='add_to_watchlist'/> </form> </td>";

            echo "</tr>";

        }

        echo "</table>";
}

if (isset($_POST['add_to_watchlist'])){
    $contentId = $_POST["content_id"];
    addToWatchlist($conn,$contentId);
}


function searchContentWithName($conn,$contentName){
    $query = "SELECT * FROM content WHERE content.content_name LIKE '%" . $contentName . "%'";
    return mysqli_query($conn, $query);
}

function addToWatchlist($conn,$contentId) {
    $query = " INSERT INTO LISTS(user_id,content_id) VALUES ('" . $_SESSION["id"] . "', '" . $contentId . "')";
    echo $query;
    mysqli_query($conn, $query);
}

