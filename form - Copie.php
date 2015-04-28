<!DOCTYPE HTML>

<!--   /\  /\_   _  __ _  ___     /\/\   __ _ _ __ ___ ___  __ _ _   _                                
      / /_/ / | | |/ _` |/ _ \   /    \ / _` | '__/ __/ _ \/ _` | | | |                               
     / __  /| |_| | (_| | (_) | / /\/\ \ (_| | | | (_|  __/ (_| | |_| |                               
     \/ /_/  \__,_|\__, |\___/  \/    \/\__,_|_|  \___\___|\__,_|\__,_|                               
     |___/                                                 -->

<?php
  include 'class.php';
  $stats = new lolPow($_GET['region'], strtolower($_GET['player']), '?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41');
?>

     <html lang="en">
     <title>LolPow</title>
     <head>
      <meta charset="utf-8" />

      <!-- Cascading Stylesheets -->
      <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
      <link href="css/dropdown.css" rel="stylesheet" type="text/css">
      <link href="css/navbar.css" rel="stylesheet" type="text/css">
      <link href="css/hugo.css" rel="stylesheet" type="text/css">
      <link href="php.css" rel="stylesheet" type="text/css">

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
        <div class="text-center">
          <h1 class="text-center">LoL Scouter</h1>
          <p class="text-center"> Enter a summoner name and we will fetch the stats for the Account</p>
        </div>
        <div class="results">
          
          <!-- Results Pill -->
          <script>
            $('#myPill a').click(function (e) {
              e.preventDefault()
              $(this).tab('show')
            })
          </script>
          <div class="span12 centered-pills">
            <ul class="nav nav-pills" id="myPill">
              <li role="presentation"><a class="white" data-toggle="tab" href="#ingame">InGame</a></li>
              <li class="active" role="presentation"><a class="white" data-toggle="tab" href="#profile">Profile</a></li>
            </ul>
            <div class="tab-content">

              <div id="ingame" class="tab-pane fade">
                
                <div class="row">
                  <div class="col-sm-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title">Red Team</h3>
                      </div>
                      <div class="panel-body">
                        <?php
                        $player = $stats->spectate();
                        if ($player->httpCode == 200)
                        {
                          $i = 0;
                          $halfPlayer = round($player->i / 2) - 1;
                          while($i != ($halfPlayer + 1))
                          {
                            echo $player->summonerName[$i] . " ";
                            echo '<img src="/res/champions/' . $player->champName[$i] . '_Square_0.png" height="36" width="36">';
                            echo '<img src="/res/summoner_spells/' . $player->summSpell1[$i] . '.png" height="18" width="18">';
                            echo '<img src="/res/summoner_spells/' . $player->summSpell2[$i] . '.png" height="18" width="18">';
                            echo $player->tier . $player->div . $player->leaguePoint . $player->win . $player->lose . "<br>";
                            $i++;
                          }
                        }
                        else
                        {
                          echo 'No active game' . "<br>";
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title">General Information</h3>
                      </div>
                      <div class="panel-body">
                        Coming soon
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title">Blue Team</h3>
                      </div>
                      <div class="panel-body">
                        <?php
                        if ($player->httpCode == 200)
                        {
                          while($i != ($player->i + 1))
                          {
                            echo '<img src="/res/summoner_spells/' . $player->summSpell1[$i] . '.png" height="18" width="18">';
                            echo '<img src="/res/summoner_spells/' . $player->summSpell2[$i] . '.png" height="18" width="18">';
                            echo '<img src="/res/champions/' . $player->champName[$i] . '_Square_0.png" height="36" width="36">';
                            echo " " . $player->summonerName[$i] . "<br>";
                            $i++;
                          }
                        }
                        else
                        {
                          echo 'No active game' . "<br>";
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>  
              </div>
              
              <div id="profile" class="tab-pane fade in active">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title">Stats</h3>
                      </div>
                      <div class="panel-body">
                        <?php
                        if ($stats->httpCode == 200)
                        {
                          echo $stats->summonerName . "<br>";
                          echo 'Level ' . $stats->level . "<br>";
                        }
                        else
                        {
                          echo 'Player doesn\'t exist' . "<br>";
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title">Ranking</h3>
                      </div>
                      <div class="panel-body">
                        <?php
                        if ($stats->httpCode == 200)
                        {
                          if ($stats->level == 30)
                          {
                            $elo = $stats->rank();
                            if ($elo->httpCode == 200 && $stats->httpCode == 200)
                            {
                              echo $elo->leagueName . ' ' . $elo->leagueDiv . "<br>";
                              echo $elo->leaguePoint . 'LP' . "<br>";
                              echo 'Wins : ' . $elo->winSolo . "<br>";
                              echo 'Loses : ' . $elo->loseSolo . "<br>"; 
                            }
                            else if ($elo->httpCode != 200 && $stats->httpCode == 200)
                            {
                              echo 'Player never played ranked' . "<br>";
                            }
                            else
                            {
                              echo 'Player doesn\'t exist' . "<br>";
                            }
                          }
                          else
                          {
                            echo 'Player not level 30' . "<br>";
                          }
                        }
                        else
                        {
                          echo 'Player doesn\'t exist' . "<br>";
                        }

                        
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title">Other</h3>
                      </div>
                      <div class="panel-body">
                        Coming soon
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="footer">
        <p class="text-center"><font color="white">Website in development. If you want to see a new feature, report a bug or anything else, send us a message at : tekpow.contact@gmail.com</font></p>
      </div>
    </div>