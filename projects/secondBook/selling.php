<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
  $userRow=$query->fetch_array();
  $userName = "'". preg_replace('/\s+/','',$userRow['username'])."'";
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sell A Book</title>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 

<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://localhost/php-mysqli-login-signup/home.php"><img src="secondBookLogo.png" alt="logo" height=30 width=30 style="display:inline;vertical-align:middle"> SecondBook</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
           <li><a href="http://localhost/php-mysqli-login-signup/home.php">Books Near Me</a></li>
            <li class="active"><a href="http://localhost/php-mysqli-login-signup/selling.php">Sell A Book</a></li>
            <li><a href="http://localhost/php-mysqli-login-signup/mystore.php">My Store</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username']; ?></a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<div class="container" style="margin-top:60px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
  <h2> Sell a book! </h2>
<div class="leftHalf" style="text-align:left;font-size:12px">


<form action=selling2.php method="post">
<fieldset>
<div class="form-group col-xs-7">
<label for="title">Title:</label> <input class="form-control" type="text" name="Title">
</div>
<div class="form-group col-xs-7">
<label for="author"> Author:</label> <input class="form-control" type="text" name="Author">
 </div>
<div class="form-group col-xs-7">
<label for="genre"> Genre: </label><input class="form-control" type="text" name="Genre"> 
</div>
<div class="form-group col-xs-7">
<label for="loc "> ISBN: </label> <input class="form-control" type="text" name="ISBN"> 
</div>
<div class="col-xs-7 row">
<div class="form-group col-xs-7">
<input class="form-control" type="submit" name ="amazon" value="Check Amazon Price">
</div>
<div class="form-group col-xs-5">
<input class="form-control" type="submit" name="add" value="Add to Store">
</div>
</div>
</fieldset>
</form>

<!--<article>
Enter the ISBN code for your book:<br>
<form action="lookedUp.php" method="post">
<input type="text" name="ISBN"> <br>
<input type="submit" value="Submit">
</form>
</article>
//-->

</div>

</div>
</body>
</html>