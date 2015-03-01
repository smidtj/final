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
  <script src="final.js"></script>
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
      <form action = "final.php" class="navbar-form navbar-left" role="search">
        <input type="text" class="form-control" placeholder="Keyword" name="keyword">        
        <button type="submit" class="btn btn-default">Find a Job</button>
      </form>
      <form class="navbar-form navbar-right" role="search">
        <!-- Button trigger modal -->
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#login">
            Login
          </button>
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#createAccount">
            Create Account
          </button>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<!-- Modal login -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="final.php" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Login Here</h4>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" placeholder="Username" name="loginUsername">
        <input type="password" class="form-control" placeholder="Password" name="loginPW">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Login</button>
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
          <input type="text" class="form-control" placeholder="Username" name="createUsername">
          <input type="password" class="form-control" placeholder="Password" name="createPW">
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

<div class="container">
  <div class="jumbotron" style="background-color: #9E9 !important">
    <h1>Post and Browse Job Listings</h1>
    <p style="color: #FFF">By: Jesse Smidt</p> 
  </div>
  <div class="row bottom-spacer5">
    <div class="col-sm-9">
      <h2>What is this page for?</h1>
      <p>Hopefully you've found yourself here with a purpose, but just in case you haven't - Let me give you an overview of what's in store.</p>
      	<dl class="dl-horizontal">
            <dt><a href="#">About JOBsite</a>
            	<dd>This is just a short blurb about what JOBsite it is. You can definately skip this section if you're already familiar with the basic functionality of a job listing website.</dd>
            </dt>
            <br>
            <dt><a href="#">Post a Job Listing</a>
            	<dd>Here you can fill out the necessary information and post your company's most recent opening on this website!</dd>
            </dt>
          </dl>
       <p>Hope you enjoy JOBsite</p>

    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
      <h3>Navigation</h3>
      <p><a href="#">About JOBsite</a></p>
      <p><a href="request.html">Post a Job Listing</a></p>
    </div>
  </div>
  <div class="row bottom-spacer10">
  	<!--<div class="col-sm-2"><a class="btn btn-default" href="#" role="button">Previous</a></div>-->
  	<div class="col-sm-8"></div>
  	<div class="col-sm-1"><a class="btn btn-default" href="about.html" role="button">Next</a></div>
  </div>
</div>


</body>
</html>
