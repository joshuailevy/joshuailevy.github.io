<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$userName = preg_replace('/\s+/','',$userRow['username']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sell A Book<?php echo $userRow['email']; ?></title>

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
            <li><a href="http://localhost/php-mysqli-login-signup/selling.php">Sell A Book</a></li>
            <li class="active"><a href="http://localhost/php-mysqli-login-signup/mystore.php">My Store</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username']; ?></a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<div class="container" style="margin-top:60px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
	<h3>My Store</h3>


<div class="rightHalf col-md-7" style="font-size:12px">
<?php
echo "SELECT * FROM books WHERE seller="."'".$userName."'"; echo "<br>";
echo "SELECT * FROM books WHERE seller='ha'";
$query = $DBcon->query("SELECT * FROM books WHERE seller="."'".$userName."'");//. $userRow['username']);
if($query->num_rows >0) {
echo "<table class='table table-hover'><caption style='text-align:center'>Search Results </caption><tr><th class='text-center'>Title</th><th class='text-center'>Author</th><th class='text-center'>Year</th><th class='text-center'>Price</th></tr>";
while($userRow=$query->fetch_assoc()){
echo "<tr> <td>" . $userRow["title"] ."</td>";
echo "<td>" . $userRow["author"] ."</td>";
echo "<td>" . $userRow["year"] ."</td>";
echo "<td>$" . $userRow["price"]. "</td> </tr>";
}
echo "</table>";
} else{
  echo "No books found in your area";
}
$DBcon->close();

?>  

</div>


</body>
</html>