<!DOCTYPE HTML>

<!--   /\  /\_   _  __ _  ___     /\/\   __ _ _ __ ___ ___  __ _ _   _                                
      / /_/ / | | |/ _` |/ _ \   /    \ / _` | '__/ __/ _ \/ _` | | | |                               
     / __  /| |_| | (_| | (_) | / /\/\ \ (_| | | | (_|  __/ (_| | |_| |                               
     \/ /_/  \__,_|\__, |\___/  \/    \/\__,_|_|  \___\___|\__,_|\__,_|                               
                   |___/                                                 -->

<html lang="en">
	<title>LolPow</title>

	<head>
	</head>

	<body>
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
				curl_setopt($ch, CurlOPT_RETURNTRANSFER, 1);
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
	</body>
</html>
