  <!doctype html>
  <html>

  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/styles.css"> 
    <title>Moat - View Post</title>
  </head>

  <body>
    <h1>Moat - Mobile Voat</h1>

      <div id="feedback">
    <a href="/moat/">BACK</a>
  </div>
    <?php

    error_reporting(0);

    $ch = curl_init();

  //cURL Options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 1); 

  //SSL Stuff
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //<- TEMPORARY
  //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
  //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "\\cert\\voatcert.crt");

  //Last few options
  curl_setopt($ch, CURLOPT_URL,"https://fakevout.azurewebsites.net/api/v1/v/" . $_GET['sub'] . "/" . $_GET['id'] . "/comments");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json', 'Voat-ApiKey: lNic6rtZISv32D0jqofslA==' ));

  $ch2 = curl_init();

  //cURL Options
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c2, CURLOPT_VERBOSE, 1); 

  //SSL Stuff
  curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false); //<- TEMPORARY
  //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
  //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "\\cert\\voatcert.crt");

  //Last few options
  curl_setopt($ch2, CURLOPT_URL,"https://fakevout.azurewebsites.net/api/v1/v/" . $_GET['sub'] . "/" . $_GET['id'] );
  curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json', 'Voat-ApiKey: lNic6rtZISv32D0jqofslA==' ));
  //--- 

  $res = curl_exec ($ch);
  curl_close ($ch);

  $res2 = curl_exec ($ch2);
  curl_close ($ch2);

  $jdecode = json_decode($res, true);
  $jdecode2 = json_decode($res2, true);

  //print_r($jdecode);

  echo '<div id="postview">';

  echo '<div id="postcontent">' . $jdecode2['data']['formattedContent'] . '</div><div id="spacer2"></div>';

  for($i = 0; $i < sizeof($jdecode['data']); $i++){
    echo "\r\n";

    echo '<div id="comment">';

    echo $jdecode['data'][$i]['userName'] . " | " . $jdecode['data'][$i]['date'] . "<br>";

    echo $jdecode['data'][$i]['content'];

    echo "</div><div id='spacer'></div>";
  }
  ?>
  </div>

</body>

</html>
