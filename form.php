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
    <link href="res/ico/Tray_32.png" rel="shortcut icon">

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

        <form class="navbar-form navbar-right" method="get" action="form.php">
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

      class lolPow
      {
        public $region;
        public $player;
        public $api_key;
        public $onetwo;
        public $onethree;
        public $onefour;
        public $twotwo;
        public $twofour;
        public $twofive;
        public $summId;

        public function __construct($region, $player, $api_key)
        {
          $this->region = $region;
          $this->player = $player;
          $this->api_key = $api_key;
          $this->onetwo = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.2/';
          $this->onethree = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.3/';
          $this->onefour = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.4/';
          $this->twotwo = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.2/';
          $this->twofour = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.4/';
          $this->twofive = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.5/';
        }
  
        public function askApi($url)
        {
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $infos = curl_exec($ch);
          curl_close($ch);
          return $infos;
        }

        public function getSummonerId()
        {
          $url = $this->onefour . 'summoner/by-name/' . $this->player . $this->api_key;
          $data = $this->askApi($url);
          $result = json_decode($data);
          $player = $this->player;
          $this->summId = $result->$player->id;
        }

        public function regionToSpectate()
        {
          $this->getSummonerId();
          switch ($this->region)
          {
            case 'euw':
            $platformId = 'EUW1';
            break;

            case 'na':
            $platformId = 'NA1';
            break;

            default:
            break;
          }
          return ('https://' . $this->region . '.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/' . $platformId . '/' . $this->summId . $this->api_key);
        }

        public function spectate()
        {
          $url = $this->regionToSpectate();
          $data = $this->askApi($url);
          $result = json_decode($data);
          foreach ($result->participants as $name)
          {
            echo $name->summonerName . " - ";
            $champ_data = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region . '/v1.2/champion/' . $name->championId . $this->api_key);
            $champ = json_decode($champ_data);
            echo $champ->name . " - ";
            $summSpell = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region .'/v1.2/summoner-spell/' . $name->spell1Id . $this->api_key);
            $summSpell1 = json_decode($summSpell);
            $summSpell = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region .'/v1.2/summoner-spell/' . $name->spell2Id . $this->api_key);
            $summSpell2 = json_decode($summSpell);
            echo $summSpell1->name . " & " . $summSpell2->name . " / \n";
          }
        }  
      }
      
      /*
      TODO : Gérer les pseudos avec un espace
      */

      echo strtolower($_GET['player']);
      
      $stats = new lolPow($_GET['region'], strtolower($_GET['player']), '?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41');
      $stats->spectate();
      
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
