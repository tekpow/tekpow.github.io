<!DOCTYPE HTML>

<!--   /\  /\_   _  __ _  ___     /\/\   __ _ _ __ ___ ___  __ _ _   _                                
      / /_/ / | | |/ _` |/ _ \   /    \ / _` | '__/ __/ _ \/ _` | | | |                               
     / __  /| |_| | (_| | (_) | / /\/\ \ (_| | | | (_|  __/ (_| | |_| |                               
     \/ /_/  \__,_|\__, |\___/  \/    \/\__,_|_|  \___\___|\__,_|\__,_|                               
                   |___/                                                 -->

<html lang="en">
  <title>LolPow</title>
  <head>
    <meta charset="utf-8" />

    <!-- Cascading Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="php.css" rel="stylesheet" type="text/css">
    <link href="css/dropdown.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/hugo.css" rel="stylesheet" type="text/css">

    <!-- Site Icon -->
    <link href="/res/ico/Tray_32.png" rel="shortcut icon">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </head>

  <div class="all">

    <!-- NavBar -->
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">

        <div class="navbar-header">
          <a class="navbar-brand" href="file:///home/villev_h/HTML/website/hugo/my_website.html">
            <img src="../res/ico/logo2.png">
          </a>
        </div>

        <form class="navbar-form navbar-right" method="post" action="form.php">
          <div class="form-group">

            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-primary active">
                <input type="radio" name="region" value="euw" id="option1" autocomplete="off" checked> EUW
              </label>
              <label class="btn btn-primary">
                <input type="radio" name="region" value="na" id="option2" autocomplete="off"> NA
              </label>
            </div>

            <input type="text" class="form-control" name="player" placeholder="Search Summoner">
            <button title="Get Stats" type="submit" class="btn btn-default">Go!</button>
          </div>
        </form>
      </div>
    </nav>

    <!-- Jumbotron -->
    <div class="jumbotron">
    	<span class="col-md-4">
    	</span>
    	<span class="col-md-4">
    		<h1 class="text-center">LoL Scouter</h1>
    		<p class="text-center"> Enter a summoner name and we will fetch the stats for the Account</p>
        <p>
      <?php  
      $region = 'euw';
      $player = $_POST['player'];
      $summId = 28954491;
      $api_key = '?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41';

      $v1_2 = 'https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v1.2/';
      $v1_3 = 'https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v1.3/';
      $v1_4 = 'https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v1.4/';
      $v2_2 = 'https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v2.2/';
      $v2_4 = 'https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v2.4/';
      $v2_5 = 'https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v2.5/';

      function askApi($url)
      {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $infos = curl_exec($ch);
        curl_close($ch);
        return $infos;
      }

      function getSummonerId($v1_4, $player, $api_key)
      {
        $url = $v1_4 . 'summoner/by-name/' . $player . $api_key;
        echo $url;
        $data = askApi($url);
        echo $data;
      }

      function getMatchHistory($v2_2, $summId, $api_key)
      {
        $url = $v2_2 . 'matchhistory/' . $summId . $api_key;
        echo $url;
        $data = askApi($url);
        echo $data;
      }

      getSummonerId($v1_4, $player, $api_key);
      
      ?>
        </p>
    		</span>
    		<span class="col-md-4">
    		</span>
    	</div>

    	<!-- Footer -->
    	<div class="footer">
   	</div>
</div>
