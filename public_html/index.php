<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style/styles.css"> 
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,400italic' rel='stylesheet' type='text/css'>
  <title>Moat - Mobile Voat Browser</title>

</head>

<body>
  <div id="feedback">
    <a href="about/">ABOUT</a>
  </div>

  <h1>Moat - Mobile Voat (/v/all placeholder)</h1>
  <?php
  $cache = "chached.json"; //cache file
  $cacheTime = date("i", fileatime($cache)); //modified date of file
  $time = date("i");

  error_reporting(0);

//Refresh IF: time since last mod is more than 10 minutes, file doesn't exist, if nothing is in file
  if (($cacheTime - $time) > 10 || !file_exists($cache) || file_get_contents($cache) == null){
    $ch = curl_init();

//cURL Options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 1); 

//SSL Stuff
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //<- TEMPORARY
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "\\cert\\voatcert.crt");

//Last few options
curl_setopt($ch, CURLOPT_URL,"https://fakevout.azurewebsites.net/api/v1/v/all"); //Placeholder sv
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json', 'Voat-ApiKey: lNic6rtZISv32D0jqofslA==' ));
//--- 

$res = curl_exec ($ch);
file_put_contents($cache, $res);
curl_close ($ch);
}else{ //If file is up to date, found, and not empty
  $res = file_get_contents($cache);
}

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
  .$jdecode['data'][$i]['subverse'].')<br>';

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
