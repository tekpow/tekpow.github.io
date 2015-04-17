<!DOCTYPE HTML>

<!--   /\  /\_   _  __ _  ___     /\/\   __ _ _ __ ___ ___  __ _ _   _                                
      / /_/ / | | |/ _` |/ _ \   /    \ / _` | '__/ __/ _ \/ _` | | | |                               
     / __  /| |_| | (_| | (_) | / /\/\ \ (_| | | | (_|  __/ (_| | |_| |                               
     \/ /_/  \__,_|\__, |\___/  \/    \/\__,_|_|  \___\___|\__,_|\__,_|                               
              |___/                                                      -->

<html lang="en">
  <title>LolPow</title>
  <head>
  </head>

  <body>
    <?php
       $player = $_POST['player'];
       echo $player;

       $url = 'https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/' . $player . '?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41';
       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $infos = curl_exec($ch);
       curl_close($ch);

       echo $infos;
    ?>
  </body>
</html>
