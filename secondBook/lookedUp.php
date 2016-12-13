<?php
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$DBcon->close();

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
            <li><a href="http://localhost/php-mysqli-login-signup/mystore.php">Books I&#39m selling</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username']; ?></a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<div class="container" style="margin-top:60px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
  <h2> Sell some books </h2>
<div class="leftHalf" style="text-align:center">
<article>
Enter the ISBN code for your book:<br>
<form action="lookedUp.php" method="post">
<input type="text" name="ISBN"> <br>
<input type="submit" value="Submit">
</form>
</article>
</div>
<div class="rightHalf" style="text-align:center">

<?php
// Your AWS Access Key ID, as taken from the AWS Your Account page
$aws_access_key_id = "AKIAJ25NYKHRWXNGNQFA";

// Your AWS Secret Key corresponding to the above ID, as taken from the AWS Your Account page
$aws_secret_key = "WGKk1a9cF3AE5OwkZO4EYynsaZc4jrdyEsloMT7h";

// The region you are interested in
$endpoint = "webservices.amazon.com";

$uri = "/onca/xml";

$params = array(
    "Service" => "AWSECommerceService",
    "Operation" => "ItemLookup",
    "AWSAccessKeyId" => "AKIAJ25NYKHRWXNGNQFA",
    "AssociateTag" => "secondbook-20",
    "IdType" => "ISBN",
    "ItemId" => $_POST['ISBN'],
    "SearchIndex" => "Books",
    "ResponseGroup" => "Images,ItemAttributes,OfferSummary"
);

// Set current timestamp if not set
if (!isset($params["Timestamp"])) {
    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
}

// Sort the parameters by key
ksort($params);

$pairs = array();

foreach ($params as $key => $value) {
    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
}

// Generate the canonical query
$canonical_query_string = join("&", $pairs);

// Generate the string to be signed
$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

// Generate the signature required by the Product Advertising API
$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

// Generate the signed URL
$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

if (($response_xml_data = file_get_contents($request_url))===false){
    echo "Error fetching XML\n";
} else {
   libxml_use_internal_errors(true);
   $data = simplexml_load_string($response_xml_data);
   if (!$data) {
       echo "Error loading XML\n";
   } else {

     //print_r($data);
   }
}
   $pic = $data->Items->Item[0]->ImageSets->ImageSet[0]->MediumImage->URL;

?>
<article>
<a href=<?php echo $data->Items->Item[0]->DetailPageURL;?>>
<img src=<?php echo $pic; ?>> <br></br>
New Price: <?php echo $data->Items->Item[0]->OfferSummary->LowestNewPrice->FormattedPrice; ?> <br></br>
Used Price: <?php echo $data->Items->Item[0]->OfferSummary->LowestUsedPrice->FormattedPrice; ?>
<a>
</article>

</div>
</div>
</body>
</html>