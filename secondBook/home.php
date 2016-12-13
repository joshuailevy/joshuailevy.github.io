<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Books near me</title>

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
            <li class="active"><a href="http://localhost/php-mysqli-login-signup/home.php">Books Near Me</a></li>
            <li><a href="http://localhost/php-mysqli-login-signup/selling.php">Sell A Book</a></li>
            <li><a href="http://localhost/php-mysqli-login-signup/mystore.php">My Store</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username']; ?></a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<div class="container" style="margin-top:60px;text-align:center;font-family:Verdana, Geneva, sans-serif;">
	<h3>Available books</h3><br>

<div id="mapholder"></div>
<p id="demo"></p>
<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showError);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

/*function showPosition(position) {
    var latlon = position.coords.latitude + "," + position.coords.longitude;

    var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="
    +latlon+"&zoom=14&size=400x300&sensor=false";
    document.getElementById("mapholder").innerHTML = "<img src='"+img_url+"'>";
}
*/
function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.")
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.")
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.")
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.")
            break;
    }
}
getLocation();
</script>

<div class="rightHalf col-md-7" style="font-size:12px">
<?php
$query = $DBcon->query("SELECT * FROM books");
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

<div class="leftHalf col-md-7" style="font-size:12px;text-align:left">
<form>
<fieldset>
<legend> Search for a book:</legend>
<div class="form-group col-xs-7">
<label for="dist">Search Radius(miles): </label>
<input class=" col-xs-7 form-control" type="range" min="1" max="10" value="2" step="1" onchange="showValue(this.value)" />
<script type="text/javascript">
function showValue(newValue)
{
  document.getElementById("range").innerHTML=newValue;
}
</script>
<p><span id="range">2</span> mi</p>
</div>
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
<input class="form-control" type="submit" value="Submit">
</div>
</fieldset>
</form>

</div>						      
</div>

</body>
</html>