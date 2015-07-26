<!doctype html>
<html>
<?php
error_reporting(0);
$sv = "all";
if ($_GET['v'] != null) $sv = $_GET['v'];
?>
<head>
  <meta charset="UTF-8">
   <meta name="theme-color" content="#33FF00">
  <link rel="stylesheet" href="style/styles.css"> 
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,400italic' rel='stylesheet' type='text/css'>
  <title>Moat - Mobile Voat Browser</title>

</head>

<body>
  <div id="feedback">
    <a href="about/">ABOUT</a>
  </div>

  <h1>Moat - /v/<?php echo $sv; ?></h1>
  <?php
  $cache = "chached.json"; //cache file
  $cacheTime = date("i", fileatime($cache)); //modified date of file
  $time = date("i");

//Refresh IF: time since last mod is more than 10 minutes, file doesn't exist, if nothing is in file
  //if ((($time - $cacheTime) / 5) % 5 || !file_exists($cache) || file_get_contents($cache) == null){
    $ch = curl_init();

//cURL Options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 1); 

//SSL Stuff
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //<- TEMPORARY
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "\\cert\\voatcert.crt");

//Last few options
curl_setopt($ch, CURLOPT_URL,"https://fakevout.azurewebsites.net/api/v1/v/" . $sv); //Placeholder sv
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json', 'Voat-ApiKey: Your_Api_Key_Here' ));
//--- 

$res = curl_exec ($ch);
file_put_contents($cache, $res);
curl_close ($ch);
//}else{ //If file is up to date, found, and not empty
// $res = file_get_contents($cache);
//}

$jdecode = json_decode($res, true); //decode the json into an array

if ($jdecode == null){ //If Voat is down or API mucks up
  echo '<div id="down">Voat seems to be down.</div>';
}

for($i = 0; $i < sizeof($jdecode['data']); $i++){ //basic for loop

  if ($jdecode['data'][$i]['title'] == null){
//In case title is null, so it doesn't generate empty posts
  }
  else{

/* Generates page of posts
* Format: 
* Title (Subverse)
* Poster name | Upvotes Downvotes
*/
echo '<div id="post">';
echo '<a href=post.php?sub=' . $jdecode['data'][$i]['subverse'] . "&id=" . $jdecode['data'][$i]['id'] . '>' . $jdecode['data'][$i]['title'] . '</a> ('
  . "<a href='?v=".$jdecode['data'][$i]['subverse']. "'>".$jdecode['data'][$i]['subverse'].'</a>)<br>';

echo '<a href=https://fakevout.azurewebsites.net/user/' . $jdecode['data'][$i]['userName'] . 
'>' . $jdecode['data'][$i]['userName'] . '</a> | ' . $jdecode['data'][$i]['upVotes'] . ' &#8593; '
. $jdecode['data'][$i]['downVotes'] . ' &#8595;';

echo "</div>\r\n<div id=spacer></div>";
}
}
?>

<div id="footer">
  <p>Moat &copy; Gabriel Simmer 2015</p>
</div>

</body>

</html>
