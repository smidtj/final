<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Access-Control-Allow-Origin: *');
session_start();
if(isset($_GET['logout'])){
  $_SESSION = array();
  session_destroy();
}
include 'pw.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "smidtj-db", $pw, "smidtj-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//Table for job listings
$exists = $mysqli->query("SELECT id FROM jobListings");
if (empty($exists)){
  if (!$mysqli->query("CREATE TABLE jobListings(
    id INT AUTO_INCREMENT PRIMARY KEY, 
    title VARCHAR(255) NOT NULL,
    description VARCHAR(16383) NOT NULL,
    salary INT,
    postedBy VARCHAR(255),
    postedPhoto VARCHAR(255),
    startDate DATETIME)")) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
  } 
}
//table of user information
$exists = $mysqli->query("SELECT id FROM jobUsers");
if (empty($exists)){
  if (!$mysqli->query("CREATE TABLE jobUsers(
    id INT AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(255) NOT NULL,
    pw VARCHAR(255) NOT NULL,
    photo VARCHAR(255))")) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }
}

//Create Account area
if(isset($_FILES["fileToUpload"])){
if($_FILES["fileToUpload"]["size"] > 0){

    if (!($stmt = $mysqli->prepare("SELECT id FROM jobUsers WHERE username=?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } 

    if (!$stmt->bind_param("s", $name)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $stmt->bind_result($correct);
    $stmt->fetch();
    $stmt->close();
    if ($correct){
      echo '<script>alert("Username already in use - File Upload Failed and Account has not been Created.")</script>';
      $createFail = 1;
      $_SESSION = array();
      session_destroy();
    } else {
$createFail = 0;
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["create"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo '<script language="javascript">alert("File is not an image.")</script>';
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo '<script language="javascript">alert("Sorry, file already exists.")</script>';
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo '<script language="javascript">alert("Sorry, your file is too large. <500KB please")</script>';
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo '<script language="javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo '<script language="javascript">alert("Account Creation has Failed - Image has not been added")</script>';
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo '<script language="javascript">alert("Success! Your file '. basename( $_FILES["fileToUpload"]["name"]). ' has been uploaded.")</script>';
        chmod($target_file, 0777);
    } else {
        echo '<script language="javascript">alert("Sorry, there was an error uploading your file.")</script>';
    }
}
}
}
}

if(isset($_POST["createUsername"]) && isset($_POST["createPW"]) && !(($_FILES["fileToUpload"]["size"]) > 0)){
  $name = $_POST['createUsername'];
  $pass = $_POST['createPW'];
    if (!($stmt = $mysqli->prepare("SELECT id FROM jobUsers WHERE username=?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } 

    if (!$stmt->bind_param("s", $name)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $stmt->bind_result($correct);
    $stmt->fetch();
    $stmt->close();
    if ($correct){
      echo '<script>alert("Username already in use - Acconut Creation Failed.")</script>';
      $_SESSION = array();
      session_destroy();
    } else {
      if (!($stmt = $mysqli->prepare("INSERT INTO jobUsers(username, pw) VALUES (?, ?)"))) {
          echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      } 
  
      if (!$stmt->bind_param("ss", $name, $pass)) {
          echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }
  
      if (!$stmt->execute()) {
          echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
      $stmt->close();
      $_SESSION["username"] = $name;
    }
}

if(isset($_POST["createUsername"]) && isset($_POST["createPW"]) && ($_FILES["fileToUpload"]["size"] > 0) && $createFail == 0){
  $name = $_POST['createUsername'];
  $pass = $_POST['createPW'];
  $file = $_FILES["fileToUpload"]["name"];

    if (!($stmt = $mysqli->prepare("SELECT id FROM jobUsers WHERE username=?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } 

    if (!$stmt->bind_param("s", $name)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $stmt->bind_result($correct);
    $stmt->fetch();
    $stmt->close();
    if ($correct){
      echo '<script>alert("Username already in use - Acconut Creation Failed.")</script>';
      $_SESSION = array();
      session_destroy();
    } else {
      if (!($stmt = $mysqli->prepare("INSERT INTO jobUsers(username, pw, photo) VALUES (?, ?, ?)"))) {
          echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      } 
  
      if (!$stmt->bind_param("sss", $name, $pass, $file)) {
          echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }
  
      if (!$stmt->execute()) {
          echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
      $stmt->close();
      $_SESSION["username"] = $name;
      $_SESSION["photo"] = $file; 
    } 
}

if(isset($_POST["loginUsername"]) && isset($_POST["loginPW"])){
  $name = $_POST['loginUsername'];
  $pass = $_POST['loginPW'];
    if (!($stmt = $mysqli->prepare("SELECT id, photo FROM jobUsers WHERE username=? AND pw=?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } 

    if (!$stmt->bind_param("ss", $name, $pass)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $stmt->bind_result($correct, $photo);
    $stmt->fetch();

    $stmt->close();
  if ($correct > 0){
    $_SESSION["username"] = $name;
    if ($photo != NULL){
      $_SESSION["photo"] = $photo;
    }
  } else {
    echo '<script>alert("Incorrect Username or Password - Login Failed.")</script>';
    $_SESSION = array();
    session_destroy();
  }
}

if(isset($_POST["postTitle"]) && isset($_POST["postDescription"]) && isset($_POST["postSalary"]) && isset($_POST["postDate"])){
  if(!isset($_SESSION["photo"]) || !isset($_SESSION["username"])){
    echo '<script>alert("You must be logged in to post a Job Listing.")</script>';
  } else {
    $title = $_POST["postTitle"];
    $desc = $_POST["postDescription"];
    $sal = $_POST["postSalary"];
    $date = $_POST["postDate"];
    $photo = $_SESSION["photo"];
    $by = $_SESSION["username"];
  
    $date = strtotime($date);
    $date = date("Y-m-d", $date);
  
    if (!($stmt = $mysqli->prepare("INSERT INTO jobListings(title, description, salary, postedBy, postedPhoto, startDate) VALUES (?, ?, ?, ?, ?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } 
    
        if (!$stmt->bind_param("ssisss", $title, $desc, $sal, $by, $photo, $date)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $stmt->close();
      }
}

$titles = array();
$images = array();
$posters = array();
$descriptions = array();
$salaries = array();
$dates = array();

function fill($getvalue, $mysqli){
  $string = "SELECT " . $getvalue . " FROM jobListings"; 
  $result = $mysqli->query($string); 
  while ($object = $result->fetch_object()){ 
    $arr[] = $object->$getvalue; 
  }  
  return $arr; 
}

$titles = fill("title", $mysqli);
$numEntries = sizeof($titles);
$images = fill("postedPhoto", $mysqli);
$posters = fill("postedBy", $mysqli);
$descriptions = fill("description", $mysqli);
$salaries = fill("salary", $mysqli);
$dates = fill("startDate", $mysqli);
for($j = 0; $j < $numEntries; $j++){
  $kaboom = explode(" ", $dates[$j]);
  $dates[$j] = $kaboom[0];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>JOBsite</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="own.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
<!--Source: http://getbootstrap.com/components/#navbar-brand-image -->
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: #9E9 !important">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="final.php">JOBsite</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <!-- Below may be implemented time allowing
      <form action = "final.php" class="navbar-form navbar-left" role="search">
        <input type="text" class="form-control" placeholder="Keyword" name="keyword">        
        <button type="submit" class="btn btn-default">Find a Job</button>
      </form>
      -->
        <!-- Button trigger modal -->
<?php
if(isset($_SESSION["username"])){
  echo '<STRONG class="text-muted" style="margin-right: 15px; margin-left: 50px"> Currently Logged in as: "' . $_SESSION["username"] . '"</STRONG>';
  echo '<img src="uploads/' . $_SESSION["photo"] . '" alt="photo" height="40" width="40">';
  echo '<form action="board.php" class="navbar-form navbar-right" role="search">';
    echo '<button type="submit" class="btn btn-default" name="myInfo">
    My Posts
  </button></form>';
  echo '<form action="final.php" class="navbar-form navbar-right" role="search">';
  echo '<button type="submit" class="btn btn-default" name="logout">
    Logout
  </button></form>';
} else{
  echo '<form class="navbar-form navbar-right" role="search">';
  echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#login">
    Login
  </button>
  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#createAccount">
    Create Account
  </button>';
}
?>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<!-- Modal login -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="final.php" method="post" id="loginform">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Login Here</h4>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" placeholder="Username" name="loginUsername" id="loginName" required>
        <input type="password" class="form-control" placeholder="Password" name="loginPW" id="loginPass" required>
        <script type="text/javascript">
                function check(){    
                  var username = document.getElementById("loginName").value;
                  var password = document.getElementById("loginPass").value;
                    //jquery ajax call
                    $.post('account_check.php', {'username':username, 'password':password}, function(data) {
                      $("#returnInfo").html(data);
                    });
                };
                $('#login').on('hidden.bs.modal', function () {
                    log();
                })
                function log(){
                    document.getElementById("loginform").submit(); 
                }; 
        </script>
      <span id="returnInfo">Response</span>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="check();">Login</button>
        or
        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#createAccount">
            Create Account
          </button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal newPost -->
<div class="modal fade" id="newPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="board.php" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Post Here</h4>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" placeholder="Job Title" name="postTitle" required>
        <input type="text" class="form-control" placeholder="Job Description" name="postDescription" required>
        <input type="number" class="form-control" placeholder="Salary in $" name="postSalary" min="0" required>
        <input type="date" class="form-control" placeholder="Start Date" name="postDate" max="2100-01-01" min="2015-03-03" required>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Post</button>
        
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal createAccount -->
<div class="modal fade" id="createAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="final.php" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Account</h4>
      </div>
      <div class="modal-body">
          <input type="text" class="form-control" placeholder="Username" name="createUsername" id="createUsername" autocomplete="off" required>
            <!-- This script is based off of a method from http://www.sanwebe.com/2013/04/username-live-check-using-ajax-php which utilizies jQuery-->
            <script type="text/javascript">
              $(document).ready(function() {
                $("#createUsername").keyup(function (e) {    
                  var username = $(this).val();
                  if(username.length < 2){$("#user-result").html('');return;}
    
                  if(username.length >= 2){
                    $("#avail").html('<img src="imgs/ajax-loader.gif" />');
                    //jquery ajax call
                    $.post('check_username.php', {'username':username}, function(data) {
                      $("#avail").html(data);
                    });
                   }
                }); 
              });
            </script>
          <span id="avail"></span>
          <input type="password" class="form-control" placeholder="Password" name="createPW" required>
          Add a profile picture:
          <input type="file" name="fileToUpload" id="fileToUpload">  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="create">Create Account</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php
if(!isset($_GET["myInfo"])){
 echo '<div class="container">
  <div class="jumbotron" style="background-color: #9E9 !important">
    <h1>Post and Browse Job Listings</h1>
    <p style="color: #FFF">By: Jesse Smidt</p> 
  </div>
  <div class="row bottom-spacer5">
    <div class="col-sm-9">
      <h2>Below you can find all the posts made to this website</h1>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
      <h3>Navigation</h3>
      <p><a href="about.php">About JOBsite</a></p>
      <p><a href="board.php">View All Posts</a></p>
    </div>
    <div class="row bottom-spacer10">
      <div class="col-sm-1">
        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#newPost">
          Post Job Listing
        </button></div>
      <div class="col-sm-8"></div>
    </div>
  </div>';


  for($i = ($numEntries - 1); $i > -1; $i--){  
    echo '<div class="row">
      <div class="col-sm-9">
        <div class="col-sm-4"><img src="uploads/'.$images[$i].'" height="150" width="200"></div>
        <div class="col-sm-3"><p class="title">'.$titles[$i].'</p></div>
        <div class="col-sm-2"><p>Posted By: '.$posters[$i].'</p></div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-9">
        <p>'.$descriptions[$i].'</p>
      </div>
    </div>
    <div class="row bottom-spacer20">
      <div class="col-sm-9">
        <div class="col-sm-6"><p>$'.$salaries[$i].'/Year</p></div>
        <div class="col-sm-3"><p>Start Date: '.$dates[$i].'</p></div>
      </div>
    </div>';
  }
} else{
 echo '<div class="container">
  <div class="jumbotron" style="background-color: #9E9 !important">
    <h1>Your Posts</h1>
    <p style="color: #FFF">'.$_SESSION['username'].'</p> 
  </div>
  <div class="row bottom-spacer5">
    <div class="col-sm-9">
      <h2>Below are all the posts you have made to this website</h1>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
      <h3>Navigation</h3>
      <p><a href="about.php">About JOBsite</a></p>
      <p><a href="board.php">View All Posts</a></p>
    </div>
    <div class="row bottom-spacer10">
      <div class="col-sm-1">
        <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#newPost">
          Post Job Listing
        </button></div>
      <div class="col-sm-8"></div>
    </div>
  </div>';

  for($i = ($numEntries - 1); $i > -1; $i--){
    if ($posters[$i] == $_SESSION['username']){  
      echo '<div class="row">
        <div class="col-sm-9">
          <div class="col-sm-4"><img src="uploads/'.$images[$i].'" height="150" width="200"></div>
          <div class="col-sm-3"><p class="title">'.$titles[$i].'</p></div>
          <div class="col-sm-2"><p>Posted By: '.$posters[$i].'</p></div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-9">
          <p>'.$descriptions[$i].'</p>
        </div>
      </div>
      <div class="row bottom-spacer20">
        <div class="col-sm-9">
          <div class="col-sm-6"><p>$'.$salaries[$i].'/Year</p></div>
          <div class="col-sm-3"><p>Start Date: '.$dates[$i].'</p></div>
        </div>
      </div>';
    }
  }
}
echo '</div>';
?>
</body>
</html>
