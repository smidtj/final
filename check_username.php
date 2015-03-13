<?php

include 'pw.php';

//check we have username post var
if(isset($_POST["username"]))
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

    $username =  strtolower(trim($_POST["username"])); 
    
    //check username in db
        $stmt = $mysqli->prepare("SELECT id FROM jobUsers WHERE username=?");

        $stmt->bind_param("s", $username);

        $stmt->execute();

        $stmt->bind_result($exist);

        $stmt->fetch();
        //return total count

    if($exist > 0) {
        echo '<p style="color:red"><STRONG>Not Available</STRONG></p>';
    }else{
        echo '<p style="color:green"><STRONG>Available</STRONG></p>';
    }
}

$stmt->close();
?>