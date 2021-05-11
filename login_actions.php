<?php
require_once 'include/dbConnect.php';

if (isset($_POST['sign_in'])){
    $userName = $_POST["login_username_insert"];
    $password = $_POST["login_password_insert"];

    $result = login_successful($conn,$userName,$password);

    if($result) {
        session_start();
        $_SESSION["loggedIn"] = true;
        $_SESSION["id"] = getId($conn,$userName);
        header("Location:main_page.php");
        exit();
    } else {
        exit("Wrong username or password.");
    }
}

if (isset($_POST['sign_up'])){
    $userName = $_POST["sign_up_username_insert"];
    $password = $_POST["sign_up_password_insert"];

    $result = user_exists($conn,$userName);

    if($result){
        exit("User with username: " . $userName . " already exists!");
    } else {
        create_user($conn,$userName,$password);
        session_start();
        $_SESSION["loggedIn"] = true;
        $_SESSION["id"] = getId($conn,$userName);
        header("Location:main_page.php");
        exit();
    }
}

function login_successful($conn,$username, $password){
    $isSuccessful = False;
    $query = "SELECT * FROM USERS WHERE username = '" . $username . "' AND user_password = '" . $password . "'";
    if ($result = mysqli_query($conn, $query) and mysqli_num_rows($result) > 0) {
        $isSuccessful = True;
    }
    return $isSuccessful;
}

function user_exists($conn,$username){
    $isExists = False;
    $query = "SELECT * FROM USERS WHERE username = '" . $username . "'";
    if ($result = mysqli_query($conn, $query) and mysqli_num_rows($result) > 0) {
        $isExists = True;
    }
    return $isExists;
}

function create_user($conn,$username, $password){
    $query = " INSERT INTO USERS(username,user_password) VALUES ('" . $username . "', '" . $password . "')";
    mysqli_query($conn, $query);
}

function getId($conn,$username){
    $query = "SELECT user_id FROM USERS WHERE username = '" . $username . "'";
    $result = mysqli_query($conn, $query);
    return $result->fetch_row()[0] ?? false;
}