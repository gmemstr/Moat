  <!doctype html>
  <html>

  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/styles.css"> 
    <title>Moat - Mobile Voat Browser</title>
  </head>

  <body>
    <h1>Moat - Mobile Voat Browser (/v/API placeholder)</h1>
    <?php

    //error_reporting(0);

    $ch = curl_init();

  // cURL Options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 1); 

  //SSL Stuff
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //<- TEMPORARY
  //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
  //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "\\cert\\voatcert.crt");

  //Last few options
  curl_setopt($ch, CURLOPT_URL,"https://fakevout.azurewebsites.net/api/v1/v/api");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json', 'Voat-ApiKey: ' ));
  //--- 

  $res = curl_exec ($ch);
  curl_close ($ch);

  //Debug echo $res;

  $jdecode = json_decode($res, true);
  //print_r($jdecode);
  /*$title = $jdecode["title"];
  $sub = $jdecode["subverse"];
  $id = $jdecode["id"];
  $name = $jdecode["userName"];
  $likes = $jdecode["upVotes"];
  $dislikes = $jdecode["downVotes"];*/

  for($i = 0; $i < sizeof($jdecode['data']); $i++){

    if ($jdecode['data'][$i]['title'] == null){
    //Do nothing
    }
    else{
      echo '<div id="post">';

      echo '<a href=https://fakevout.azurewebsites.net/v/' . $jdecode['data'][$i]['subverse'] . 
      '/comments/' . $jdecode['data'][$i]['id'] . '>' . $jdecode['data'][$i]['title'] . '</a><br>';

      echo '<a href=https://fakevout.azurewebsites.net/user/' . $jdecode['data'][$i]['userName'] . 
      '>' . $jdecode['data'][$i]['userName'] . '</a> | ' . $jdecode['data'][$i]['upVotes'] . ' &#8593; '
       . $jdecode['data'][$i]['downVotes'] . ' &#8595;';

      echo '</div><div id=spacer></div>';
    }
  }
  ?>

</body>

</html>
