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
    <form method="post">
      <input type="text" name="player" placeholder="Search Summoner">
      <button title="Get Stats" type="submit">Go!</button>
    </form>
    <?php
       $bdd = new PDO(
       "mysql:host=sql2.olympe.in;dbname=SummonersName",
       "ubg3rl2q",
       "php");
       $player = $_POST['player'];
       bdd->exec('INSERT INTO SummonerName(Pseudo) VALUES ($player)');
 
   ?>
  </body>
</html>