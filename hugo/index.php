<!DOCTYPE HTML>

<!--   /\  /\_   _  __ _  ___     /\/\   __ _ _ __ ___ ___  __ _ _   _                                
      / /_/ / | | |/ _` |/ _ \   /    \ / _` | '__/ __/ _ \/ _` | | | |                               
     / __  /| |_| | (_| | (_) | / /\/\ \ (_| | | | (_|  __/ (_| | |_| |                               
     \/ /_/  \__,_|\__, |\___/  \/    \/\__,_|_|  \___\___|\__,_|\__,_|                               
                   |___/                                                 -->

<html lang="en">
  <title>LolPow</title>
  <head>

    <!-- Cascading Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/hugo.css" rel="stylesheet" type="text/css">
    <link href="css/dropdown.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">

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
          <a class="navbar-brand" href="/index.php">
            <img src="/res/ico/logo2.png">
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
	<P class="text-center"> Enter a summoner name and we will fetch the stats for the Account</p>
      </span>
      <span class="col-md-4">
      </span>  
    </div>

    <!-- Footer -->
    <div class="footer">
    </div>
  </div>
