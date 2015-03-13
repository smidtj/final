<?php

include 'pw.php';
session_start();
//check we have username post var
if(isset($_POST["username"]) && isset($_POST["password"]))
{
    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        die();
    }   

        //try connect to db
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "smidtj-db", $pw, "smidtj-db");
    if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $username = $_POST["username"]; 
    $password = $_POST["password"];
    //check username in db
        $stmt = $mysqli->prepare("SELECT id FROM jobUsers WHERE username=? AND pw=?");

        $stmt->bind_param("ss", $username, $password);

        $stmt->execute();

        $stmt->bind_result($exist);

        $stmt->fetch();
        //return total count

    if($exist > 0) {
        echo '<p style="color:green"><STRONG>Logged in!</STRONG></p>';
    }else{
        echo '<p style="color:red"><STRONG>Incorrect Username or Password!</STRONG></p>';
    }
}

$stmt->close();
?>